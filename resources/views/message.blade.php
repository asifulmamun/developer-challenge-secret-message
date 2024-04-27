<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{ $sender->name }} Sending {{ $receiver->name }}
                    <hr>

                    <div class="container mx-auto px-4 py-8">
                        <div class="max-w-md mx-auto">
                            


                            <!-- Display messages -->
                            @foreach ($messages->sortBy('created_at') as $message)
                                @if ($message->sender_id == $sender->id)
                                    <!-- Sender Message -->
                                    <div class="flex justify-end mb-4">
                                        <div class="bg-blue-500 text-white py-2 px-4 rounded-lg">
                                            {{ decrypt($message->message) }}
                                            <div class="w-full border-b border-gray-800"></div>
                                            <small class="text-xs">{{ $message->created_at->format('d.m.Y \a\t h:i A') }}</small>
                                            <small class="text-xs" id="msg_{{ $message->id }}">
                                                @if ($message->seen_time)
                                                <br>
                                                {{ 'seen ' . $message->seen_time ?? '' }}
                                                @endif
                                                @if ($message->dlt_time)
                                                <br>
                                                {{ 'Delete within ' . $message->dlt_time . ' sec, after seen time' ?? '' }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <!-- Receiver Message -->
                                    <div class="flex mb-4">
                                        <div class="bg-gray-200 text-black py-2 px-4 rounded-lg">
                                            {{ decrypt($message->message) }}
                                            <div class="w-full border-b border-gray-800"></div>
                                            <small class="text-xs">{{ $message->created_at->format('d.m.Y \a\t h:i A') }}</small>
                                            <small class="text-xs" id="msg_{{ $message->id }}">
                                                @if ($message->seen_time)
                                                <br>
                                                {{ 'seen ' . $message->seen_time ?? '' }}
                                                @endif
                                                @if ($message->dlt_time)
                                                <br>
                                                {{ 'Delete within ' . $message->dlt_time . ' sec, after seen time' ?? '' }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                @endif


                                <script>
                                    $(document).ready(function() {
                                        @if ($message->sender_id != $sender->id)
                                            var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                            $.ajax({
                                                url: '/msg-seen',
                                                type: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken
                                                },
                                                data: {
                                                    message_id: {{ $message->id }},
                                                },
                                                success: function(response) {
                                                    // console.log(response.msg_id);
                                                    $('#msg_'+response.msg_id).text('seen');
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log(error);
                                                }
                                            });
                                        @endif
                                    });
                                </script>
                            @endforeach
                                    
                            <!-- Input Box and Send Button -->
                            <form action="{{ route('send_msg') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="dlt_time">Delete message within</label>
                                <select class="text-gray-500" name="dlt_time" id="dlt_time">
                                    <option value="">None</option>
                                    <option value="10">10 sec</option>
                                    <option value="30">30 sec</option>
                                    <option value="60">1 min</option>
                                </select>
                                <div class="flex items-center mt-4">
                                    <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                                    <input id="message-input" type="text" name="msg" class="flex-1 border text-gray-800 border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:border-blue-500" placeholder="Type your message...">
                                    <button type="submit" id="send-btn" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<div class="text-red-500">
    @if(session('success'))
        {{ session('success') }}
    @endif
</div>