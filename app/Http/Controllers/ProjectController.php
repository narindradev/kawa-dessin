<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Status;
use App\Models\Project;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Relaunch;
use App\Models\InfoGround;
use App\Models\ProjectFiles;
use Illuminate\Http\Request;
use App\Models\ProjectRelaunch;
use App\Models\ProjectDescription;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PriceProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $advance_filter = $this->advance_filter();
        $basic_filter = $this->basic_filter();
        $users = $this->dessignators_list();
        return view("project.index", compact("advance_filter", "basic_filter", "users"));
    }
    public function data_list(Request $request)
    {
        $data = [];
        $projects = Project::getDetails($request->all())->get();
        foreach ($projects as $project) {
            $data[] = $this->_make_row($project);
        }
        return (["data" => $data]);
    }
    public function _make_row(Project $project, $for_user = null)
    {
        $client = $project->client;
        $last_relauch = ProjectRelaunch::where("project_id", $project->id)->where("created_by", $client->user->id)->latest('created_at')->first();
        $relaunch = Relaunch::where("project_id", $project->id)->where("created_by", $client->user->id)->latest('created_at')->first();
        $actions = [];
        $column = [
            "DT_RowId" => row_id("projects", $project->id),
            "badge" => view("project.column.badge", ["project" => $project])->render(),
            "client_info" => view("project.column.info-client", ["client" => $client, "project" => $project])->render(),
            "messenger" => view("project.column.messenger", ["client" => $client, "project" => $project])->render(),
            "categories" => $project->categories->pluck("name")->implode(" , ", "name"),
            "client_type" => view("project.column.client-type", ["client" => $client])->render(),
            "status" => view("project.column.status", ["project" => $project])->render(),
            "estimate" => view("project.column.estimate", ["project" => $project, "last_relaunch" => $last_relauch, "relaunch" =>  $relaunch])->render(),
            "version" => $project->version,
            "date" => $project->created_at->format("d-M-Y"),
            "actions" => view("project.column.actions", ["actions" => $actions, "project" => $project])->render(),
        ];
        if($for_user && $for_user->user_type_id == 2){
            
        }
        return  $column; 
    }
    /** Relaunch summary */
    public  function relaunch(Project $project)
    {
        $subjects = Relaunch::drop();
        return view("project.relaunch.summary", compact("project", "subjects"));
    }
    public  function add_relaunch(Request $request, Project $project)
    {
        $request->validate(['subject' => 'required']);
        $relaunch = new ProjectRelaunch(['note' => $request->note, "relaunch_id" => $request->subject, "created_by" => Auth::user()->id]);
        $project->relaunchs()->save($relaunch);
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row" => row_id("project", $project->id), "project" => $this->_make_row($project), "relaunch" => $this->_make_relaunch_row($relaunch)]));
    }
    public function relaunch_list(Project $project)
    {

        $data = $relaunchs = [];
        $project->load("relaunchs");
        $relaunchs = $project->relaunchs;

        foreach ($relaunchs as $relaunch) {
            $relaunch->load("subject");
            $data[] = $this->_make_relaunch_row($relaunch);
        }
        return ["data" => $data];
    }

    private function _make_relaunch_row($relaunch)
    {
        return [
            "subjet" => $relaunch->subject ? $relaunch->subject->description : "",
            "note" => $relaunch->note ?? "-",
            "date" => "<span class ='text-muted me-2 fs-7'> <i>" . $relaunch->created_at->diffForHumans() . "</i></span>",
            "created_by" => $relaunch->createBy->name,
            "status" => '<i class="fas fa-check text-success"></i>',
        ];
    }
    public function estimat_form(Project $project)
    {
        return view("project.estimate.estimate-modal-form", compact("project"));
    }
    public function add_estimate(PriceProjectRequest $request, Project $project)
    {
        $project->price = $request->devis;
        $project->status_id = 3; // estimated
        $project->save();
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row_id" => row_id("projects", $project->id), "project" => $this->_make_row($project)]));
    }
    private function advance_filter()
    {
        $filters = [];
        $filters[] = [
            "label" => "Status",
            "name" => "sqdqsd",
            "type" => "select",
            "options" => [
                ["value" => 1, "text" => "new", "selected" => true],
                ["value" => 2, "text" => "recieveid"],
                ["value" => 3, "text" => "avec devis"],
            ]
        ];
        return $filters;
    }
    private function basic_filter()
    {

        $filters = [];

        $filters[] = [
            "label" => trans("lang.clients"),
            "name" => "client_id",
            "type" => "select",
            "options" =>  Project::get_client_dropdown(Auth::user()->id),
        ];
        /*
        $filters[] = [
            "label" => trans("lang.date"),
            "name" => "date",
            "type" => "date-range",
        ];
        */
        $filters[] = [
            "label" => trans("lang.client_type"),
            "name" => "client_type",
            "type" => "select",
            "options" => [
                ["value" => "particular", "text" => "Particulier"],
                ["value" => "corporate", "text" => "Entreprise"],
            ],
        ];

        $filters[] = [
            "label" => trans("lang.priority"),
            "name" => "priority_id",
            "type" => "select",
            "options" =>  Priority::drop(),
        ];
        $filters[] = [
            "label" => trans("lang.status"),
            "name" => "status_id",
            "type" => "select",
            "options" =>  Status::drop(),
        ];
        $filters[] = [
            "label" => trans("lang.type"),
            "name" => "categorie_id",
            "type" => "select",
            "options" =>  Category::drop(),
        ];

        return $filters;
    }
    public function dessignators_list()
    {

        $list = [];
        $dessignators = User::where("user_type_id", 4)->get();
        foreach ($dessignators as $user) {
            $int = random_int(1, 50);
            $list[] =  [
                "value" => $user->id,
                "name" => $user->first_name . ' ' . $user->last_name,
                "avatar" => "https://i.pravatar.cc/80?img=$int",
                "email" => $user->email,
            ];
        }
        return ($list);
    }

    public function detail(Project $project)
    {
        // User::find(12)->notify(new ProjectAssignedNotification($project));
        // dd("ok");
        $project->load("categories");
        $project->load("infoGround");
        foreach ($project->categories as $categorie) {
            $categorie->load("questionnaires"); // load categorie questionnaires
            $categorie->offer->load("questionnaires"); // load categorie offer questionnaires
        }
        return view("project.detail.index", compact("project"));
    }
    public function save_info_ground(Request $request, Project $project)
    {
        if ($request->ground_info_id) {
            InfoGround::find($request->ground_info_id)->update($request->except("_token", "ground_info_id"));
        } else {
            $info_ground = new InfoGround($request->except("_token", "ground_info_id"));
            $project->infoGround()->save($info_ground);
        }
        return ["success" => true, "message" => trans("lang.success_record")];
    }

    public function save_responses_of_question(Request $request, Project $project)
    {
        $project_id = $project->id;
        $responses = $request->except("_token");
        foreach ($responses as $input => $value) {
            $questionnaire_id = str_replace("questionnaire_id_", "", $input);
           if($questionnaire_id){
               ProjectDescription::updateOrCreate(
                   ["project_id" => $project_id, "questionnaire_id" => $questionnaire_id],
                   ["answer" => $value]
               );
               Cache::forget("response_of_questionnaire_id_" . $questionnaire_id . "project_id_" . $project_id);
           }
        }
        return ["success" => true, "message" => trans("lang.success_record")];
    }
   
    public function tab_description(Project $project)
    {
        $project->load("descriptions");
        $count = $project->files()->wherePreliminary(1)->whereDeleted(0)->count();
        return view("project.detail.description", compact("project", "count"));
    }
    public function project_files(Project $project)
    {
        $data = [];
        $files = $project->files()->wherePreliminary(1)->whereDeleted(0)->latest()->get();
        foreach ($files as $file) {
            $data[] = $this->_make_file_row($file);
        }
        return (["data" => $data]);
    }
    private function _make_file_row($file)
    {
        return [
            view("project.column.file", ["file" => $file])->render(),
            anchor(url("/project/download/file/$file->id"), '<i class="fas fa-cloud-download-alt"></i>', ["class" => "text-hover-primary", "title" => trans("lang.download")])
        ];
    }

    public function download_file(ProjectFiles $file)
    {
        $file->load("project");
        if ($file->project->is_member() || $file->project->own_project()) {
            $uri = public_path($file->url);
            return response()->download($uri, $file->originale_name);
        }
        abort(403);
    }
}
