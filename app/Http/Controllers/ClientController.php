<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;


class ClientController extends Controller
{


    public function index()
    {
        /** Dashbord client */
        return true;
    }
    public function projects()
    {
        return view("clients.projects");
    }
    public function data_list()
    {
        $client_id = User::find(77)->client_id();
        $data = [];
        $projects = Project::whereDeleted(0)->where("client_id", $client_id)->get();
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
            "end_date" => $project->created_at->format("d-M-Y"),
            "version" => $project->version,
            "messenger" => view("project.column.messenger", ["project" => $project])->render(),
        ];
    }
}
