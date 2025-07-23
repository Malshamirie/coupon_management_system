<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PartNotification extends Notification
{
    use Queueable;


    public function __construct($details)
    {
        $this->details = $details;
    }




    public function via($notifiable)
    {
        return ['database'];
    }





    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting($this->details['greeting'])
            ->line($this->details['body'])
            ->line($this->details['thanks']);

    }





    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->details['title'],
            'body' => $this->details['body'],
        ];
    }


}
