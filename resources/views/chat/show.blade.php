<x-flowbite-layout>
    @php
        $otherUser = $conversation->users->first();
    @endphp

    <div class="mb-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('chat.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                    {{ substr($otherUser->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $otherUser->name ?? 'Usuario' }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $otherUser->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <!-- Mensajes -->
        <div class="h-[500px] overflow-y-auto p-4 space-y-4" id="messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        @if($message->user_id != Auth::id())
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $message->user->name }}</p>
                        @endif
                        
                        <div class="rounded-lg p-3 {{ $message->user_id == Auth::id() ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' }}">
                            @if($message->message)
                                <p class="text-sm">{{ $message->message }}</p>
                            @endif

                            @if($message->attachments->count() > 0)
                                <div class="mt-2 space-y-2">
                                    @foreach($message->attachments as $attachment)
                                        <a href="{{ route('chat.download', $attachment) }}" class="flex items-center space-x-2 p-2 rounded {{ $message->user_id == Auth::id() ? 'bg-blue-700' : 'bg-gray-300 dark:bg-gray-600' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium truncate">{{ $attachment->file_name }}</p>
                                                <p class="text-xs opacity-75">{{ number_format($attachment->file_size / 1024, 1) }} KB</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 {{ $message->user_id == Auth::id() ? 'text-right' : '' }}">
                            {{ $message->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">No hay mensajes aún</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Envía el primer mensaje</p>
                </div>
            @endforelse
        </div>

        <!-- Formulario de envío -->
        <div class="border-t border-gray-200 dark:border-gray-700 p-4">
            <form method="POST" action="{{ route('chat.send', $conversation) }}" enctype="multipart/form-data" class="flex items-end space-x-2">
                @csrf
                <div class="flex-1">
                    <textarea 
                        name="message" 
                        rows="2" 
                        class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Escribe un mensaje..."
                    ></textarea>
                </div>
                <label for="files" class="cursor-pointer text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <input type="file" name="files[]" id="files" multiple class="hidden">
                </label>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Enviar
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Scroll al final de los mensajes
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }

        // Auto-refresh cada 5 segundos
        setInterval(() => {
            window.location.reload();
        }, 5000);
    </script>
    @endpush
</x-flowbite-layout>
