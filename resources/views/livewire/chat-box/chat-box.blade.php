<div>
    <button wire:click="$toggle('showSystemInstruction')"
        class="focus:outline-none text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-900">
        Initial System Instruction
    </button>

    @if ($showSystemInstruction)
        <div class="mt-4">
            <textarea wire:model.blur="chatBoxSystemInstruction" rows="2"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Enter Initial System Instruction"></textarea>
        </div>
    @endif
    <div class="flex flex-col space-y-4 p-4">
        @foreach ($messages as $message)
            <div
                class="flex rounded-lg p-4 @if ($message['role'] === 'assistant') bg-green-200 flex-reverse @else bg-blue-200 @endif ">
                <div class="ml-4">
                    <div class="text-lg">
                        @if ($message['role'] === 'assistant')
                            <a href="#" class="font-medium text-gray-900">Your Assistant</a>
                        @else
                            <a href="#" class="font-medium text-gray-900">You</a>
                        @endif
                    </div>
                    <div class="mt-1 ">
                        <p class="text-gray-600">
                            {!! \Illuminate\Mail\Markdown::parse($message['content']) !!}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        <form wire:submit="ask">
            <label for="chat" class="sr-only">Your message</label>
            <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                <textarea wire:model="message" wire:keydown.enter="ask" wire:loading.attr="disabled" id="chat"
                    rows="6"
                    class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Ask your assistant"></textarea>

                <button type="submit"
                    class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600"
                    wire:loading.remove>
                    <svg aria-hidden="true" class="w-6 h-6 rotate-90" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                        </path>
                    </svg>
                    <span class="sr-only">Send message</span>
                </button>

                <div role="status" wire:loading wire:target="ask">
                    <svg aria-hidden="true"
                        class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>

            </div>
        </form>
    </div>
    <div class="flex mt-2 space-x-4">
        <div>
            <label for="chatBoxModel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Model</label>
            <select wire:model="chatBoxModel"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option>Choose an OpenAI Model</option>
                @foreach ($availableGPTModels as $chatBoxModelKey => $chatBoxModelValue)
                    <option {{ $chatBoxModelKey == $chatBoxModel ? 'selected' : '' }} value="{{ $chatBoxModelKey }}">
                        {{ $chatBoxModelValue }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="promptList" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prompt
                List</label>
            <select data-popover-target="popover-default" wire:model.live="chatBoxRole"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value=''>Choose a Prompt</option>
                @foreach ($availableGPTRoles as $availableRoleKey => $availableRoleValue)
                    <option value="{{ $availableRoleValue }}">
                        Act as {{ $availableRoleKey }}</option>
                @endforeach
            </select>
            <div data-popover id="popover-default" role="tooltip"
                class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">

                <div class="px-3 py-2">
                    <p>Using prompt from https://github.com/f/awesome-chatgpt-prompts</p>
                </div>
                <div data-popper-arrow></div>
            </div>


        </div>
        <div>
            <label for="chatBoxTemperature"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Temperature</label>
            <input wire:model.live="chatBoxTemperature" type="number" step="0.1" min="0" max="1"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.0 - 1.0">
        </div>
        <div>
            <label for="chatBoxMaxTokens"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MaxTokens</label>
            <input wire:model.live="chatBoxMaxTokens" type="number" step="100" min="0" max="4096"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="1 - 4096">
        </div>
    </div>
    <div class="flex mt-6">
        {{-- Add a save button --}}
        <button wire:click="saveChat"
            class="focus:outline-none text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">
            Save Conversation
        </button>
        {{-- Add a send to email button --}}
        <button wire:click="sendChatToEmail"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
            Send Conversation to Email
        </button>
        {{-- Add a reset button --}}
        <button wire:click="resetChatBox"
            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Reset
            Discussion
        </button>
    </div>
</div>
