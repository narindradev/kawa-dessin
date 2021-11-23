<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        
        if (Auth::user()->is_client()) {
            return view("clients.dashboard.index");
        }
        return view("dashboard.index");
    }
    // public function activity()
    // {
    //     dd(compact("activities"));
    //     return view("dashboard.activity" ,compact("activities"));
    // }
}
