<?php

namespace App\Notifications;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectAssignedNotification extends Notification
{
    use Queueable;
    private $project;
    private $causer;
    private $classification = "bell";
    private $event = "project_assigned";
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project ,$causer = null )
    {
        $this->project = $project;
        $this->causer = $causer;
        
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
            ->markdown('mail-template.project-asssigned',["event" => $this->event , "project" => $this->project ,"causer" => $this->causer ]);
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
    public function toBroadcast($notifiable)
    {
        $controller = new ProjectController();
        return new BroadcastMessage([
            "classification" => $this->classification,
            "event" => $this->event,
            "project_id" => $this->project->id,
            "extra_data" => [
                "type" => "dataTable",
                "table" => "projectsTable",
                //"row_id" => row_id("projects",$this->project->id),
                "row" => $controller->_make_row($this->project ,$notifiable)
            ]
        ]);
    }
}
