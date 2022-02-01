<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = "status";
    private static $execlude_status = [2,3];
    static function drop($for_user )
    {
        $list = [];
        $q = Status::query();
        if ($for_user->is_mdp() || $for_user->dessignator()) {
            $q->whereNotIn("id",self::$execlude_status);
        }
        $status =  $q->get();
        foreach ($status as $s) {
            $list[] = ["value" => $s->id , "text" => trans("lang.$s->name") ,"class" => $s->class ];
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
    static function StepOfStateProject(Project $project)
    {
        
        $states = [
            ["step" => "1", "title" => "Création" ,"desc" => "Les informations du projet" , "current" => ($project->status_id  == 1) ,"completed" => ($project->status_id  > 1)],
            ["step" => "2", "title" => "Traitement" ,"desc" => "En attente etude du projet" ,"current" => ($project->status_id  == 2) ,"completed" => ($project->status_id > 2)],
            ["step" => "3", "title" => "Paiment" ,"desc" => "Paiment du 1er tranche","current" => ($project->status_id  == 3) ,"completed" => ($project->estimate =="accepted" && $project->price && $project->invoice->status->name != "not_paid"  )],
            ["step" => "4", "title" => "Complétion" ,"desc" => "Complétion du dossier" ,"current" => ($project->status_id  == 3) ,"completed" => ($project->estimate =="accepted" && $project->price && $project->invoice->status->name == "part_paid"  )],
            ["step" => "5", "title" => "Réalisation" ,"desc" => "Projet en cours de realisation" ,"current" => ($project->status_id  >= 5 ) ,"completed" => ( $project->status_id  > 7)],
            ["step" => "6", "title" => "Paiment" ,"desc" => "Paiment du 2em tranche" ,"current" => ($project->status_id > 8) ,"completed" => ( $project->status_id == 8 && $project->invoice->status->name == "part_paid"  ) ],
            ["step" => "7", "title" => "Terminé" ,"desc" => "Livraison","current" => ($project->status_id == 8) ,"completed" => ( $project->status_id == 8 &&  $project->invoice->status->name == "paid")],
        ];
        return $states;
    }

    static function validation($status)
    {   
        $validate = 0;
        if($status == 7){
            $validate = 0;
        }
        if($status == 8){
            $validate= 1;
        }
        return $validate;
    }
}
