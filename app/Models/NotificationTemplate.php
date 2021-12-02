<?php

namespace App\Models;

class NotificationTemplate 
{
    static function get_subject_info($notification){
        $subject = [];
        $subject['name'] = "on";
        $subject['profile'] = null;
        if (isset($notification->data["created_by"]) && $notification->data["created_by"]) {
            $subject['name'] = User::find($notification->data["created_by"])->name;
            $subject['profile'] = '<img alt="Pic" src="https://i.pravatar.cc/80?img=33">';
        } 
       return $subject;
    }
    /** Event template */
    public static function invoice_item_paid($notification = null){
        $template = [];
        $template["title"]= "Paiment facture";
        $template["sentence"] =  "Paiment du facture #-";
        return  $template;
    }
    /** Event project assigned */
    public static function project_assigned($notification = null){
        $template = [];
        $template["title"]= "Projet assigné";
        $subject_info = self::get_subject_info($notification);
        
        $subject =  $subject_info['name'];
        $template["profile"] = $subject_info["profile"] ; 
        $template["sentence"] = "$subject vous a assigné un project.";
        return $template ;
    }
}
