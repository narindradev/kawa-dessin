<?php

use App\Models\NotificationTemplate;

if (!function_exists('get_template')) {
    function get_template($notification = null)
    {
        $event = $notification->data["event"];
        if ($event) {
            if (method_exists(NotificationTemplate::class,$event)) {
                return NotificationTemplate::$event($notification);
            }
        }
    }
}