<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = "report";

    public function reported(){
        return $this->morphTo();
    }

    public function reporter(){
        return $this->belongTo('App\User');
    }
}
