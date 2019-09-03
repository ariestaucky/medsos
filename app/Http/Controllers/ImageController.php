<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ImageLike;
use App\Image;
use App\User;
use App\Followable;
use App\Favorite;

class ImageController extends Controller
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
            'caption' => 'nullable|string|max:255',
            'image' => 'image|required|max:1999',
        ]);

        // Get filename with the extension
        $filenameWithExt = $request->file('image')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->file('image')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore= $filename.'_'.time().'.'.auth()->user()->username.'.'.$extension;
        // Upload Image
        $path = $request->file('image')->move('public/user_album', $fileNameToStore);

        $image = new Image;
        $image->user_id = auth()->user()->id;
        $image->image = $fileNameToStore; 
        $image->caption = $request->input('caption');
        $image->post_type = !empty($request->input('post_type'))? $request->input('post_type') : 'public';

        $image->save();

        return redirect()->back()->with('success', 'Images uploaded');
    }

    public function fav($id)
    {
        $img = Image::findorFail($id);
        // Save Favorite Post
        $fav = new Favorite;
        $fav->user_id = auth()->user()->id;
        $fav->post_owner = $img->user_id;
        
        $img->fav()->save($fav);
          
        return redirect()->back()->with('success', 'Save as Favorite');
    }

    public function unfav($id)
    {
        $unfav = Favorite::where('pos_id', $id)->where('pos_type', 'App\Image')->first();
        // Check for correct user
        if(auth()->user()->id !== $unfav->user_id){
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $unfav->delete();

        return redirect()->back()->with('success', 'Unfavorite Success');
    }

    public function block($id)
    {
        $post = Image::findorFail($id);
        $user = auth()->user();

        $user->block($post);
          
        return redirect()->back()->with('success', 'Image blocked');
    }

    public function unblock($id)
    {
        $post = Image::findorFail($id);
        $user = auth()->user();
        
        $user->unblock($post);

        return redirect()->back()->with('success', 'Unblock Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Image::findorFail($id);

        return view('post.image', compact('post'));
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
        $img = Image::findOrFail($id);

        $this->validate($request, [
            'caption' => 'required|string|max:255',
        ]);

        $img->content = $request->input('caption');
        $img->post_type = !empty($request->input('post_type'))? $request->input('post_type') : 'public';
        
        $img->save();
          
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
        $image = Image::findorFail($id);
        // Check for correct user
        if(auth()->user()->id !== $image->user_id){
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        if($image->comments()->delete()){
            Comments::where('fromPost_id', $id)->delete();
            Favorite::where('pos_id', $id)->delete();
            Followable::where('followable_id', $id)->where('followable_type', 'App\Image')->delete();
        }

        // Delete Image
        Storage::delete('public/user_album/'.$image->image);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted');
    }

    public function ajaxRequestLove(Request $request){

        $image = Image::find($request->id);

        if($done = auth()->user()->toggleLike($image)){

            $response = array();
            $response[0] = ['s'=>$done];
            $response[1] = ['id'=>$request->id];
        }

        return response()->json(['love'=>$response],200);
    }

    public function ajaxRequestInst(Request $request){

        $pos = $request->id;
        $post = Image::findorFail($request->id);
        $post_owner = $post->user_id;
        $user = auth()->user()->id;

        $follow = Followable::where(['user_id' => $user, 'followable_id' => $pos, 'followable_type' => 'App\Image'])
                                ->update(['notify'=>$post_owner]);

        // notification
        $notify_user = User::findorFail($post->user_id);
        $liker = auth()->user();
        
        if($notify_user->id !== $liker->id) {
            $notify_user->notify(new ImageLike($liker, $post));
        }

        return response()->json(['success'],200);
    }
}
