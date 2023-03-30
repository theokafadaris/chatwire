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

                        <a href="{{route('chatbox', $chatbox->id)}}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Go to ChatBox
                            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
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
</x-app-layout>