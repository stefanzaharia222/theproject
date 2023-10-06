<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.superAdmin.dashboard');
    }
}
