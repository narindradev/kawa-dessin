<?php

use App\Models\ActivityLog;
use App\Models\NotificationTemplate;

if (!function_exists('get_template')) {
    function get_template($notification = null)
    {
        $event = $notification->data["event"];
        if ($event) {
            if (method_exists(NotificationTemplate::class, $event)) {
                return NotificationTemplate::$event($notification);
            }
        }
    }
}
if (!function_exists('get_activities_template')) {
    function get_activities_template($activity = null)
    {
        $event =  $activity->log_name . "_" . $activity->description;
        if (method_exists(ActivityLog::class, $event)) {
            return ActivityLog::$event($activity);
        }
    }
}
if (!function_exists('get_changed_column')) {
    function get_changed_column($activity = null)
    {
        $changed = "";
        $properties = $activity->properties->toArray();
        $news   = $properties["attributes"];
        $olds   = $properties["old"];
        /** Display changed values */
        foreach ($olds as $key => $value) {
            $old_val = $value;
            $new_val = get_array_value($news, $key);
            if (ActivityLog::has_relation($key)) {
                $old_val    =  ActivityLog::get_relation($key, $value);
                $new_val    =  ActivityLog::get_relation($key, get_array_value($news, $key));
                $has_lang   =  ActivityLog::has_lang($key);
                if ($has_lang) {
                    $old_val = trans("lang.$old_val");
                    $new_val = trans("lang.$new_val");
                }
            }
            if (strpos($key, 'date') ) {
                $old_val = $old_val ? (new DateTime($old_val))->format('d-m-Y') : trans("lang.nothing")  ;
                $new_val = $new_val ? (new DateTime($new_val))->format('d-m-Y') :  trans("lang.nothing") ; 
            }
            if ($key == "price" ) {
                $old_val = format_to_currency($old_val);
                $new_val = format_to_currency($new_val);
            }
            $changed .= "<u>".(trans("lang.$key") ?? $key)."</u>"  . " :  " . "<s>" .($old_val ?? trans("lang.nothing")) ."</s>" . '  <i class="fas fa-arrow-right"></i>  ' . ($new_val ?? trans("lang.nothing"))  . "<br>";
        }
        return $changed;
    }
}
