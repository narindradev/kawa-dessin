<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $guarded = [];
    protected $with = ["offer"];
    
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
    
    static function drop()
    {
        $list = [];
        $cats = Category::whereDeleted(0)->get();
        foreach ($cats as $cat) {
            $list[] = ["value" => $cat->id , "text" => $cat->name];
        }
        return $list;
    }
    
}
