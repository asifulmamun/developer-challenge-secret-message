<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function conversation(User $user)
    {


        $receiver = $user;

        return view('message', compact(
            'receiver'
        ));

    }
}
