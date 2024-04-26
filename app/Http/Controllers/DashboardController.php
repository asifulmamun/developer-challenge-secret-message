<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class dashboardController extends Controller
{

    public function index(){
        
        $users = User::all();



        return view('dashboard', compact('users'));

    }

}
