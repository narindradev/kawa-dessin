<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDescription extends Model
{
    use HasFactory;
    protected $table = "project_descriptions";
    protected $guarded = [];
    protected $with = ["questionnaire"];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
}
