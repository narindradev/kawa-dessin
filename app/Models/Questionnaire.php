<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;
    
    protected $table = "questionnaires";
    protected $guarded = [];
    
    public $questions = [
        [
            "question" => "Quelles sont les constructions concernées par le projet?",
            "value" =>  "question1"
        ],
        [
            "question" => "Quelles sont les constructions concernées par le projet?",
            "value" =>  "question2"
        ],
        [
            "question" => "Quel est la surface de plancher créée par le projet?",
            "value" =>  "question3"
        ],
        [
            "question" => "Quel est la surface de plancher des constructions existantes ?",
            "value" =>  "question4",
            "rows" =>  "3"
        ],
    ];


    public function preliminary_question (){
         return $this->questions;
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
