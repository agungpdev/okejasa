<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $page ="App Accounting";

    public function index(){
        return view('dashboard.index',['title'=>$this->page]);
    }
}
