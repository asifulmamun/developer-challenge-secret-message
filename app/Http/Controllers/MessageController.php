<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use App\Models\Message;

class MessageController extends Controller
{
    public function send_msg(Request $request){

        // Validate the incoming request data
        $validatedData = $request->validate([
            'receiver_id' => 'required|exists:users,id', // Assuming receiver_id corresponds to the id column in the users table
            'msg' => 'required|string',
        ]);

        // Encrypt the message
        $encryptedMessage = Crypt::encrypt($validatedData['msg']);

        // Create a new message instance
        $message = new Message();
        $message->sender_id = Auth::id(); // Set sender_id to the currently authenticated user's id
        $message->receiver_id = $validatedData['receiver_id'];
        $message->message = $encryptedMessage;

        // Save the message to the database
        $message->save();

        // Optionally, you can return a response indicating success or redirect somewhere
        return response()->json(['message' => 'Message sent successfully'], 200);
    }
}
