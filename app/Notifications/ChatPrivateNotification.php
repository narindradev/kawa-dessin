<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ChatPrivateNotification extends Notification
{
    use Queueable;
    private $classification = "chat";
    private $form = "private";
    private $event = "message_sended";
    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $need_load_more = str_word_count($this->message->content) > 300 ? true : false ;
        $message = $need_load_more ? "" : view("messages.item" ,["message" => $this->message ,"my_message" => ($this->message->sender_id ==$notifiable->id)  , "from_notification" => true ,"for_user" => $notifiable ,"need_load_more" => $need_load_more])->render();
        return new BroadcastMessage([
            "classification" => $this->classification,
            "form" =>$this->form ,
            "message_id" => $this->message->id,
            "target" => $this->message->sender_id,
            "need_load_more" => $need_load_more,
            "message" =>$message ,
        ]);
    }
}
