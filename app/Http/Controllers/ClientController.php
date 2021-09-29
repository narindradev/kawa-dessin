<?php

namespace App\Http\Controllers;

use Auth;

use App\Models\Project;
use Illuminate\Http\Request;


class ClientController extends Controller
{


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
        
        $projects = $projects = Project::getDetails(["client" => Auth::user()->client_id()])->get();
        foreach ($projects as $project) {
            $data[] = $this->_make_row($project);
        }
        return ["data" => $data];
    }

    private function _make_row($project)
    {
        return [
            "DT_RowId" => row_id("project", $project->id),
            "badge" => view("project.column.badge", ["project" => $project])->render(),
            "offer" => $project->categories[0]->offer->name,
            "categories" => $project->categories->pluck("name")->implode(","),
            "status" => view("project.column.status", ["project" => $project])->render(),
            "messenger" => view("project.column.messenger", ["project" => $project])->render(),
            "estimate" => view("clients.column.estimate", ["project" => $project])->render(),
            "version" => $project->version,
            "end_date" => $project->created_at->format("d-M-Y"),
        ];
    }

    public function accept_estimate(Project $project)
    {
        $project->accept_estimate = "accepted";
        if ($project->save()) {
            return ["success" => true, "message" => trans("lang.accepted"), "redirect" => url("")];
        } else {
            return ["success" => false, "message" => trans("lang.error_accept_estimate")];
        }
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
        $note   = $request->input("note");
        $reason = $request->input("reason");
        $project->accept_estimate = "refused";
        if($project->save()){
            return ["success" => true, "message" => trans("lang.accepted")];
        }else {
            return ["success" => false, "message" => trans("lang.error_accept_estimate")];
        }
    }
}
