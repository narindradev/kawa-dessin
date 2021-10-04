<?php

namespace App\Http\Controllers;

use App\Models\InfoGround;
use Auth;

use App\Models\Project;
use App\Models\ProjectRelaunch;
use App\Models\Relaunch;
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
        $last_relaunch = ProjectRelaunch::where("project_id",$project->id)->where("created_by",Auth::user()->id)->latest('created_at')->first();
        $relaunch = Relaunch::where("project_id",$project->id)->where("created_by",Auth::user()->id)->latest('created_at')->first();
        return [
            "DT_RowId" => row_id("project", $project->id),
            "badge" => view("project.column.badge", ["project" => $project])->render(),
            "offer" => $project->categories[0]->offer->name,
            "categories" => $project->categories->pluck("name")->implode(","),
            "status" => view("clients.column.status", ["project" => $project])->render(),
            "messenger" => view("project.column.messenger", ["project" => $project])->render(),
            "estimate" => view("clients.column.estimate", ["project" => $project ,"relaunch" => $relaunch ,"last_relaunch" => $last_relaunch])->render(),
            "version" => $project->version,
            "end_date" => $project->created_at->format("d-M-Y"),
        ];
    }

    public function accept_estimate(Project $project)
    {
        $project->infoGround()->save(new InfoGround());
        $project->estimate = "accepted";
        if ($project->save()) {
            return ["success" => true, "message" => trans("lang.accepted"), "redirect" => url("/project/detail/$project->id")];
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

        $relaunch =  new Relaunch();
        $relaunch->description = $request->reason;
        $relaunch->project_id = $project->id;
        $relaunch->created_by = Auth::user()->id;
        $relaunch->save();
        $project_relaunch = new ProjectRelaunch(["relaunch_id" => $relaunch->id ,'note' => $request->comment  , "created_by" => Auth::user()->id]);
        $project->relaunchs()->save( $project_relaunch);
        
        $project->estimate = "refused";
        if($project->save()){
            return ["success" => true, "message" => trans("lang.accepted")];
        }else {
            return ["success" => false, "message" => trans("lang.error_accept_estimate")];
        }
    }
}
