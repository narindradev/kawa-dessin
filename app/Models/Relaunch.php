<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relaunch extends Model
{
    use HasFactory;

    protected $table = "relaunchs";
    protected $guarded = [];

    public function relaunchs()
    {
       return $this->belongsToMany(Project::class,"project_relaunch") ;
    }

    static function drop()
    {
        $list = [];
        $relaunchs = Relaunch::all();
        foreach ($relaunchs as $relaunch) {
            $list[] = ["value" => $relaunch->id , "text" => $relaunch->description];
        }
        return $list;
    }
}