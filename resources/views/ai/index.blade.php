<x-app-layout>
    <x-slot name="header">
        <title>ChatGPT @if(isset($type)) {{ $type }} @else Special Version @endif</title>
    </x-slot>
    <!-- Checkbox toggle slider with GPT-4 and Gemini options -->
    <br>
    <div class="container my-4 flex justify-center items-center">
        <span class="mr-3 text-gray-700">Use GPT-4</span>
        <label class="switch" for="toggle-gemini">
            <input type="checkbox" id="toggle-gemini" />
            <div class="slider round"></div>
        </label>
        <span class="ml-3 text-gray-700">Use Gemini</span>
    </div>

    <div class="container mx-auto py-8">
        <div class="chat-container flex flex-col h-[80vh] w-[90vw] max-w-6xl mx-auto bg-white text-gray-800 rounded-lg shadow-lg overflow-hidden">
        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-100">
            <!-- Chat messages will be dynamically inserted here -->
        </div>

            <!-- Input Area -->
            <div class="p-4 bg-gray-200">
                <div class="flex items-center space-x-3">
                    <input 
                        type="text" 
                        id="user-input" 
                        placeholder="What's on your mind?" 
                        class="flex-1 px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                        autocomplete="off"
                    />
                    <button 
                        id="send-btn" 
                        class="bg-gray-800 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-gray-900 transition-all duration-300 flex items-center space-x-2"
                    >
                        <!-- SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6">
                            <path d="M16.1 260.2c-22.6 12.9-20.5 47.3 3.6 57.3L160 376l0 103.3c0 18.1 14.6 32.7 32.7 32.7c9.7 0 18.9-4.3 25.1-11.8l62-74.3 123.9 51.6c18.9 7.9 40.8-4.5 43.9-24.7l64-416c1.9-12.1-3.4-24.3-13.5-31.2s-23.3-7.5-34-1.4l-448 256zm52.1 25.5L409.7 90.6 190.1 336l1.2 1L68.2 285.7zM403.3 425.4L236.7 355.9 450.8 116.6 403.3 425.4z"/>
                        </svg>
                        <!-- Button Text -->
                        <span>Send</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Predefined Queries with Emojis -->
        <div id="predefined-queries" class="mt-8 flex flex-wrap gap-4 justify-center">
            <div class="query-box bg-custom-blue-200 p-4 rounded-lg cursor-pointer hover:bg-custom-blue-300 transition-all duration-300" data-query="What is quantum computing?">
                💻 What is quantum computing?
            </div>
            <div class="query-box bg-custom-green-200 p-4 rounded-lg cursor-pointer hover:bg-custom-green-300 transition-all duration-300" data-query="What are the latest advancements in cancer treatment?">
                🧬 What are the latest advancements in cancer treatment?
            </div>
            <div class="query-box bg-custom-yellow-200 p-4 rounded-lg cursor-pointer hover:bg-custom-yellow-300 transition-all duration-300" data-query="What is the significance of the theory of relativity?">
                🌌 What is the significance of the theory of relativity?
            </div>
            <div class="query-box bg-custom-red-200 p-4 rounded-lg cursor-pointer hover:bg-custom-red-300 transition-all duration-300" data-query="Solve the triangle ABC where a = 5, b = 7, and ∠C = 60°">
                📐 Solve the triangle ABC where a = 5, b = 7, and ∠C = 60°
            </div>
            <div class="query-box bg-custom-purple-200 p-4 rounded-lg cursor-pointer hover:bg-custom-purple-300 transition-all duration-300" data-query="What is the impact of climate change on biodiversity?">
                🌿 What is the impact of climate change on biodiversity?
            </div>
            <div class="query-box bg-custom-pink-200 p-4 rounded-lg cursor-pointer hover:bg-custom-pink-300 transition-all duration-300" data-query="What are the principles of democratic governance?">
                🏛️ What are the principles of democratic governance?
            </div>
            <div class="query-box bg-custom-teal-200 p-4 rounded-lg cursor-pointer hover:bg-custom-teal-300 transition-all duration-300" data-query="How does the human brain process emotions?">
                🧠 How does the human brain process emotions?
            </div>
            <div class="query-box bg-custom-orange-200 p-4 rounded-lg cursor-pointer hover:bg-custom-orange-300 transition-all duration-300" data-query="What is the role of mitochondria in cells?">
                🔬 What is the role of mitochondria in cells?
            </div>
            <div class="query-box bg-custom-indigo-200 p-4 rounded-lg cursor-pointer hover:bg-custom-indigo-300 transition-all duration-300" data-query="What are the causes of World War I?">
                ⚔️ What are the causes of World War I?
            </div>
            <div class="query-box bg-custom-gray-200 p-4 rounded-lg cursor-pointer hover:bg-custom-gray-300 transition-all duration-300" data-query="How do black holes form?">
                🌌 How do black holes form?
            </div>
            <div class="query-box bg-custom-lime-200 p-4 rounded-lg cursor-pointer hover:bg-custom-lime-300 transition-all duration-300" data-query="What is the significance of the Fibonacci sequence?">
                🔢 What is the significance of the Fibonacci sequence?
            </div>
            <div class="query-box bg-custom-cyan-200 p-4 rounded-lg cursor-pointer hover:bg-custom-cyan-300 transition-all duration-300" data-query="How does genetic engineering work?">
                🧬 How does genetic engineering work?
            </div>
            <div class="query-box bg-custom-rose-200 p-4 rounded-lg cursor-pointer hover:bg-custom-rose-300 transition-all duration-300" data-query="What are the major events of the Renaissance?">
                🖼️ What are the major events of the Renaissance?
            </div>
            <div class="query-box bg-custom-amber-200 p-4 rounded-lg cursor-pointer hover:bg-custom-amber-300 transition-all duration-300" data-query="What is the theory of evolution?">
                🧑‍🔬 What is the theory of evolution?
            </div>
            <div class="query-box bg-custom-emerald-200 p-4 rounded-lg cursor-pointer hover:bg-custom-emerald-300 transition-all duration-300" data-query="What are the fundamental laws of thermodynamics?">
                🔥 What are the fundamental laws of thermodynamics?
            </div>
            <div class="query-box bg-custom-violet-200 p-4 rounded-lg cursor-pointer hover:bg-custom-violet-300 transition-all duration-300" data-query="What is the difference between classical and quantum physics?">
                ⚛️ What is the difference between classical and quantum physics?
            </div>
            <div class="query-box bg-custom-fuchsia-200 p-4 rounded-lg cursor-pointer hover:bg-custom-fuchsia-300 transition-all duration-300" data-query="How does the stock market work?">
                📈 How does the stock market work?
            </div>
            <div class="query-box bg-custom-sky-200 p-4 rounded-lg cursor-pointer hover:bg-custom-sky-300 transition-all duration-300" data-query="What are the key principles of Keynesian economics?">
                💰 What are the key principles of Keynesian economics?
            </div>
            <div class="query-box bg-custom-slate-200 p-4 rounded-lg cursor-pointer hover:bg-custom-slate-300 transition-all duration-300" data-query="What is the impact of social media on politics?">
                📱 What is the impact of social media on politics?
            </div>
            <div class="query-box bg-custom-teal-100 p-4 rounded-lg cursor-pointer hover:bg-custom-teal-200 transition-all duration-300" data-query="What is the purpose of the United Nations?">
                🌍 What is the purpose of the United Nations?
            </div>
            <div class="query-box bg-custom-yellow-100 p-4 rounded-lg cursor-pointer hover:bg-custom-yellow-200 transition-all duration-300" data-query="How do neurons communicate in the brain?">
                🧠 How do neurons communicate in the brain?
            </div>
            <div class="query-box bg-custom-blue-100 p-4 rounded-lg cursor-pointer hover:bg-custom-blue-200 transition-all duration-300" data-query="What are the effects of gravitational waves?">
                🌠 What are the effects of gravitational waves?
            </div>
            <div class="query-box bg-custom-green-100 p-4 rounded-lg cursor-pointer hover:bg-custom-green-200 transition-all duration-300" data-query="What are the different types of renewable energy?">
                ♻️ What are the different types of renewable energy?
            </div>
            <div class="query-box bg-custom-red-100 p-4 rounded-lg cursor-pointer hover:bg-custom-red-200 transition-all duration-300" data-query="What is the significance of the Big Bang theory?">
                💥 What is the significance of the Big Bang theory?
            </div>
            <div class="query-box bg-custom-purple-100 p-4 rounded-lg cursor-pointer hover:bg-custom-purple-200 transition-all duration-300" data-query="What are the main theories of personality psychology?">
                🧑‍🏫 What are the main theories of personality psychology?
            </div>
            <div class="query-box bg-custom-pink-100 p-4 rounded-lg cursor-pointer hover:bg-custom-pink-200 transition-all duration-300" data-query="How do economic sanctions affect international relations?">
                🌐 How do economic sanctions affect international relations?
            </div>
            <div class="query-box bg-custom-orange-100 p-4 rounded-lg cursor-pointer hover:bg-custom-orange-200 transition-all duration-300" data-query="What are the key factors in climate change?">
                🌡️ What are the key factors in climate change?
            </div>
            <div class="query-box bg-custom-teal-200 p-4 rounded-lg cursor-pointer hover:bg-custom-teal-300 transition-all duration-300" data-query="What are the major theories of ethics?">
                ⚖️ What are the major theories of ethics?
            </div>
            <div class="query-box bg-custom-cyan-200 p-4 rounded-lg cursor-pointer hover:bg-custom-cyan-300 transition-all duration-300" data-query="What is the role of enzymes in biochemistry?">
                🧪 What is the role of enzymes in biochemistry?
            </div>
            <div class="query-box bg-custom-lime-200 p-4 rounded-lg cursor-pointer hover:bg-custom-lime-300 transition-all duration-300" data-query="What is the significance of the Pythagorean theorem?">
                🧮 What is the significance of the Pythagorean theorem?
            </div>
        </div>

    </div>

    <!-- Loading Animation -->
    <div id="loading-container" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
        <dotlottie-player src="https://lottie.host/73ac19a7-dd6d-430c-877a-0e85248e789f/ZFVMtPEmfE.json" background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay></dotlottie-player>
    </div>

    <!-- Essential JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <script>
    $(document).ready(function() {
        let useGemini = false;

        $('#toggle-gemini').on('change', function() {
            useGemini = this.checked; 
        });

        function formatResponse(responseText) {
            let formattedResponse = responseText.replace(/(?:\r\n|\r|\n)/g, '<br>');
            formattedResponse = formattedResponse.replace(/###\s(.+)/g, '<strong>$1</strong>');
            formattedResponse = formattedResponse.replace(/\*\*(.+?)\*\*/g, '<em>$1</em>');
            return formattedResponse;
        }

        function sendMessage(message) {
            if (!message) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please enter a message.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $('#loading-container').removeClass('hidden');

            const routeUrl = useGemini ? "{{ route('ai.send-gemini') }}" : "{{ route('ai.send') }}";

            $.ajax({
                url: routeUrl,
                method: 'POST',
                data: { message: message },
                success: function(response) {
                    $('#loading-container').addClass('hidden');
                    
                    // Check both response.status and response.result
                    if (response.status || response.result) {
                        let chatMessage = `
                            <div class="flex items-start">
                                <div class="bg-white p-4 rounded-lg shadow-md w-full relative">
                                    <p>${formatResponse(response.result || response.status)}</p>
                                    <div class="absolute top-2 right-2 flex space-x-2">
                                        <button class="copy-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6">
                                                <path d="M208 0L332.1 0c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9L448 336c0 26.5-21.5 48-48 48l-192 0c-26.5 0-48-21.5-48-48l0-288c0-26.5 21.5-48 48-48zM48 128l80 0 0 64-64 0 0 256 192 0 0-32 64 0 0 48c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 176c0-26.5 21.5-48 48-48z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#chat-messages').append(chatMessage);
                        $('#user-input').val('');
                        $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); 
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to get a response from the AI.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    $('#loading-container').addClass('hidden');
                    
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while sending your request.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        $('#send-btn').on('click', function(event) {
            event.preventDefault();
            const message = $('#user-input').val().trim();
            sendMessage(message);
        });

        $('#user-input').on('keypress', function(event) {
            if (event.which == 13) {
                event.preventDefault();
                const message = $('#user-input').val().trim();
                sendMessage(message);
            }
        });

        $('#chat-messages').on('click', '.copy-btn', function() {
            let message = $(this).closest('.relative').find('p').text();
            navigator.clipboard.writeText(message).then(() => {
                Swal.fire({
                    title: 'Copied!',
                    text: 'Message copied to clipboard.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        });

        $('#predefined-queries').on('click', '.query-box', function() {
            const query = $(this).data('query');
            $('#user-input').val(query);
            sendMessage(query);
            $('#predefined-queries').hide(); 
        });

        $('#user-input').on('focus', function() {
            $('#predefined-queries').hide();
        });

        $('#chat-messages').on('click', function() {
            $('#predefined-queries').hide();
        });
    });
    </script>

    <style>
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    .switch input {
    display: none;
    }

    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    }

    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    }

    input:checked + .slider {
    background-color: #66bb6a;
    }

    input:checked + .slider:before {
    transform: translateX(26px);
    }

    .slider.round {
    border-radius: 34px;
    }

    .slider.round:before {
    border-radius: 50%;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('predefined-queries');
        const items = Array.from(container.querySelectorAll('.query-box'));

        function shuffle(array) {
            let currentIndex = array.length, randomIndex;
            while (currentIndex !== 0) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;
                [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
            }
            return array;
        }

        const shuffledItems = shuffle(items);

        shuffledItems.forEach(item => container.appendChild(item));
    });
    </script>
</x-app-layout>
