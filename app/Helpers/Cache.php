<?php

use App\Models\User;
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
        // Cache::forget("members_list_$project->id");
        return Cache::rememberForever("members_list_$project->id", function () use ($project) {
            return $project->members()->get();
        });
    }
}
if (!function_exists('app_setting')) {
    function app_setting($key = "")
    {
        return Cache::rememberForever("app_setting_$key", function () use ($key) {
            return \App\Models\Setting::_get($key);
        });
    }
}
if (!function_exists('get_cache_chat_user')) {
    function get_cache_chat_user()
    {
        $auth = auth()->user();
        return User::whereDeleted(0)->where('user_type_id', '<>', 5)->where("id",'<>' ,  $auth->id)->get()->each->setAppends(['message_not_seen']);
    }
}
if (!function_exists('get_cache_chat_user_target')) {
    function get_cache_chat_user_target(User $user )
    {
        $auth = auth()->user();
        return Cache::rememberForever("get_cache_chat_user_$auth ", function () use ($auth ) {
            return  User::whereDeleted(0)->where('user_type_id', '<>', 5)->where("id",'<>' ,  $auth->id)->get()->each->setAppends(['message_not_seen']);
        });
    }
}