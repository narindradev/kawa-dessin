<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    
    protected $table = "offers";
    protected $guarded = [];
    

    public function categories()
    {
        return $this->hasMany(Category::class,"offer_id")->whereDeleted(0);
    }
    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class,"offer_id")->whereDeleted(0);
    }
    
}
