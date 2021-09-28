<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    use HasFactory;
    protected $table = "project_files";
    protected $guarded = [];
    protected $with = ["uploader"];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function uploader()
    {
        return $this->belongsTo(User::class,"created_by");
    }
}
