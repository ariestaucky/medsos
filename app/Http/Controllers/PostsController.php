<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\NewLike;
use Notification;
use App\User;
use App\Post;
use App\Followable;
use App\Favorite;
use DB;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|string|max:255',
        ]);

        // Create Post
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->content = $request->input('content');
        $post->post_type = !empty($request->input('post_type'))? $request->input('post_type') : 'public';
        
        $post->save();
          
        return redirect()->back()->with('success', 'Poster Created');
    }

    public function fav($id)
    {
        $post = Post::findorFail($id);
        // Save Favorite Post
        $fav = new Favorite;
        $fav->user_id = auth()->user()->id;
        $fav->post_owner = $post->user_id;
        
        $post->fav()->save($fav);
          
        return redirect()->back()->with('success', 'Save as Favorite');
    }

    public function unfav($id)
    {
        $unfav = Favorite::where('pos_id', $id)->where('pos_type', 'App\Post')->first();
        // Check for correct user
        if(auth()->user()->id !== $unfav->user_id){
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $unfav->delete();

        return redirect()->back()->with('success', 'Unfavorite Success');
    }

    public function block($id)
    {
        $post = Post::findorFail($id);
        $user = auth()->user();

        $user->block($post);
          
        return redirect()->back()->with('success', 'Poster blocked');
    }

    public function unblock($id)
    {
        $post = Post::findorFail($id);
        $user = auth()->user();
        
        $user->unblock($post);

        return redirect()->back()->with('success', 'Unblock Success');
    }

    public function wall(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required|string|max:255',
        ]);

        $wall = new Post;
        // Save
        $wall->waller_id = auth()->user()->id;
        $wall->user_id = $id;
        $wall->content = $request->input('content');

        $wall->save();
          
        return redirect()->back()->with('success', 'Wall Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findorFail($id);

        return view('post.post', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $post = Post::findOrFail($id);

        $this->validate($request, [
            'content' => 'required|string|max:255',
        ]);

        $post->content = $request->input('content');
        $post->post_type = !empty($request->input('post_type'))? $request->input('post_type') : 'public';
        
        $post->save();
          
        return redirect()->back()->with('success', 'Poster Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findorFail($id);
        // Check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        if($post->comments()->delete()){
            Comments::where('fromPost_id', $id)->delete();
            Favorite::where('pos_id', $id)->delete();
            Followable::where('followable_id', $id)->where('followable_type', 'App\Post')->delete();
        }

        $post->delete();

        return redirect()->back()->with('success', 'Post Removed');
    }

    public function ajaxRequestLike(Request $request){

        $post = Post::find($request->id);
        
        if($done = auth()->user()->toggleLike($post)){

            if(auth()->user()->hasLiked($post)) {
                // notification
                $notify_user = User::findorFail($post->user_id);
                $liker = auth()->user();

                if($notify_user->id !== $liker->id) {
                    if(empty($post->waller_id)) {
                        $notify_user->notify(new NewLike($liker, $post));
                    } else {
                        $first = User::where('id', $post->waller_id);
                        $users = User::where('id', $post->user_id)
                        ->union($first)
                        ->get();

                        Notification::send($users, new NewLike($liker, $post));
                    } 
                } 
            } else {
                // delete notification
                $liker = auth()->user();
                $post->user->notifications()
                        ->where('type', 'App\Notifications\NewLike')
                        ->where(DB::raw('JSON_EXTRACT(`data`, "$.liker_id")'), $liker->id)
                        ->delete();
            }

            $response = array();
            $response[0] = ['s'=>$done];
            $response[1] = ['id'=>$request->id];
        }
        
        return response()->json(['sukses'=>$response],200);
    }

    public function ajaxRequestIns(Request $request){

        $pos = $request->id;
        $post = Post::findorFail($request->id);
        $post_owner = $post->user_id;
        $user = auth()->user()->id;
        $follow = Followable::where(['user_id' => $user, 'followable_id' => $pos, 'followable_type' => 'App\Post'])
                                ->update(['notify'=>$post_owner]);
        
        // return view('posts.show');
        return response()->json(['success'],200);
    }
}
