<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\MessageObserver;

class Message extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id', 'subject', 'message',
    ];

    protected $table = 'message';
    protected $guarded = ['id'];

    public function sender(){
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo('App\User', 'receiver_id');
    }

    protected $dispatchesEvents = [
        'created' => MessageObserver::class,
    ];
}
