<?php

namespace App\Notifications;

use stdClass;
use App\Models\Project;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\ProjectController;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProjectAssignedNotification extends Notification
{
    use Queueable;
    private $project;
    private $causer;
    private $classification = "bell";
    private $event = "project_assigned";
    private $fake_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project ,$causer = null )
    {
        $this->project = $project;
        $this->causer = $causer;
        $this->fake_id = Str::uuid();
        
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
            "event" => $this->event,
            "created_by" => $this->causer->id ?? null,
            "fake_id" => $this->fake_id,
        ]; 
    }
    public function toBroadcast($notifiable)
    {
        $controller = new ProjectController();
        return new BroadcastMessage([
            "classification" => $this->classification,
            "event" => $this->event,
            "item" => $this->prepare_notification_item($notifiable),
            "project_id" => $this->project->id,
            "extra_data" => [
                "type" => "dataTable",
                "table" => "projectsTable",
                "row_id" => row_id("projects",$this->project->id),
                "row" => $controller->_make_row($this->project ,$notifiable)
            ],
            "toast" => $this->toast_notification(),
        ]);
    }
    public function prepare_notification_item($notifiable)
    {
        $notification = new stdClass();
        $notification->data["created_by"] =  $this->causer->id ?? null;
        $notification->data["project_id"] =  $this->project->id;
        $notification->data["event"] = $this->event;
        $notification->id = $this->fake_id ;
        $notification->created_at =  Carbon::now();
        $notification->read_at =  null;
        return view('notifications.template', ['notification' => $notification])->render();
    }
    private function toast_notification(){
        $content = "Un nouveau projet ";
        $content .= project_tag($this->project);
        return ["content" => $content , "title" => trans("lang.project")] ; 
    }
}