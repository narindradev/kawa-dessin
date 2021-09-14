<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Status;
use App\Models\Project;
use App\Models\Priority;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $advance_filter = $this->advance_filter();
        $basic_filter =$this->basic_filter();
        
        return view("project.index", compact("advance_filter" ,"basic_filter"));
    }
    public function data_list(Request $request)
    {
        $data = [];
        $projects = Project::getDetails($request->all())->whereDeleted(0)->get();
        foreach ($projects as $project) {   
            $data[] = $this->_make_row($project );
        }
        return (["data" => $data]);
    }
    private function _make_row(Project $project)
    {
        $client = $project->client;
        return [
            view("project.rows.id")->render(),
            view("project.rows.info-client", ["client" => $client, "project" => $project])->render(),
            $project->categories->pluck("name"),
            view("project.rows.client-type", ["client" => $client])->render(),
            view("project.rows.estimate", ["client" => $client])->render(),
            $project->created_at->diffForHumans(),
            view("project.rows.actions")->render(),
        ];
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
            "label"=> trans("lang.date"),
            "name" => "date",
            "type" => "date-range",
        ];
        $filters[] = [
            "label"=> trans("lang.priority"),
            "name" => "priority_id", 
            "type" => "select",
            "options" =>  Priority::drop(),
        ];
        $filters[] = [
            "label"=> trans("lang.status"),
            "name" => "status_id",
            "type" => "select",
            "options" =>  Status::drop(),
        ];
        
        return $filters;
    }

    public function detail(Project $project){
        return view("project.detail.overview" ,compact("project"));
    }
}
