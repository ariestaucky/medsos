<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Contracts\Blockable;

class Comment extends Model implements Blockable
{
    use CanBeBlocked;
    
    protected $fillable = [
        'user_id', 'post_id', 'comment_id', 'comment',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function owner(){
        return $this->belongsTo('App\User', 'notify_id');
    }

    public function post(){
        return $this->belongsTo('App\Post');
    }

    public function image(){
        return $this->belongsTo('App\Image');
    }

    public function report(){
        return $this->morphMany(Report::class, 'reported');
    }

    public function fromPost(){
        return $this->morphTo();
    }

}
