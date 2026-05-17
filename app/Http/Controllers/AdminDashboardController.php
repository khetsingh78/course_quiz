<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // dd('admin test') tast final test;
        return view('admin.dashboard');
    }
}
