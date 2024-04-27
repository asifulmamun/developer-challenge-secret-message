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
                                            <br>
                                            <small>{{ $message->created_at->format('d.m.Y \a\t h:i A') }}</small>
                                        </div>
                                    </div>
                                @else
                                    <!-- Receiver Message -->
                                    <div class="flex mb-4">
                                        <div class="bg-gray-200 text-black py-2 px-4 rounded-lg">
                                            {{ decrypt($message->message) }}
                                            <br>
                                            <small>{{ $message->created_at->format('d.m.Y \a\t h:i A') }}</small>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                                    
                            <!-- Input Box and Send Button -->
                            <form action="{{ route('send_msg') }}" method="POST" enctype="multipart/form-data">
                                @csrf
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