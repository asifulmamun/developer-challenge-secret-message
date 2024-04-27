<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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
        // return response()->json(['message' => 'Message sent successfully'], 200);
        return back()->with('success', 'Message sended');
    }






    public function conversation(User $user)
    {

        $sender = Auth::user();
        $receiver = $user;


        // Retrieve messages where the sender ID is the current user's ID
        $sentMessages = Message::
            where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->get();

        // Retrieve messages where the receiver ID is the current user's ID
        $receivedMessages = Message::
            where('sender_id', $receiver->id)
            ->where('receiver_id', $sender->id)
            ->get();

        // Combine sent and received messages
        $messages = $sentMessages->merge($receivedMessages);

        return view('message', compact(
            'sender',
            'receiver',
            'messages',
        ));
    }
}
