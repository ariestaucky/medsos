<?php

namespace App\Observers;

use App\Notifications\NewLike;
use App\Followable;
use App\Post;
use App\Image;
use App\User;

class LikeObserver
{
    // public function deleted(Followable $like)
    // {
    //     $liker = $like->user;
    //     $notify_user = User::findorFail($like->notify);

    //     $notify_user = User::findorFail($post->user_id);
    //     $liker = auth()->user();

    //     if($notify_user->id !== $liker->id) {
    //         if(empty($post->waller_id)) {
    //             $notify_user->notify(new NewLike($liker, $post));
    //         } else {
    //             $first = User::where('id', $post->waller_id);
    //             $users = User::where('id', $request->input('user_id'))
    //             ->union($first)
    //             ->get();

    //             Notification::send($users, new NewLike($liker, $post));
    //         } 
    //     }

    //     if($like->followable_type == 'App\Post'){
    //         $post = Post::findorFail($like->followable_id);
            
    //         $notify_user->notify(new NewLike($liker, $post));
    //     }else {
    //         $post = Image::findorFail($like->followable_id);

    //         $notify_user->notify(new ImageLike($liker, $post));
    //     }
    // }
}