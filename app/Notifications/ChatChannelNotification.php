<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use App\Http\Controllers\ClientController;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\ProjectController;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Str;

class ChatChannelNotification extends Notification
{
    use Queueable;
    private $classification = "chat";
    private $event = "message_sended";
    private $message;
    private $project;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message ,$project = null)
    {
        $this->message = $message;
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->id != $this->message->sender_id) {
            return ['broadcast'];
        }
        return [];
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
        return [
            //
        ];
    }
    public function toBroadcast($notifiable)
    {   $controller = $notifiable->is_client() ? new ClientController() : new ProjectController();
        $need_load_more = str_word_count($this->message->content) > 300 ? true : false ;
        $message = $need_load_more ? "" : view("messages.item" ,["message" => $this->message ,"my_message" => ($this->message->sender_id ==$notifiable->id)  , "from_notification" => true ,"for_user" => $notifiable ,"need_load_more" => $need_load_more])->render();
        return new BroadcastMessage([
            "classification" => $this->classification,
            "message_id" => $this->message->id,
            "project_id" => $this->message->project_id,
            "need_load_more" => $need_load_more,
            "message" =>$message ,
            "extra_data" => [
                "type" => "dataTable",
                "table" => "projectsTable",
                "row_id" => row_id("projects",$this->message->project_id),
                "row" => $controller->_make_row($this->project,$notifiable,true)
            ]
        ]);
    }
}
