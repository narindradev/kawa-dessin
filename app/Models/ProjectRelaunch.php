<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRelaunch extends Model
{
    use HasFactory;

    protected $table = "project_relaunchs";
    protected $guarded = [];
    protected $with = ["createBy","subject"];
    

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function createBy()
    {
        return $this->belongsTo(User::class,"created_by");
    }
    public function subject()
    {
        return $this->belongsTo(Relaunch::class,"relaunch_id");
    }
}
