<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Post;
use App\Image;
use App\Visitor;
use App\Follower;
use App\Favorite;
use Carbon\Carbon;
use File;
use DB;
use App\Notifications\NewFollower;
use Illuminate\Support\Facades\Notification;
use Abraham\TwitterOAuth\TwitterOAuth;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $first = Post::select('posts.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', 'posts.content as content', 'posts.waller_id as waller_id', 'posts.created_at as posted', DB::raw('null as images, null as caption'))
        ->join('users', 'users.id', 'posts.user_id')
        ->where('users.id', auth()->user()->id)
        ->whereNotIn('posts.id', function($k){
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', auth()->user()->id)
                ->where('blockable_type', 'App\Post');
        })
        ->orWhere('posts.waller_id', auth()->user()->id)
        ->orWhere(function($query){
            $query->whereIn('users.id', function($q){
                $q->select('followable_id')
                ->from('followers')
                ->where('follower_id', auth()->user()->id)
                ->where('posts.post_type', '!=', 'me');
            });
        });

        $post = Image::select('images.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', DB::raw('null as content, null as waller_id'), 'images.created_at as posted', 'images.image as images', 'images.caption as caption')
        ->join('users', 'users.id', 'images.user_id')
        ->where('users.id', auth()->user()->id)
        ->whereNotIn('images.id', function($k){
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', auth()->user()->id)
                ->where('blockable_type', 'App\Image');
        })
        ->orWhere(function($query){
            $query->whereIn('users.id', function($q){
                $q->select('followable_id')
                ->from('followers')
                ->where('follower_id', auth()->user()->id)
                ->where('images.post_type', '!=', 'me');
            });
        })
        ->union($first)
        ->orderby('posted', 'desc')
        ->paginate(10);
        
        if($request->ajax()) {
            return [
                'posts' => view('post.ajax.index')->with(compact('post'))->render(),
                'next_page' => $post->nextPageUrl()
            ];
        }

        $friend = User::where('id', '!=', auth()->user()->id)->inRandomOrder()->take(8)->get();
        $post_count = Post::where('user_id', auth()->user()->id)->get()->count();
        $all = User::get();
        $count = 1;

        return view('home', compact('post', 'friend', 'post_count', 'all', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $first = Post::select('posts.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', 'posts.content as content', 'posts.waller_id as waller_id', 'posts.created_at as posted', DB::raw('null as images, null as caption'))
        ->join('users', 'users.id', 'posts.user_id')
        ->where('users.id', auth()->user()->id)
        ->orWhere('posts.waller_id', auth()->user()->id);

        $poster = Image::select('images.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', DB::raw('null as content, null as waller_id'), 'images.created_at as posted', 'images.image as images', 'images.caption as caption')
        ->join('users', 'users.id', 'images.user_id')
        ->where('users.id', auth()->user()->id)
        ->union($first)
        ->orderby('posted', 'desc')
        ->paginate(10);

        $post = $poster;

        $visitor = Visitor::where('user_page', auth()->user()->id)
                            ->where('created_at', '>', Carbon::now()->subDay(7))
                            ->select('visitor', 'created_at', DB::raw('count(visitor) as total'))
                            ->groupBy('visitor')
                            ->orderBy('created_at', 'desc')
                            ->take(8)
                            ->get();
                            
        $album = Image::where('user_id', auth()->user()->id)->get();
        $fav = Favorite::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);

        // foreach($fav->sortBy('created_at') as $f) {
        //     dd($f->pos->content);
        // }
        
        if($request->ajax()) {
            return response()->json([
                'fav' => view('post.ajax.fav')->with(compact('fav'))->render(),
                'next' => $fav->nextPageUrl(),

                'posts' => view('post.ajax.index')->with(compact('post'))->render(),
                'next_page' => $post->nextPageUrl()
            ], 200);
        }

        return view('user.dashboard', compact('poster', 'visitor', 'album', 'fav'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $user = User::findOrFail(auth()->user()->id);

        $validator = Validator::make($request->all(), [
            'file' => 'image|mimes:jpg,jpeg,png|required|max:1099'
        ]);
        
        if ($validator->fails()) 
        {
            $msg = "Error! Image must be JPG, JPEG or PNG max size 1Mb";
            return response()->json(['error'=>$msg]);
        }

        // Handle File Upload
        $NameArray = explode(' ',$user->name);
        $first_name = $NameArray[0];

        // Get filename with the extension
        $filenameWithExt = $request->file('file')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('file')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore= "bg-image_".trim(strtolower($first_name)).trim(substr(time(), 0,4)).time().".".$extension; 
        // Upload Image
        $path = $request->file('file')->move('public/bg_images', $fileNameToStore);

        
        // Create Post
        if($user->bg_image != 'default-background.jpg'){
            // Delete Image (use this if online)
            // Storage::delete('public/bg_images/'.$user->bg_image);  
            // temporary for offline
            File::delete(public_path().'/public/bg_images/'.$user->bg_image);   
        } 

        $user->bg_image = $fileNameToStore; 
        $user->save();

        $uploaded = asset('/public/bg_images/'.$user->bg_image);

        // $notif =$this->notif();
        // $notify = $this->notify();

        return response()->json(['success'=>$uploaded],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::findorFail($id);

        $first = Post::select('posts.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', 'posts.content as content', 'posts.waller_id as waller_id', 'posts.created_at as posted', DB::raw('null as images, null as caption'), 'posts.post_type as type')
        ->join('users', 'users.id', 'posts.user_id')
        ->where('users.id', $id)
        ->whereNotIn('posts.id', function($k) use($user) {
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', $user->id)
                ->where('blockable_type', 'App\Post');
        })
        ->orWhere('posts.waller_id', $id);

        $poster = Image::select('images.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', DB::raw('null as content, null as waller_id'), 'images.created_at as posted', 'images.image as images', 'images.caption as caption', 'images.post_type as type')
        ->join('users', 'users.id', 'images.user_id')
        ->where('users.id', $id)
        ->whereNotIn('images.id', function($k) use($user) {
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', $user->id)
                ->where('blockable_type', 'App\Image');
        })
        ->union($first)
        ->orderby('posted', 'desc')
        ->paginate(10); 

        // foreach($post as $p){dd($p->waller->name, $p->user_id);};

        if(!$user) {
            // $check = Visitor::where('visitor', auth()->user()->id)
            //                     ->where('user_page', $user->id)
            //                     ->first();
            // if($check){
            //     $check->increment('view');
            //     $check->save();
            // } else {
            $visitor = new Visitor;
            $visitor->visitor = auth()->user()->id;
            $visitor->user_page = $user->id;
            $visitor->save();
            // }

            $user->increment('page_view');
            $user->save();
        }
        
        $fav = Favorite::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(10);
        
        if($request->ajax()) {
            return response()->json([
                'fav' => view('post.ajax.fav')->with(compact('fav'))->render(),
                'next' => $fav->nextPageUrl(),

                'posts' => view('post.ajax.profile')->with(compact('poster'))->render(),
                'next_page' => $post->nextPageUrl()
            ], 200);
        }

        $friends = $user->followers()->take(5)->get();
        $album = Image::where('user_id', $id)->get();
        
        return view('profile', compact('user', 'poster', 'friends', 'album', 'fav'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        // Check for correct user
        if(auth()->user()->id != $id){
            return redirect('home')->with('error', 'Unauthorized Page');
        };
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'motto' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:255',
            'gender' => 'required',
            'status' => 'required',
            'birthday' => 'required',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:255',
            'pic' => 'image|nullable|max:599'
        ]);
        if ($validator->fails()) 
        {
            return redirect()->to(route('edit', [$id]))
                        ->withErrors($validator)
                        ->withInput();
        }

        // Handle File Upload
        if($request->hasFile('pic')){
            $NameArray = explode(' ',$user->name);
            $first_name = $NameArray[0];

            // Get filename with the extension
            $filenameWithExt = $request->file('pic')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('pic')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= "avatar_".trim(strtolower($first_name)).trim(substr(time(), 0,4)).time().'.'.$extension;
            // Upload Image
            $path = $request->file('pic')->move('public/cover_image', $fileNameToStore);
        }
        
        // Create Post
        $user->name = $request->input('firstname').' '.$request->input('lastname');
        $user->fname = $request->input('firstname');
        $user->lname = $request->input('lastname');
        $user->motto = $request->input('motto');
        $user->bio = $request->input('bio');
        $user->gender = $request->input('gender');
        $user->status = $request->input('status');
        $user->bday = $request->input('birthday');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->country = $request->input('country');
        $user->job = $request->input('job');
        if($request->hasFile('pic')){
            if($user->profile_image != 'default.jpg'){
                // Delete Image (use this if online)
                // Storage::delete('public/cover_images/'.$user->profile_image);  
                // temporary for offline
                File::delete(public_path().'/public/cover_image/'.$user->profile_image);   
            } 
            $user->profile_image = $fileNameToStore;  
        }
        $user->save();
        
        // $notif =$this->notif();
        // $notify = $this->notify();

        return redirect()->route('profile', [auth()->user()->id])->with('success', 'Profile Updated');
    }

    public function password()
    {
        return view('user.social');
    }

    public function complete(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) 
        {
            return redirect()->to(route('password'))
                        ->withErrors($validator)
                        ->withInput();
        }
        
        // Update password
        $user->password = Hash::make($request->input('password'));
        $user->save();
        
        // $notif =$this->notif();
        // $notify = $this->notify();

        return redirect()->route('home')->with('success', 'Successfully registrated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request) 
    {   
        $searchTerm = $request->input('search');

        if($searchTerm == null) {
            $search = User::search(auth()->user()->name)->paginate(10);
        } else {
            $search = User::search($searchTerm)->inRandomOrder()->orderBy('updated_at','desc')->paginate(10);
        }

        return view('search', compact('search', 'searchTerm'));
    }

    public function ajaxRequest(Request $request){
        $follower = auth()->user();
        $user = User::find($request->user_id);

        $check = $follower->isFollowing($user);

        if($check == false){
            $follow = $follower->follow($user);

            $user->increment('follower');
            $user->save();

            $user->notify(new NewFollower($follower));
            
            return response()->json(['follow'=>$follow],200);
        } else {
            $unfollow = $follower->unfollow($user);

            $user->decrement('follower');
            $user->save();

            // delete notification
            $user->notifications()
                    ->where('type', 'App\Notifications\NewFollower')
                    ->where(DB::raw('JSON_EXTRACT(`data`, "$.follower_id")'), $follower->id)
                    ->delete();

            return response()->json(['unfollow'=>$unfollow],200);
        }

    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->where('type', '<>', 'App\Notifications\NewMessage')->limit(5)->get()->toArray();
    }

    public function follower($id)
    {
        session(['link' => url()->previous()]);

        $user = User::findorFail($id);
        $follower = $user->followers()->paginate(10);

        return view('follower')->with(compact('follower'));
    }

    public function following($id)
    {
        session(['link' => url()->previous()]);

        $user = User::findorFail($id);
        $following = $user->following()->paginate(10);

        return view('follower')->with(compact('following'));
    }

    public function history($id)
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at','desc')->get()->toArray();

        return view('history', compact('notifications'));
    }

    public function share($id)
    {
        $auth_user = Auth()->user();
        $post = Post::where('id', $id)->first();

        if($auth_user->provider == 'twitter' or $auth_user->token <> null) 
        {
            $connection = new TwitterOAuth(
                'hTRW7uAukoVvAXFzgxYpWDluo',
                '39MEtImipE5YDWdyeNDOVnlS2zJ3Z3YrtBBuEONf1EXJ08Zobi',
                $auth_user->token, // You get token from user, when him  sigin to your app by twitter api
                $auth_user->secret // You get tokenSecret from user, when him  sigin to your app by twitter api
            );
            
            $statues = $connection->post("statuses/update", ["status" => $post->content]);

            if ($connection->getLastHttpCode() == 200) {
                return redirect()->back()->with('success', 'Poster shared!');
            } else {
                return redirect()->back()->with('error', 'Error! Please try again later!');
            }
        } 
        else 
        {
            return redirect()->route('linked')->with('error', 'You have not linked your twitter account');
        } 
    }

    public function sharing($id)
    {
        $auth_user = Auth()->user();
        $post = Image::where('id', $id)->first();

        if($auth_user->provider == 'twitter' or $auth_user->token <> null) 
        {
            $connection = new TwitterOAuth(
                'hTRW7uAukoVvAXFzgxYpWDluo',
                '39MEtImipE5YDWdyeNDOVnlS2zJ3Z3YrtBBuEONf1EXJ08Zobi',
                $auth_user->token, // You get token from user, when him  sigin to your app by twitter api
                $auth_user->secret // You get tokenSecret from user, when him  sigin to your app by twitter api
            );
            
            $media = $connection->upload("media/upload", ["media" => "public/user_album/".$post->image]);

            $parameters = [
                'status' => $post->caption,
                'media_ids' => implode(',', [$media->media_id_string])
            ];
            
            $result = $connection->post('statuses/update', $parameters);

            if ($connection->getLastHttpCode() == 200) {
                return redirect()->back()->with('success', 'Poster shared!');
            } else {
                return redirect()->back()->with('error', 'Error! Please try again later!');
            }
        } 
        else 
        {
            return redirect()->route('linked')->with('error', 'You have not linked your twitter account');
        } 
    }

    public function shareIt($id)
    {
        $auth_user = Auth()->user();
        $user = User::where('id', $id)->first();

        if($auth_user->provider == 'twitter' or $auth_user->token <> null) 
        {
            $connection = new TwitterOAuth(
                'hTRW7uAukoVvAXFzgxYpWDluo',
                '39MEtImipE5YDWdyeNDOVnlS2zJ3Z3YrtBBuEONf1EXJ08Zobi',
                $auth_user->token, // You get token from user, when him  sigin to your app by twitter api
                $auth_user->secret // You get tokenSecret from user, when him  sigin to your app by twitter api
            );
            
            $statues = $connection->post("statuses/update", ["status" => route('profile', $user->id)]);

            if ($connection->getLastHttpCode() == 200) {
                return redirect()->back()->with('success', 'Poster shared!');
            } else {
                return redirect()->back()->with('error', 'Error! Please try again later!');
            }
        } 
        else 
        {
            return redirect()->route('linked')->with('error', 'You have not linked your twitter account');
        } 
    }
    
    public function linked()
    {
        $user = Auth()->user();

        return view('linked', compact('user'));
    }

    // public function ajaxNotif(Request $request) {
    //     $user = User::findorFail($request->id);
    //     $follower = auth()->user();
    //     Notification::send($user, new NewFollower($follower));
    //     // if($follower->isFollowing($user)) {
    //     //     // $user->notify(new NewFollower($follower));
    //     //     Notification::send($user, new NewFollower($follower));
    //     // }
    //     // dump($follow);
    //     // return view('user.public');
    //     return response()->json(['success'=>$user],200);
    // }
}
