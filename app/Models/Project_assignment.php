<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_assignment extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public static function getAssignTo($user_type = ""){
        $user= self::where('user_type',$user_type)->first();
        $last_assigned = $user->last_assigned;
        if($user->users){
            $user_list= explode(',',$user->users);
            $to = $user_list[(count($user_list)-1)];
            unset($user_list[(count($user_list)-1)]);
            $last_assigned =   $last_assigned ? $last_assigned .','.$to : $to  ;
            self::where('user_type',$user_type)->update( [ "users"=> implode(",", $user_list), "last_assigned" => $last_assigned]);
            
            return User::find($to);
        }else{
            self::setAssignTo($user_type);
            return self::getAssignTo($user_type);
        }
    }
    public static function setAssignTo($user_type = "")
    {
        $user_type = UserType::where("name",$user_type)->first();
        $user = User::where('user_type_id',$user_type->id)->whereDeleted(0)->get();
        return Project_assignment::where('user_type',$user_type->name)->update(["users" => $user->implode("id",","),"last_assigned" =>null]);
    }

    public static function addNewUserToProjectAssigment($new_users = "", $user_type_name = ""){
        $project_assign = self::where('user_type',$user_type_name)->first();
        $project_assign->users =  $project_assign->users ?   $project_assign->users .",".$new_users : $new_users;
        return $project_assign::save();
    }
}
