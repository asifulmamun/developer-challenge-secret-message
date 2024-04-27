<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use Carbon\Carbon;

class DeleteOldMessages extends Command
{
    protected $signature = 'messages:delete';
    protected $description = 'Delete old messages';

    public function handle()
    {
        // Fetch all messages with seen_status = 1
        $messagesToDelete = Message::where('seen_status', 1)->get();

        // Loop through each message
        foreach ($messagesToDelete as $message) {
            // Check if the message has a dlt_time set
            if (!is_null($message->dlt_time)) {
                // Calculate the delete duration based on the dlt_time of the message
                $deleteDuration = Carbon::parse($message->dlt_time); // parse means second
                
                // Check if the delete duration has passed
                if (Carbon::now()->gte($deleteDuration)) {
                    // Delete the message
                    $message->delete();
                    $this->info('Message ID ' . $message->id . ' deleted.');
                }
            }
        }

        $this->info('Deletion process completed.');
    }
}
