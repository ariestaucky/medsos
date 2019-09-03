<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use App\Post;
use App\Image;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function back()
    {
        $last_page = url()->previous();
        if(Session()->has('link')){
            if(Session('link') != $last_page){
                session('link');
            } else {
                session(['link' => $last_page]);
            }
        }

        return redirect(session('link'));
    }

    public function poster() {
        if(auth()->check()) {

            
            // $poster = DB::select("SELECT users.id as id,
            //                             users.name as name,
            //                             users.username as username,
            //                             users.profile_image as profile,
            //                             posts.id as post_id,
            //                             posts.content as content,
            //                             posts.created_at as posted,
            //                             null as img_id,
            //                             null as images
            //                     FROM posts
            //                     JOIN users ON posts.user_id=users.id
            //                     WHERE users.id = '$user_id'
            //                     UNION ALL
            //                     SELECT users.id as id,
            //                             users.name as name,
            //                             users.username as username,
            //                             users.profile_image as profile,
            //                             null as post_id,
            //                             null as content,
            //                             images.created_at as posted,
            //                             images.id as img_id,
            //                             images.image as images
            //                     FROM images
            //                     JOIN users on images.user_id=users.id   
            //                     WHERE users.id = '$user_id' 
            //                     ORDER BY posted desc");

            return $poster;
        }
    }
}
