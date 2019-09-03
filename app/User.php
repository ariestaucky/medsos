<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelFollow\Traits\CanLike;
use Rennokki\Befriended\Traits\Like;
use Rennokki\Befriended\Contracts\Liking;
use Rennokki\Befriended\Traits\Follow;
use Rennokki\Befriended\Contracts\Following;
use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Contracts\Blocker;
use Rennokki\Befriended\Scopes\BlockFilterable;

class User extends Authenticatable implements Liking, Following, Blocker 
{
    use Notifiable; use CanLike; use Like; use Follow; use CanBlock;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'fname', 'lname', 'email', 'password', 'username', 'provider_id', 'provider', 'motto', 'bio', 'job', 'gender', 'status', 'bday', 'address', 'city', 'country', 'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function images(){
        return $this->hasMany('App\Image');
    }

    public function comment(){
        return $this->hasMany('App\Comment');
    }

    public function owner(){
        return $this->hasMany('App\Comment', 'notify_id');
    }

    public function visitor(){
        return $this->hasMany('App\Visitor', 'visitor');
    }

    public function sender(){
        return $this->hasMany('App\Message', 'sender_id');
    }

    public function receiver(){
        return $this->hasMany('App\Message', 'receiver_id');
    }

    public function report(){
        return $this->hasMany('App\Report', 'reporter_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public static function scopeSearch($query, $searchTerm){
        return $query->Where('id', '!=', auth()->user()->id)
                     ->Where('username', 'like', '%' .$searchTerm. '%')
                     ->orWhere('name', 'like', '%' .$searchTerm. '%')
                     ->orWhere('fname', 'like', '%' .$searchTerm. '%')
                     ->orWhere('lname', 'like', '%' .$searchTerm. '%')
                     ->orWhere('city', 'like', '%' .$searchTerm. '%')
                     ->orWhere('country', 'like', '%' .$searchTerm. '%')
                     ->orWhere('address', 'like', '%' .$searchTerm. '%')
                     ->orWhere('job', 'like', '%' .$searchTerm. '%');
    }

}
