<?php

namespace App\Notifications;

use App\Http\Controllers\ClientController;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\ProjectController;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class InvoicePaymentNotification extends Notification
{
    use Queueable;
    protected $invoice;
    protected $pdf;
    private $classification = "bell";
    private $event = "invoice_item_paid";
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice ,$pdf = "")
    {
        $this->invoice = $invoice;
        $this->pdf = $pdf;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database' ,'broadcast'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage);
        if ($notifiable->is_client()) {
            $message->line('The notification for client');
        }else{
            $message->line('The notification for not client');
        }
        $message->action('Notification Action', url('/'));
        $message->from(app_setting("sender_mail") ,app_setting("sender_name"));
        $message->attach(project_path_file( $this->invoice->project->id, $this->pdf));
        return $message;
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
            "project_id" => $this->invoice->project->id,
            "event" => $this->event,
        ];
    }
    public function toBroadcast($notifiable)
    {
        $controller = $notifiable->is_client() ? new ClientController() : new ProjectController();
        return new BroadcastMessage([
            "classification" => $this->classification,
            "event" => $this->event,
            "project_id" => $this->invoice->project->id,
            "extra_data" => [
                "type" => "dataTable",
                "table" => "projectsTable",
                "row_id" => row_id("projects",$this->invoice->project->id),
                "row" => $controller->_make_row($this->invoice->project,$notifiable)
            ]
        ]);
    }
}
