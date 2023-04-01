<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="grid sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-2 p-6 text-gray-900 dark:text-gray-100">
                    @forelse ($chatboxes as $chatbox)
                    <div
                        class="flex flex-col justify-between max-w-sm p-6 m-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                @php
                                // Get the first message content to be displayed in the chatbox list
                                $messages = json_decode($chatbox->messages, true);
                                $first_message_content = array_reduce($messages, function($carry, $item) {
                                if (!$carry && array_key_exists('content', $item)) {
                                return $item['content'];
                                }
                                return $carry;
                                });
                                @endphp
                                {{ Str::limit($first_message_content, 25) }}
                            </h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            Tokens: {{ $chatbox->total_tokens }}
                        </p>
                        <div class="flex space-x-2">
                            <a href="{{route('chatbox', $chatbox->id)}}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Continue Chat
                            </a>
                            {{-- Based on web.php delete for chatbox. create a form for this purpose --}}
                            <form action="{{route('chatbox.destroy', $chatbox->id)}}" method="POST"
                                onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="nline-flex items-center px-3 py-2 text-sm font-medium text-center text-white
                                    bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none
                                    focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    Delete
                                </button>
                            </form>
                        </div>


                    </div>
                    @empty
                    <p>No messages</p>
                    @endforelse
                </div>
                <div class=" p-4">
                    {{ $chatboxes->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        function confirmDelete() {
                                return confirm('Are you sure you want to delete this chatbox?');
                            }
    </script>
    @endpush
</x-app-layout>