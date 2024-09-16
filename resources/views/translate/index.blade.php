<x-app-layout>
    <x-slot name="header">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
        <h1 class="text-3xl font-bold mb-6">Translation Service</h1>
    </x-slot>

    <div class="container mx-auto py-8">
        <!-- Input Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form id="translate-form" method="POST" action="{{ route('translate.detect') }}">
            <div class="mb-4">
                <label for="user-input" class="block text-gray-700 font-bold mb-2">Enter text to detect language:</label>
                <input 
                    type="text" 
                    id="user-input" 
                    name="text" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                    placeholder="Type something here..." 
                    autocomplete="off"
                    required
                >
            </div>
                <div>
                <button 
                    type="submit" 
                    class="bg-gray-600 text-gray font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-gray-700 transition-all duration-300 flex items-center gap-2"
                >
                    <!-- Button Text -->
                    Detect Language
                    <!-- SVG Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5">
                        <path d="M177.8 63.2l10 17.4c2.8 4.8 4.2 10.3 4.2 15.9l0 41.4c0 3.9 1.6 7.7 4.3 10.4c6.2 6.2 16.5 5.7 22-1.2l13.6-17c4.7-5.9 12.9-7.7 19.6-4.3l15.2 7.6c3.4 1.7 7.2 2.6 11 2.6c6.5 0 12.8-2.6 17.4-7.2l3.9-3.9c2.9-2.9 7.3-3.6 11-1.8l29.2 14.6c7.8 3.9 12.6 11.8 12.6 20.5c0 10.5-7.1 19.6-17.3 22.2l-35.4 8.8c-7.4 1.8-15.1 1.5-22.4-.9l-32-10.7c-3.3-1.1-6.7-1.7-10.2-1.7c-7 0-13.8 2.3-19.4 6.5L176 212c-10.1 7.6-16 19.4-16 32l0 28c0 26.5 21.5 48 48 48l32 0c8.8 0 16 7.2 16 16l0 48c0 17.7 14.3 32 32 32c10.1 0 19.6-4.7 25.6-12.8l25.6-34.1c8.3-11.1 12.8-24.6 12.8-38.4l0-12.1c0-3.9 2.6-7.3 6.4-8.2l5.3-1.3c11.9-3 20.3-13.7 20.3-26c0-7.1-2.8-13.9-7.8-18.9l-33.5-33.5c-3.7-3.7-3.7-9.7 0-13.4c5.7-5.7 14.1-7.7 21.8-5.1l14.1 4.7c12.3 4.1 25.7-1.5 31.5-13c3.5-7 11.2-10.8 18.9-9.2l27.4 5.5C432 112.4 351.5 48 256 48c-27.7 0-54 5.4-78.2 15.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"/>
                    </svg>
                </button>
                </div>
            </form>
        </div>

        <!-- Results Area -->
        @if(session('detectedLanguage'))
        <div class="bg-gray-100 shadow-md rounded-lg p-6 mt-6">
            <p class="mb-4 text-gray-800">The language detected is: <strong>{{ session('detectedLanguage') }}</strong></p>
            <form id="translate-action-form" method="POST" action="{{ route('translate.translate') }}">
                <p>Do you want to translate this text?</p>
                <div class="flex items-center mb-4 space-x-6">
                    <div class="flex items-center">
                        <input type="radio" id="translate-yes" name="translate" value="yes" class="mr-2">
                        <label for="translate-yes" class="font-bold">Yes</label>
                    </div>

                    <div class="flex items-center">
                        <input type="radio" id="translate-no" name="translate" value="no" class="mr-2">
                        <label for="translate-no" class="font-bold">No</label>
                    </div>
                </div>

                <div id="language-selection" class="hidden">
                    <p>Select the language to translate to:</p>
                    <select name="target-language" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="en">English</option>
                    <option value="fr">French</option>
                    <option value="es">Spanish</option>
                    <option value="sw">Swahili</option>
                    <option value="de">German</option>
                    <option value="it">Italian</option>
                    <option value="pt">Portuguese</option>
                    <option value="ru">Russian</option>
                    <option value="zh">Chinese</option>
                    <option value="ja">Japanese</option>
                    <option value="ko">Korean</option>
                    <option value="ar">Arabic</option>
                    <option value="hi">Hindi</option>
                    <option value="bn">Bengali</option>
                    <option value="nl">Dutch</option>
                    <option value="tr">Turkish</option>
                    <option value="vi">Vietnamese</option>
                    <option value="ms">Malay</option>
                    <option value="id">Indonesian</option>
                    <option value="pl">Polish</option>
                    <option value="th">Thai</option>
                    <option value="ro">Romanian</option>
                    <option value="el">Greek</option>
                    <option value="he">Hebrew</option>
                    <option value="sv">Swedish</option>
                    <option value="no">Norwegian</option>
                    <option value="da">Danish</option>
                    <option value="fi">Finnish</option>
                    <option value="cs">Czech</option>
                    <option value="hu">Hungarian</option>
                    <option value="uk">Ukrainian</option>
                    <option value="fa">Persian</option>
                    <option value="ur">Urdu</option>
                    <option value="ta">Tamil</option>
                    <option value="te">Telugu</option>
                    <option value="ml">Malayalam</option>
                    <option value="kn">Kannada</option>
                    <option value="mr">Marathi</option>
                    <option value="pa">Punjabi</option>
                    <option value="bg">Bulgarian</option>
                    <option value="sr">Serbian</option>
                    <option value="sk">Slovak</option>
                    <option value="sl">Slovenian</option>
                    <option value="lt">Lithuanian</option>
                    <option value="lv">Latvian</option>
                    <option value="et">Estonian</option>
                    <option value="hr">Croatian</option>
                    <option value="is">Icelandic</option>
                    <option value="ga">Irish</option>
                    <option value="ca">Catalan</option>
                    <option value="eu">Basque</option>
                    <option value="gl">Galician</option>
                    <option value="fil">Filipino</option>
                    <option value="kk">Kazakh</option>
                    <option value="mn">Mongolian</option>
                    <option value="ne">Nepali</option>
                    <option value="si">Sinhala</option>
                    <option value="hy">Armenian</option>
                    <option value="az">Azerbaijani</option>
                    </select>
                </div>

                <input type="hidden" name="detected-language" value="{{ session('detectedLanguageCode') }}">
                <input type="hidden" name="original-text" value="{{ session('originalText') }}">

                <div class="mt-4">
                    <button 
                        type="submit" 
                        class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300 flex items-center gap-2"
                    >
                        <!-- Button Text -->
                        Translate Text
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 224c0 17.7 14.3 32 32 32s32-14.3 32-32c0-53 43-96 96-96l160 0 0 32c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l64-64c12.5-12.5 12.5-32.8 0-45.3l-64-64c-9.2-9.2-22.9-11.9-34.9-6.9S320 19.1 320 32l0 32L160 64C71.6 64 0 135.6 0 224zm512 64c0-17.7-14.3-32-32-32s-32 14.3-32 32c0 53-43 96-96 96l-160 0 0-32c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9l-64 64c-12.5 12.5-12.5 32.8 0 45.3l64 64c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6l0-32 160 0c88.4 0 160-71.6 160-160z"/></svg>
                    </button>
                </div>
            </form>
        </div>
        @endif

        @if(session('translatedText'))
            <div class="bg-green-100 shadow-md rounded-lg p-6 mt-6 flex items-center justify-between">
                <p class="text-gray-800">
                    Translated Text: <strong id="translatedText">{{ session('translatedText') }}</strong>
                </p>
                <!-- Copy Icon -->
                <button onclick="copyToClipboard()" class="text-gray-600 hover:text-gray-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5">
                        <path d="M208 0L332.1 0c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9L448 336c0 26.5-21.5 48-48 48l-192 0c-26.5 0-48-21.5-48-48l0-288c0-26.5 21.5-48 48-48zM48 128l80 0 0 64-64 0 0 256 192 0 0-32 64 0 0 48c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 176c0-26.5 21.5-48 48-48z"/>
                    </svg>
                </button>
            </div>
        @endif

    </div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function copyToClipboard() {
        // Get the translated text
        const text = document.getElementById('translatedText').textContent;
        
        // Copy the text to the clipboard
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                title: 'Text Copied!',
                text: 'The translated text has been successfully copied to your clipboard.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }).catch(err => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to copy the translated text. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            console.error('Failed to copy text: ', err);
        });
    }
</script>

    <script>
        // Toggle language selection if the user chooses to translate
        document.getElementById('translate-yes').addEventListener('click', function() {
            document.getElementById('language-selection').classList.remove('hidden');
        });

        document.getElementById('translate-no').addEventListener('click', function() {
            document.getElementById('language-selection').classList.add('hidden');
        });
    </script>
</x-app-layout>
