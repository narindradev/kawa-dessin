<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

    


class ActivityLog 
{   
    public static $colunms =[
        "status_id" => ["model" => Status::class ,"colunm" => "name" ,"has_lang" => true],
        "client_id" => ["model" => Client::class ,"colunm" =>"client" ],
    ];
    public static function get_relation($key = "" ,$val =""){
        $colunms = self::$colunms;
        if (get_array_value($colunms ,$key)) {
            $foreign_key = get_array_value($colunms ,$key);
            $model =  get_array_value($foreign_key ,"model");
            $colunm = get_array_value($foreign_key, "colunm");
            if ($colunm ) {
                return $model::find($val)->$colunm;
            }
            return $model::find($val);
        }
    }
    public static function has_relation($key = "" ){
        if (get_array_value(self::$colunms ,$key)) {
            return true;
        }
        return false;
    }
    public static function has_lang($key = ""){
        $colunm = get_array_value(self::$colunms ,$key);
        return get_array_value($colunm,"has_lang");
    }
    public static function activities($options = []){
        $auth = Auth::user();
        $take= 8;
        if ($auth->is_admin()) {
            // return Activity::all()->groupBy(function($item){ return $item->created_at->format('d-M-y'); });
            $activities = Activity::query();
        }else {
            $activities = Activity::whereRaw('FIND_IN_SET(' . $auth->id . ',users)');
        }
        $offset = get_array_value($options, "offset");
        if ($offset){
            $activities->skip($offset);
        }
        return $activities->orderBy('id', "DESC")->take($take)->get();
    }
    public static function get_causer_info($activity){
        $subject = [];
        $subject['name'] = "on";
        $subject['profile'] = null;
        if ($activity->causer_id ) {
            $user = User::find($activity->causer_id);
            $subject['name'] = $user->name;
            $subject['profile'] = $user->avatar_url;
        } 
       return $subject;
    }
    public static function descriptions($activity){
        $descriptions = ["created" => trans("lang.created") ,"updated" => trans("lang.updated") ,"deleted" =>  trans("lang.deleted") ];
        return get_array_value($descriptions ,$activity->description);
    }

    public static function user_created($activity){
        $template = ["class" => "primary"];
        $template = [];
        $template["date"] = $activity->created_at;
        $template["description"] =  self::descriptions($activity);
        $causer = self::get_causer_info($activity);
        $template["causer"] = get_array_value($causer ,"name");
        $template["profile"] =  get_array_value($causer ,"profile");
        $user = $activity->subject_type::find($activity->subject_id);
        if ($user->not_client()) {
            $template["sentence"] = get_array_value($template , "causer" ) ."  a ajouté $user->name  dans " .app_setting("app_name");               
        }else {
            $template["sentence"] = " $user->name a fait une incription dans ".app_setting("app_name");
        }
        return $template;
    }
    /** Projects */

    public static function project_updated($activity){
        $template = ["class" => "info"];
        $template["date"] = $activity->created_at;
        $template["description"] =  self::descriptions($activity);
        $causer = self::get_causer_info($activity);
        $template["causer"] = get_array_value($causer ,"name");
        $template["profile"] =  get_array_value($causer ,"profile");
        
        $project = $activity->subject_type::find($activity->subject_id);
        $template["sentence"] = get_array_value($template , "causer" ) ."  a mis à jour le projet ".project_tag($project) ;               
        $template["changed"] = "";
        if ($activity->properties) {
            $template["changed"] = get_changed_column($activity);
        }
        return $template;
    }
    public static function project_created($activity){
        $template = ["class" => "info"];
        $template["date"] = $activity->created_at;
        $template["description"] =  self::descriptions($activity);
        $causer = self::get_causer_info($activity);
        $template["causer"] = get_array_value($causer ,"name");
        $template["profile"] =  get_array_value($causer ,"profile");
        
        $project = $activity->subject_type::find($activity->subject_id);
        $template["sentence"] = " Nouveau projet crée ".project_tag($project) ;               
        $template["changed"] = "";
        // if ($activity->properties) {
        //     $template["changed"] = get_changed_column($activity);
        // }
        return $template;
    }
    public static function project_member_added($activity){
        $template = ["class" => "success"];
        $template["date"] = $activity->created_at;
        $template["description"] =  self::descriptions($activity);
        $causer = self::get_causer_info($activity);
        $template["causer"] = get_array_value($causer ,"name");
        $template["profile"] =  get_array_value($causer ,"profile");
        $users = User::findMany($activity->properties["new_members"]);
        $project = $activity->subject_type::find($activity->subject_id);
        $members = $users->implode("name",", ");
        $template["sentence"] = get_array_value($template ,"causer" )." a ajouté <u> $members </u> dans le projet " . project_tag($project);               
        return $template;
    }
    public static function project_member_detached($activity){
        $template = ["class" => "danger"];
        $template["date"] = $activity->created_at;
        $template["description"] =  self::descriptions($activity);
        $causer = self::get_causer_info($activity);
        $template["causer"] = get_array_value($causer ,"name");
        $template["profile"] =  get_array_value($causer ,"profile");
        $users = User::findMany($activity->properties["detached_members"]);
        $project = $activity->subject_type::find($activity->subject_id);
        $members = $users->implode("name",", ");
        $template["sentence"] = get_array_value($template ,"causer")." a retiré <u> $members </u> dans le projet " . project_tag($project);               
        return $template;
    }
}
