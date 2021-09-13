<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $filters = $this->filters_table();
        return view("project.index", compact("filters"));
    }
    public function data_list(Request $request)
    {
        $data = [];
        $projects = Project::getDetails($request->all())->whereDeleted(0)->get();
        foreach ($projects as $project) {
            $data[] = $this->_make_row($project);
        }
        return (["data" => $data]);
    }
    private function _make_row(Project $project)
    {
        $user = $project->client->user;
        return [
            "#-$project->id",
            view("project.rows.info-client", ["user" => $user, "project" => $project])->render(),
            $project->categories()->pluck("name"),
            view("project.rows.client-type", ["user" => $user])->render(),
            view("project.rows.estimate", ["user" => $user])->render(),
            $project->created_at->diffForHumans(),
            view("project.rows.actions")->render(),
        ];
    }
    private function filters_table()
    {
        $filters = [];
        $filters[] = [
            "label" => "Status", "name" => "status_id", "type" => "select",
            "options" => [
                ["value" => 1, "text" => "new", "selected" => true],
                ["value" => 2, "text" => "recieveid"],
                ["value" => 3, "text" => "avec devis"],
            ]
        ];
        return $filters;
    }

    public function detail(Project $project){
        return view("project.detail.overview" ,compact("project"));
    }
}
