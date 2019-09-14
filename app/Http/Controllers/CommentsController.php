<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\NewComment;
use App\Notifications\ImageComment;
use Notification;
use App\Comment;
use App\Post;
use App\Image;
use App\User;

class CommentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comment = Comment::where('user_id');
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
        $user = User::findorFail($request->input('user_id'));
        $commenter = auth()->user();

        $this->validate($request, [
            'content' => 'required|string|max:255'
        ]);

        $comment = new Comment;
        $comment->comment = $request->input('content');
        $comment->user_id = auth()->user()->id;
        $comment->notify_id = $request->input('user_id');
        
        if(auth()->user()->id !== $user->id){
            if($request->routeIs('comment')){
                $post = Post::find($request->input('post_id'));
                $post->comments()->save($comment);

                if(!empty($post->waller_id)) {
                    $first = User::where('id', $post->waller_id);
                    $users = User::where('id', $request->input('user_id'))
                    ->union($first)
                    ->get();

                    Notification::send($users, new NewComment($commenter, $post));
                } else {
                    $user->notify(new NewComment($commenter, $post));
                }
            } else {
                $post = Image::find($request->input('post_id'));
                $post->comments()->save($comment);

                if(!empty($post->waller_id)) {
                    $first = User::where('id', $post->waller_id);
                    $users = User::where('id', $request->input('user_id'))
                    ->union($first)
                    ->get();

                    Notification::send($users, new ImageComment($commenter, $post));
                } else {
                    $user->notify(new ImageComment($commenter, $post));
                }
            }
        } else {
            if($request->routeIs('comment')){
                $post = Post::find($request->input('post_id'));
                $post->comments()->save($comment);
            } else {
                $post = Image::find($request->input('post_id'));
                $post->comments()->save($comment);
            }
        }

        return redirect()->back()->with('success', 'Comment Added');
    }

    public function block($id)
    {
        $post = Comment::findorFail($id);
        $user = auth()->user();

        $user->block($post);
          
        return redirect()->back()->with('success', 'Comment blocked');
    }

    public function unblock($id)
    {
        $post = comment::findorFail($id);
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
        //
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
        $com = Comment::findOrFail($id);

        $this->validate($request, [
            'content' => 'required|string|max:255',
        ]);

        $com->comment = $request->input('content');
        
        $com->save();
          
        return redirect()->back()->with('success', 'Comment Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $com = Comment::findorFail($id);
        // Check for correct user
        if(auth()->user()->id !== $com->user->id){
            return redirect()->back()->with('error', 'Unauthorized Page');
        }

        $com->delete();

        return redirect()->back()->with('success', 'Comment Removed');
    }
}
