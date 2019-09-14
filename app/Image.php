<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Contracts\Blockable;
use DB;

class Image extends Model implements Blockable
{
    use CanBeLiked; use CanBeBlocked;

    protected $fillable = [
        'user_id', 'image',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function waller(){
        return $this->belongsTo('App\User', 'waller_id');
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'fromPost')->whereNull('comment_id');
    }

    public function fav(){
        return $this->morphMany(Favorite::class, 'pos');
    }

    public function report(){
        return $this->morphMany(Report::class, 'reported');
    }

    public function delete() {
        $this->comments()->delete();
        $this->fav()->delete();
        parent::delete();
    }

    public function scopeQueryimage($query, $id) {
        return $query->select('images.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', DB::raw('null as content, null as waller_id'), 'images.created_at as posted', 'images.image as images', 'images.caption as caption')
        ->join('users', 'users.id', 'images.user_id')
        ->where('users.id', $id)
        ->whereNotIn('images.id', function($k) use ($id) {
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', $id)
                ->where('blockable_type', 'App\Image');
        })
        ->orWhere(function($query) use ($id) {
            $query->whereIn('users.id', function($q) use ($id) {
                $q->select('followable_id')
                ->from('followers')
                ->where('follower_id', $id)
                ->where('images.post_type', '!=', 'me');
            });
        });
    }

    public function scopeQueryimage_two() {
        return $query->select('images.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', DB::raw('null as content, null as waller_id'), 'images.created_at as posted', 'images.image as images', 'images.caption as caption')
        ->join('users', 'users.id', 'images.user_id')
        ->where('users.id', auth()->user()->id);
    }

    public function scopeQueryimage_three($query, $id, $user) {
        return $query->select('images.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', DB::raw('null as content, null as waller_id'), 'images.created_at as posted', 'images.image as images', 'images.caption as caption', 'images.post_type as type')
        ->join('users', 'users.id', 'images.user_id')
        ->where('users.id', $id)
        ->whereNotIn('images.id', function($k) use($user) {
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', $user->id)
                ->where('blockable_type', 'App\Image');
        });
    }
}
