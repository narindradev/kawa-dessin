<?php

use App\Models\Project;
use Illuminate\Support\Facades\Cache;

if (!function_exists('get_response_of_question')) {
    function get_response_of_question($questionnaire_id = 0, $project_id = 0)
    {
        return Cache::rememberForever(
            "response_of_questionnaire_id_{$questionnaire_id}_project_id_{$project_id}",
            function () use ($questionnaire_id, $project_id) {
                $response = App\Models\ProjectDescription::where("questionnaire_id", $questionnaire_id)->where("project_id", $project_id)->first();
                return $response ? $response->answer : "";
            }
        );
    }
}
if (!function_exists('get_cache_member')) {
    function get_cache_member(Project $project)
    {
        return Cache::rememberForever("members_list_$project->id", function () use ($project) {
            return $project->members()->get();
        });
    }
}
if (!function_exists('app_setting')) {
    function app_setting($key = "")
    {
        return Cache::rememberForever("app_setting_$key", function () use ($key) {
            return Setting::_get($key);
        });
    }
}
