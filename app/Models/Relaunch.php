<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relaunch extends Model
{
    use HasFactory;

    protected $table = "relaunchs";
    protected $guarded = [];

  

    static function drop($project = null)
    {
        $list = [];
        $relaunchs = $project ? Relaunch::where("project_id" , $project->id)->orWhere(function ($q)
        {
            $q->whereNull('project_id');
        })->get() : Relaunch::all();
        foreach ($relaunchs as $relaunch) {
            $list[] = ["value" => $relaunch->id , "text" => $relaunch->description];
        }
        return $list;
    }
}
