<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $table = "user_type";

    public function users(){
        return $this->hasMany(User::class);
    }

    static function dropdown($results)
    {
        
        $list = [];
        foreach ($results as $s) {
            $list[] = ["value" => $s->id , "text" => $s->description ];
        }
        return $list;
    }
    
}
