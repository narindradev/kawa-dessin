<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;
    
    protected $table = "questionnaires";
    protected $guarded = [];
    public function preliminary_question (){
        $questionstion_list = [];
        $questions  = $this->whereDeleted(0)->wherePreliminary(1)->get();
        foreach ($questions as $question ) {
            $questionstion_list[] = ["question"  => $question->question , "name" => "question_$question->id" ,"id" => $question->id ];
        }
        return  $questionstion_list;
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function responses()
    {
        return $this->hasMany(ProjectDescription::class);
    }

}
