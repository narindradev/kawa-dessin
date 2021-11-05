<?php

namespace App\Jobs;

use PDF;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Bus\Queueable;
use App\Models\Project_assignment;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\InvoicePaymentNotification;
use App\Notifications\ProjectAssignedNotification;

class sendInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;
    protected $invoice_item;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(InvoiceItem $invoice_item, Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->invoice_item = $invoice_item;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pdf = $this->pdf();
        $notify_to = User::where("user_type_id", 1)->orWhere("id", $this->invoice->project->client->user->id)->where("deleted", 0)->get();
        \Notification::send($notify_to, (new InvoicePaymentNotification($this->invoice, $pdf)));
        if ($this->invoice_item->slice == 1) {
            // $user = Project_assignment::getAssignTo('mdp');
            $user = User::find(54);
            $this->invoice->project->members()->attach([$user->id]);
            $user->notify(new ProjectAssignedNotification($this->invoice->project,null));
        }
    }
    private function pdf()
    {
        $pdf_name = invoice_item_num($this->invoice->id, $this->invoice_item->id) . ".pdf";
        $this->invoice_item->pdf = $pdf_name;
        $this->invoice_item->save();
        $pdf = PDF::loadView('project.invoices.pdf', ["invoice" => $this->invoice, "invoice_data" => invoice_data($this->invoice)]);
        if (!File::exists(project_path_file($this->invoice->project->id))) {
            File::makeDirectory(project_path_file($this->invoice->project->id));
        }
        $pdf->save(project_path_file($this->invoice->project->id, $pdf_name));
        return $pdf_name;
    }
}
