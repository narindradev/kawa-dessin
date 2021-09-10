<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $guarded = [];

    public function offer()
    {
        return $this->belongsTo(offer::class);
    }
    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class,"category_id");
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
    
}
