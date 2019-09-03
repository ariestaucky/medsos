<?php

namespace App\Observers;

use App\Notifications\NewMessage;
use App\Message;
use App\User;

class MessageObserver
{
    public function created(Message $message)
    {
        $user = User::findorFail($message->receiver_id);
        $sender = User::findorFail($message->sender_id);
        $msg = $message; 
        
        $user->notify(new NewMessage($sender, $msg));
    }
}