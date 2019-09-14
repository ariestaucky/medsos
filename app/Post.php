<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Contracts\Blockable;
use Rennokki\Befriended\Scopes\BlockFilterable;
use DB;

class Post extends Model implements Blockable
{
    use CanBeLiked; use CanBeBlocked;

    protected $fillable = [
        'waller_id', 'user_id', 'content',
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

    public function scopeQuerypost($query, $id) {
        return $query->select('posts.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', 'posts.content as content', 'posts.waller_id as waller_id', 'posts.created_at as posted', DB::raw('null as images, null as caption'))
        ->join('users', 'users.id', 'posts.user_id')
        ->where('users.id', $id)
        ->whereNotIn('posts.id', function($k ) use ($id) {
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', $id)
                ->where('blockable_type', 'App\Post');
        })
        ->orWhere('posts.waller_id', $id)
        ->orWhere(function($query) use ($id) {
            $query->whereIn('users.id', function($q) use ($id) {
                $q->select('followable_id')
                ->from('followers')
                ->where('follower_id', $id)
                ->where('posts.post_type', '!=', 'me');
            });
        });
    }

    public function scopeQuerypost_two($query) {
        return $query->select('posts.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', 'posts.content as content', 'posts.waller_id as waller_id', 'posts.created_at as posted', DB::raw('null as images, null as caption'))
        ->join('users', 'users.id', 'posts.user_id')
        ->where('users.id', auth()->user()->id)
        ->orWhere('posts.waller_id', auth()->user()->id);
    }

    public function scopeQuerypost_three($query, $id, $user) {
        return $query->select('posts.id as id', 'users.id as user_id', 'users.name as name', 'users.username as username', 'users.profile_image as profile', 'posts.content as content', 'posts.waller_id as waller_id', 'posts.created_at as posted', DB::raw('null as images, null as caption'), 'posts.post_type as type')
        ->join('users', 'users.id', 'posts.user_id')
        ->where('users.id', $id)
        ->whereNotIn('posts.id', function($k) use($user) {
            $k->select('blockable_id')
                ->from('blockers')
                ->where('blocker_id', $user->id)
                ->where('blockable_type', 'App\Post');
        })
        ->orWhere('posts.waller_id', $id);
    }

    public function scopeUserpost($query) {
        return $query->where('user_id', auth()->user()->id);
    }
}
