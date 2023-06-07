<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;


class SendNotification extends Notification
{
    use Queueable;
    
    private $sentData;
    protected $title;
    protected $message;
    protected $fcmTokens;

   
    
    public function __construct($sentData,$title,$message,$fcmTokens)
    {
        $this->sentData = $sentData;
        $this->title = $title;
        $this->message = $message;
        $this->fcmTokens = $fcmTokens;
    }

   
    public function via($notifiable)
    {
        return ['mail','firebase','database'];
    }

    
    public function toMail($notifiable)
    {
        return (new MailMessage)

        ->line('The introduction to the notification.')
        ->action('Notification Action', url('/'))
        ->line('Thank you for using our application!');
                    
    }


    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)
            ->withPriority('high')->asMessage($this->fcmTokens);
    }
   
    public function toArray($notifiable)
    {
        return [
            'id'   => $this->sentData['id'],
            'body' => $this->sentData['body']
        ];
    }
}
