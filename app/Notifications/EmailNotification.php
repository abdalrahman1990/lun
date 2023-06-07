<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNotification extends Notification
{
    use Queueable;

    private $project;
   
    
    public function __construct($project)
    {
        $this->project = $project;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage) 

            ->subject($this->project['subject'])
            ->greeting($this->project['greeting'])
            ->line($this->project['body']);
           // ->action($this->project['actionText'], $this->project['actionURL'])
           
    }

   
    public function toDatabase($notifiable)
    {
        return [
            'project_id' => $this->project['id']
        ];
    }
    

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
