<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function viewDashboard()
    {
        return view('.admin.dashboard')->with('title', 'Dashboard');
    }
}
