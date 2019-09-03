<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'visitor', 'user_page',
    ];

    protected $table = 'visitor';
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\User', 'visitor');
    }
}
