<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = "favorite";
    protected $guarded = ['id'];
    
    protected $fillable = [
        'user_id', 'fav_post', 'post_owner',
    ];

    public function owner()
    {
        return $this->belongsTo('App\User', 'post_owner');
    }

    public function pos()
    {
        return $this->morphTo();
    }

}
