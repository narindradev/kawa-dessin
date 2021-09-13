<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        //my project
        return view("project.index");
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
            "#",
            view("project.template-row.name",["user" => $user ,"status" => $project->status_id])->render(),
            $project->categories()->pluck("name"),
            trans("lang.{$user->client->type}") ,
            $project->created_at->diffForHumans(),
            view("project.template-row.actions")->render(),

        ];
    }
}
