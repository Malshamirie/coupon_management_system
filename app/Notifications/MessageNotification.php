<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class MessageNotification extends Notification
{
    use Queueable;

    private $messageData;

    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }



    public function via($notifiable)
    {
//        return ['mail','database'];
        return ['database'];
    }




    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->name($this->messageData['title']);
                    ->line($this->messageData['notes'])
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }




    public function toArray($notifiable)
    {
        return [
            'title' => $this->messageData['title'],
            'body' => $this->messageData['body'],
        ];
    }
}
