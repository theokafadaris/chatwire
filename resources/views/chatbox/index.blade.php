<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat Box') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                        data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="chat-tab"
                                data-tabs-target="#chat" type="button" role="tab" aria-controls="chat"
                                aria-selected="false">Chat</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="transcribe-tab" data-tabs-target="#transcribe" type="button" role="tab"
                                aria-controls="transcribe" aria-selected="false">Transcribe</button>
                        </li>
                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="hidden p-4 rounded-lg  dark:bg-gray-800" id="chat" role="tabpanel"
                        aria-labelledby="chat-tab">
                        <livewire:chat-box :chatbox="$chatbox" />
                    </div>
                    <div class="hidden p-4 rounded-lg dark:bg-gray-800" id="transcribe" role="tabpanel"
                        aria-labelledby="transcribe-tab">
                        <livewire:transcribe-box />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
