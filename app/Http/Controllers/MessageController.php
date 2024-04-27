<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $message->dlt_time = 30;

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



    public function msg_seen(Request $request){

        // Validate the request
        $request->validate([
            'message_id' => 'required|exists:messages,id'
        ]);

        // Get the authenticated user's ID
        $userId = auth()->id();

        // Find the message
        $message = Message::where('id', $request->message_id)
                        ->where('seen_status', '!=', 1) // Add condition for seen_status
                        ->where('receiver_id', $userId)
                        ->first();

        // If the message is found and it belongs to the authenticated user
        if ($message) {
            // Update the seen_status to 1 and set the seen_time to current time
            $message->seen_status = 1;
            $message->seen_time = Carbon::now();
            $message->save();

            return response()->json([
                'msg' => 'Message Seen',
                'msg_id' => $request->message_id,
                'seen_status' => '1'
            ], 200);
        } /* else{
            return response()->json(['error' => 'Message not found or unauthorized'], 404);

        } */


    }

}
