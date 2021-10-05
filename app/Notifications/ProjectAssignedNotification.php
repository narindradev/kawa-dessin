<?php

namespace App\Notifications;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectAssignedNotification extends Notification
{
    use Queueable;
    private $project;
    private $classification = "bell";
    private $event = "project_assigned";
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
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
        return ['database', 'broadcast'];
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
            "project_id" => $this->project->id,
        ];
    }
    public function toBroadcast($notifiable)
    {
        $render = new ProjectController();

        return new BroadcastMessage([
            "classification" => $this->classification,
            "event" => $this->event,
            "project_id" => $this->project->id,
            "extra_data" => [
                "type" => "dataTable",
                "table" => "projectsTable",
                // "row_id" => row_id("projects",$this->project->id),
                "row" => $render->_make_row($this->project)
            ]
        ]);
    }
}
