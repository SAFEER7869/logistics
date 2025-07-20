<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
class AdminDashboardController extends Controller
{
    public function  index(){
        return view('dashboard');
    }
     public function  success(){
        return view('client.success');
    }
}

