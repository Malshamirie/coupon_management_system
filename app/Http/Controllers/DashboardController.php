<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{


    public function admin_login()
    {
        return view('auth.login');
    }



    public function index()
    {
        return view('backend.dashboard');
    }


}
