<?php

namespace App\Http\Controllers;

use PDF;
use Exception;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Jobs\sendInvoiceJob;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChexkoutRequest;
class InvoiceController extends Controller
{
    public function preview(Invoice $invoice)
    {
        $invoice->load("project");
        if ((!$invoice->project->own_project() && !Auth::user()->is_admin()) || !$invoice->project->estimate || $invoice->project->estimate != "accepted") {
            abort(401);
        }
        $invoice->project->load("client");
        $invoice->project->client->load("user");
        $invoice_data = $this->prepare_invoice_data($invoice);
        return view("project.invoices.preview", compact("invoice", "invoice_data"));
    }
    private function prepare_invoice_data(Invoice $invoice)
    {
        return invoice_data($invoice);
    }
    public function checkout_form(Invoice $invoice)
    {
        $invoice->load("project");
        $invoice->project->load("client");
        $invoice->project->load("categories");
        $invoice->project->client->load("user");
        $invoice_data = $this->prepare_invoice_data($invoice);
        if($invoice->status->name =="not_paid"){
             $item = $invoice->invoiceItemsfirstSlice();
        }else{
            $item = $invoice->invoiceItemsSecondSlice();
        }
        $amount = $item->amount;
        return view("project.invoices.checkout", compact("invoice", "invoice_data", "amount" , "item"));
    }
    public function checkout(ChexkoutRequest $request, Invoice $invoice)
    {
        $invoice->load("project");
        $invoice->project->load("client");
        $invoice->project->client->load("user");
        $user = $invoice->project->client->user;
        if($invoice->status->name == "not_paid"){
            $invoice_item = $invoice->invoiceItemsfirstSlice();
        }else{
            $invoice_item = $invoice->invoiceItemsSecondSlice();
        }
        config(['cashier.key' => app_setting("STRIPE_KEY") ,'cashier.secret' => app_setting("STRIPE_SECRET")]);
        config(['cashier.currency' => app_setting("currency")]);
        try {
            $response =  $user->charge($invoice_item->amount, $request->payment_method_id);
            if ($response->status == "succeeded") {
                $this->success_payment($invoice_item, $response);
                die(json_encode(["success" => true, "message" => sprintf(trans("lang.success_payment") , $request->payment_method_name), "url" =>url("project/detail/{$invoice->project->id}")]));
            }else{
                $this->failure_payment();
            }
        } catch (Exception $e) {
            $this->error_payment($e);
        }
    }
    private function success_payment(InvoiceItem $invoice_item,$response = null)
    {
        $invoice_item->status = "paid";
        $invoice_item->payment_data = serialize($response);
        $invoice_item->save();
       
        $invoice_item->load("invoice");
        $invoice_item->invoice->status =  $invoice_item->invoice->status->name;
        $invoice_item->invoice->save();
        
        $invoice_item->load("project");
        $invoice_item->project->status_id = 4;
        $invoice_item->project->save();
        dispatch(new sendInvoiceJob($invoice_item,$invoice_item->invoice));
    }
    private function error_payment(Exception $e)
    {
        die(json_encode(["success" => false, "message" => $e->getMessage()]));
    }
    private function failure_payment()
    {
        die(json_encode(["success" => false, "message" => "Failed payment"]));
    }

    public function download_invoice(InvoiceItem $invoiceItem)
    {
        $invoiceItem->load("project");
        if (Auth::user()->is_admin() || $invoiceItem->project->own_project()) {
            return response()->download(project_path_file($invoiceItem->project->id , $invoiceItem->pdf));
        }
        abort(403);
    }
   
    public function pdf(Invoice $invoice, $download = 0)
    {
        $invoice->load("project");
        if (!$invoice->project->own_project() && !Auth::user()->is_admin()) {
            abort(401);
        }
        $invoice_data =  $this->prepare_invoice_data($invoice);
        $invoice->project->load("client");
        $invoice->project->load("categories");
        $invoice->project->client->load("user");
        $name = "invoice-$invoice->id" . ".pdf";
        $path = storage_path("app/public/project_files/{$invoice->project->id}/$name");
        $pdf = PDF::loadView('project.invoices.pdf', ["invoice" => $invoice, "invoice_data" => $invoice_data]);
        if ($download) {
            return $pdf->download($name);
        }
        return view("project.invoices.pdf", ["invoice" => $invoice, "invoice_data" => $invoice_data]);
    }
}
