<?php

namespace App\Http\Controllers;

use App\Models\File;
use Auth;
use App\Models\Invoice;

use App\Models\Project;
use App\Models\Relaunch;
use App\Models\InfoGround;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\ProjectRelaunch;


class ClientController extends Controller
{
    protected $files;


    public function index()
    {
        /** Dashbord client */
        return true;
    }
    public function projects()
    {
        return view("clients.projects.list");
    }
    public function data_list()
    {
        $data = [];
        $projects =  Project::getDetails(["client" => Auth::user()->client_id()])->get();
        foreach ($projects as $project) {
            $data[] = $this->_make_row($project ,Auth::user());
        }
        return ["data" => $data];
    }
    public function _make_row($project ,$for_user = null , $from_notification = false )
    {
        $last_relaunch = ProjectRelaunch::where("project_id",$project->id)->where("created_by",$for_user->id)->latest('created_at')->first();
        $relaunch = Relaunch::where("project_id",$project->id)->where("created_by",$for_user->id)->latest('created_at')->first();
        return [
            "DT_RowId" => row_id("projects", $project->id),
            "badge" => view("project.column.badge", ["project" => $project ,"for_user" =>$for_user])->render(),
            "offer" => $project->categories[0]->offer->name,
            "categories" => $project->categories->pluck("name")->implode(","),
            "status" => view("clients.column.status", ["project" => $project ,"for_user" => $for_user])->render(),
            "relaunch" => view("clients.column.relaunch", ["project" => $project ,"for_user" => $for_user])->render(),
            "estimate" => view("clients.column.estimate", ["project" => $project ,"relaunch" => $relaunch ,"last_relaunch" => $last_relaunch])->render(),
            "version" => $project->version,
            "invoice" => $this->invoice_column($project),
            "payment" =>  $this->payment_column($project),
            "end_date" => $project->created_at->format("d-M-Y"),
        ];
    }
    private function invoice_column(Project $project){
        if($project->invoice && $project->invoice->status !== "not_paid"){
            return view("project.column.invoice_items", ["project" =>  $project])->render();
        }else{
            return "-";
        }
    }
    private function payment_column(Project $project){
        if($project->invoice && in_array($project->invoice->status->name,["not_paid","part_paid"])){
            return anchor(url("project/invoice/preview/{$project->invoice->id}") ,"<i class='fas fa-bookmark text-{$project->invoice->status->class}'></i>",["class" => "text-light-primary"]);
        }elseif($project->invoice && ($project->invoice->status->name === "paid")){
            return anchor(url("project/invoice/preview/{$project->invoice->id}") ,"<i class='far fa-check-circle text-{$project->invoice->status->class} fs-2'></i>",["class" => "text-light-primary"]);
        }else{
            return "-";
        }
    }
    public function accept_estimate(Project $project)
    {
        $project->infoGround()->save(new InfoGround());
        $project->estimate = "accepted";
        $this->generate_invoice($project);
        $project->load("invoice");
        if ($project->save()) {
            return ["success" => true, "message" => trans("lang.accepted"), "redirect" => url("/project/invoice/preview/{$project->invoice->id}")];
        } else {
            return ["success" => false, "message" => trans("lang.error_accept_estimate")];
        }
    }
    private function generate_invoice(Project $project)
    {
        if (!$project->own_project() || !$project->estimate || $project->estimate != "accepted") {
            abort(404);
        }
        $project->load("categories");
        $project->load("client");
        $taxe = 20;  // 20%
        $invoice = Invoice::create(["project_id" => $project->id, "client_id" => $project->client->id, "taxe" => $taxe, "total" => $project->price ,"status" => "not_paid"]);
        $this->generate_invoice_items($project,$invoice);
    }
    private function generate_invoice_items(Project $project, Invoice $invoice)
    {
        $invoice_data = invoice_data($invoice);
        InvoiceItem::create(["invoice_id" => $invoice->id, "project_id" => $project->id, "slice" => 1, "client_id" => $project->client->id, "amount" => get_array_value($invoice_data, "first_slice")]);
        InvoiceItem::create(["invoice_id" => $invoice->id, "project_id" => $project->id, "slice" => 2, "client_id" => $project->client->id, "amount" => get_array_value($invoice_data, "second_slice")]);
    }
    public function refuse_estimate(Project $project)
    {
        $subjects = [
            ["value" => "Devis trop elevé", "text" =>  "Devis trop elevé"],
            ["value" => "Project annulé", "text" =>  "Project annulé "],
            ["value" => "Demande négociation", "text" =>  "Demande négociation"],
        ];
        return view("clients.projects.refused-estimate-modal-form", compact("project", "subjects"));
    }
    /** Save refuse estimate reason  */
    public function save_refuse_estimate(Request $request , Project $project){
        $relaunch =  new Relaunch();
        $relaunch->description = $request->reason;
        $relaunch->project_id = $project->id;
        $relaunch->created_by = Auth::user()->id;
        $relaunch->save();
        $project_relaunch = new ProjectRelaunch(["relaunch_id" => $relaunch->id ,'note' => $request->comment  , "created_by" => Auth::id()]);
        $project->relaunchs()->save( $project_relaunch);
        $project->estimate = "refused";
        if($project->save()){
            return ["success" => true, "message" => trans("lang.accepted")];
        }else {
            return ["success" => false, "message" => trans("lang.error_accept_estimate")];
        }
    }
    public function relaunch(Project $project){
        $relaunchs =  $project->relaunchs()->latest()->get()->reverse();
        return view("project.relaunch.lists", ["relaunchs" => $relaunchs ,"project_id" => $project->id,  "subjects" =>  Relaunch::drop($project)]);
    }

    public  function add_relaunch(Request $request, Project $project)
    {
        $request->validate(['subject' => 'required']);
        if ($request->hasFile("files")) {
            $this->uploads($request,$project);
        }
        $relaunch = new ProjectRelaunch(['note' => $request->note,  "files" => $this->files , "relaunch_id" => $request->subject, "created_by" => Auth::user()->id]);
        
        $relaunch = $project->relaunchs()->save($relaunch);
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row_id" => row_id("project", $project->id), "project" => $this->_make_row($project, Auth::user()), "id" =>$relaunch->id ,"data" => view("project.relaunch.item" ,["relaunch" => $relaunch ,"for_user" => auth()->user()])->render()]));
    }
    public  function mark_as_seen(Request $request)
    {
        $relaunch = ProjectRelaunch::find( $request->id);
        $relaunch->update(["seen_by" => ($relaunch->seen_by .",". auth()->id()) ]);
        return ["succes" => true ];
    }

    private function uploads(Request $request ,Project $project ){
        $files = $request->file("files");
        $path = "project_files/$project->id";
        foreach ($files as $file) {
            $file_info = upload($file,  $path, "local");
            if ($file_info["success"]) {
                unset($file_info["success"]);
                $file_info["created_by"] = auth()->id();
                $file_info["project_id"] = $project->id;
                $file_info["preliminary"] = 0;
            }
            $file = File::create($file_info);
            $this->files .= "," .$file->id;
        }
    }
}
