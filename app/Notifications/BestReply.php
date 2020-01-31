<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BestReply extends Notification
{
    use Queueable;

    protected $reply;

    protected $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reply, $thread)
    {
        $this->reply = $reply;
        $this->thread = $thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'message'=>'Your reply has been marked as best in '.$this->thread->title,
            'link'=>$this->reply->path()
        ];
    }
}
