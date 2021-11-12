<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = "status";


    static function drop()
    {
        $list = [];
        $status = Status::all();
        foreach ($status as $s) {
            $list[] = ["value" => $s->id , "text" => trans("lang.$s->name") ];
        }
        return $list;
    }
    static function dropProjectStatus()
    {
        $list = [];
        $status = Status::orderBy('id', 'DESC')->limit(4)->get();
        foreach ($status as $s) {
            $list[] = ["value" => $s->id , "text" => trans("lang.$s->name") ];
        }
        return $list;
    }
}
