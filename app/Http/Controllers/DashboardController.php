<?php

namespace App\Http\Controllers;

use App\Models\User;

use phpseclib3\Crypt\RSA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{

    public function index(){

        // $user = Auth::user();
        // if (empty($user->public_key) || empty($user->private_key)) {
        //     // Generate RSA key pair
        //     $rsa = new RSA();
        //     $keyPair = $rsa->createKey();
    
        //     // Update the user's record with the generated keys
        //     $user->public_key = $keyPair['publickey'];
        //     $user->private_key = $keyPair['privatekey'];
        //     $user->save();
        // }else{
            
            $users = User::all();
            return view('dashboard', compact('users'));
        // }


    }

}
