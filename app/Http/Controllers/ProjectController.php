<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceProjectRequest;
use App\Models\User;
use App\Models\Status;
use App\Models\Project;
use App\Models\Category;
use App\Models\Priority;
use App\Models\ProjectFiles;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $advance_filter = $this->advance_filter();
        $basic_filter = $this->basic_filter();
        $users = $this->user_list();
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
    private function _make_row(Project $project)
    {
        $client = $project->client;
        $actions = [];
        return [
            "DT_RowId" => row_id("project", $project->id),
            "badge" => view("project.column.badge", ["project" => $project])->render(),
            "client_info" => view("project.column.info-client", ["client" => $client, "project" => $project])->render(),
            "messenger" => view("project.column.messenger", ["client" => $client, "project" => $project])->render() ,
            "categories" => $project->categories->pluck("name"),
            "client_type" => view("project.column.client-type", ["client" => $client])->render(),
            "status" => view("project.column.status", ["project" => $project])->render(),
            "estimate" => view("project.column.estimate", ["price" => $project->price])->render(),
            "version" => $project->version,
            "date" => $project->created_at->format("d-M-Y"),
            // $project->created_at->diffForHumans(null,true),
            "actions" => view("project.column.actions", ["actions" => $actions, "project" => $project])->render(),
        ];
    }
    /** Relaunch summary */
    public  function relaunch(Project $project)
    {
        $subjects = array(
            ["value" => 1, "text" => "Etude de devis"],
            ["value" => 2, "text" => "Paiment pour le 1ér tranche"],
            ["value" => 3, "text" => "Paiment pour le 2èm tranche"],
        );
        return view("project.relaunch.summary", compact("project", "subjects"));
    }
    public  function add_relaunch(Request $request)
    {
        $request->validate(['subject' => 'required']);
        $project_id = $request->project_id;
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row" => row_id("project", $project_id), "project" => $this->_make_row(Project::find($project_id)), "data" => [$request->note ?? "note", "instant", ' <i class="fas fa-check text-success"></i>']]));
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
        die(json_encode(["success" => true, "message" => trans("lang.success_record"), "row" => row_id("project", $project->id), "project" => $this->_make_row($project)]));
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
            "label" => trans("lang.date"),
            "name" => "date",
            "type" => "date-range",
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
    public function user_list()
    {
        $list = [];
        $users = User::all();
        foreach ($users as $user) {
            $list[] =  [
                "value" => $user->id,
                "name" => $user->first_name . ' ' . $user->last_name,
                "avatar" => "https://i.pravatar.cc/80?img=2",
                "email" => $user->email,
            ];
        }
        return ($list);
    }

    public function detail(Project $project)
    {
        return view("project.detail.index", compact("project"));
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
    }
}
