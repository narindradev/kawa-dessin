<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";
    protected $guarded = [];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeGetDetails($query ,$options = [])
    {
        $project = Project::query();
        
        $status_id = get_array_value($options,"status_id");
        if($status_id){
            $project->where("status_id" ,$status_id);
        }

        $priority_id = get_array_value($options,"priority_id");
        if($priority_id){
            $project->where("priority_id" ,$priority_id);
        }

        $client_id = get_array_value($options,"client_id");
        if($client_id){
            $project->where("client_id" ,$client_id);
        }
        $validation = get_array_value($options,"validation");
        if($validation){
            $project->where("validation" ,$validation);
        }
        $version = get_array_value($options,"version");
        if($version){
            $project->where("version" ,$version);
        }
        return $project;
    }
}
