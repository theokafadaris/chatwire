<div>
    @if ($message)
        <div class="mb-6">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                transcription</label>
            <textarea wire:model.live="message.text" id="message" rows="4" disabled
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
        </div>
    @endif
    <div class="mb-6">
        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
            language</label>
        <select id="countries" wire:model.live="language"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected>Choose a Language</option>
            @foreach ($availableLanguages as $key => $value)
                <option>{{ $key }}</option>
            @endforeach
        </select>
        <div class="mt-2" wire:loading.remove wire:target="language">
            @error('language')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <input wire:model.live="file"
        class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        id="large_size" type="file">
    <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Please select an audio file
        (MP3, MP4, WAV, MPEG, MPGA, M4A, WEBM) with a maximum size of 25 MB. </p>
    <div class="mt-2" wire:loading.remove wire:target="file">
        @error('file')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div class="mt-6">
        <button wire:click="transcribe"
            class="focus:outline-none text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">
            Transcribe
        </button>
    </div>
</div>
