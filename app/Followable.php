<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Post;
use App\User;

class Followable extends Model
{
    // Table Name
    protected $table = 'followables';
    // Primary Key
    protected $primaryKey = 'fol_id';

    public function user(){
        return $this->belongsTo('App\User');
    } 

    public function post(){
        return $this->belongsTo('App\Post');
    } 

    public function image(){
        return $this->belongsTo('App\Image');
    } 

    protected $with = ['followable'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function followable()
    {
        return $this->morphTo(config('follow.morph_prefix', 'followable'));
    }

}
