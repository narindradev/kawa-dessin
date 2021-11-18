<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table = "files";
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
