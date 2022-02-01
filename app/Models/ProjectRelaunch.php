<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRelaunch extends Model
{
    use HasFactory;

    protected $table = "project_relaunchs";
    protected $guarded = [];
    protected $with = ["createdBy","subject"];
    protected $appends  = ["attachements"];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,"created_by");
    }
    public function subject()
    {
        return $this->belongsTo(Relaunch::class,"relaunch_id");
    }

    public function getAttachementsAttribute()
    {
        if ($this->files) {
            return File::findMany(explode(",", $this->files));
        }
        return null;
    }
}
