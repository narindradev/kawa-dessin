<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;
    protected $table = "priority";


    static function drop()
    {
        $list = [];
        $priority = Priority::all();
        foreach ($priority as $p) {
            $list[] = ["value" => $p->id , "text" => $p->name];
        }
        return $list;
    }
}
