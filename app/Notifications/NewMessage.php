<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Message;

class NewMessage extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $sender;
    protected $msg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $sender, Message $msg)
    {
        $this->sender = $sender;
        $this->msg = $msg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message_id' => $this->msg->id,
            'subject' => $this->msg->subject,
            'message' => $this->msg->message,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->id,
            'read_at' => null,
            'data' => [
                'sender_id' => $this->sender->id,
                'sender_name' => $this->sender->name,
                'subject' => $this->msg->subject,
                'message' => $this->msg->message,
            ],
        ];
    }
}
