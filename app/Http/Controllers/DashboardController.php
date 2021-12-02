<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        
        if (Auth::user()->is_client()) {
            return view("clients.dashboard.index");
        }
        return view("dashboard.index" ,['activities' => $this->activities()]);
    }
    public function activities()
    {
        $activities = ActivityLog::activities($options = []);
        $logs = [];
        foreach ($activities as $activity) {
            $logs[] = get_activities_template($activity);
        }
        return $logs;
    }
}