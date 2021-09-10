<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    
    public function index(){
        //my project
        return view("project.index");
    }

    public function data_list(){
        $project = Project::all();
    }
    
}
