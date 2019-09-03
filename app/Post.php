<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Contracts\Blockable;
use Rennokki\Befriended\Scopes\BlockFilterable;

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

}
