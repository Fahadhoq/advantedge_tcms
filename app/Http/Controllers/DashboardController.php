<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {                   
        return view('Dashboard.dashboard' );
    }

    public function cancle()
    {
        return redirect()->back();
    }
}
