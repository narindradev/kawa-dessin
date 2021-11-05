<?php

namespace App\Notifications;

use App\Http\Controllers\ClientController;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstimateAssignedNotification extends Notification
{
    use Queueable;
    private $project;
    private $user;
    private $classification = "bell";
    private $event = "estimate_assigned";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( Project $project,$user = null)
    {
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast','mail'];
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
            ->from(app_setting("sender_mail") ,app_setting("sender_name"))
            ->subject($this->event)
            ->markdown('mail-template.estimate-assigned',["event" => $this->event, "project" => $this->project, "causer" => $this->user]);
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
            "project_id" => $this->project->id,
        ];
    }

    public function toBroadCast($notifiable){
        $controller = new ClientController();
        return new BroadcastMessage([
            "classification" => $this->classification,
            "event" => $this->event,
            "project_id" => $this->project->id,
            "extra_data" => [
                "type" => "dataTable",
                "table" => "projectsTable",
                "row_id" => row_id("projects",$this->project->id),
                "row" => $controller->_make_row($this->project,$notifiable)
            ]
        ]);
    }

    


}
