<x-app-layout>
    <x-slot name="header">
        <title>Search for a Book</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
        <h1 class="text-3xl font-bold mb-6">Book Search</h1>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="p-4 bg-gray-200">
            <div class="flex items-center space-x-3">
                <form id="search-form" action="{{ route('books.index') }}" method="GET" class="flex-1 flex items-center relative">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            name="query" 
                            placeholder="Search for a book..." 
                            class="w-full px-12 py-3 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                            autocomplete="off"
                        />
                    </div>
                    <button
                        type="submit" 
                        class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300 flex items-center space-x-2"
                    >
                        <!-- Button Text -->
                        <span>Search</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5 text-white">
                            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <!-- Loading animation container -->
        <div id="loading-container" style="display: none;" class="flex justify-center items-center">
            <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
            <dotlottie-player 
                src="https://lottie.host/274dd891-82bf-4dd8-92f9-28b7e41cc729/nVgqtlIdxj.json"  
                background="transparent"  
                speed="1"  
                style="width: 300px; height: 300px;"  
                loop  
                autoplay>
            </dotlottie-player>
        </div>
        
        <!-- Search results container -->
        <div id="results-container" style="display: block;">
            @if(isset($searchResults) && count($searchResults) > 0)
                <!-- Display search results -->
                <h2 class="text-2xl font-bold mb-6">Search Results for "{{ request('query') }}"</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($searchResults as $book)
                        <div class="bg-white p-4 rounded-lg shadow-lg relative">
                            <img src="{{ $book['Image'] ?? 'default-image-url' }}" alt="{{ $book['title'] ?? 'No Title' }}" class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-lg font-bold">{{ $book['title'] ?? 'No Title' }}</h3>
                            <p class="text-gray-700">Author: {{ $book['authors'] ?? 'Unknown' }}</p>
                            <p class="text-gray-500">Publisher: {{ $book['publisher'] ?? 'Unknown' }}</p>
                            <p class="text-gray-500">Published: {{ $book['year'] ?? 'Unknown' }}</p>
                            <p class="text-gray-500">Language: {{ $book['language'] ?? 'Unknown' }}</p>
                            <p class="text-gray-500">File: {{ $book['file'] ?? 'Unknown' }}</p>
                            <div class="mt-4 flex items-center space-x-4">
                                <!-- Links for download and instant read -->
                                @if(!empty($book['actions_html']['Actual Download Link']))
                                    <a href="{{ $book['actions_html']['Actual Download Link'] }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-icon-blue hover:bg-icon-green text-white rounded-full transition-colors duration-300" title="Download Book">
                                        <!-- Download Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 text-blue-500 group-hover:opacity-100 opacity-60">
                                            <path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                        </svg>
                                        <div class="absolute left-1/2 transform -translate-x-1/2 top-full mt-2 bg-gray-700 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            Download Book
                                        </div>
                                    </a>
                                @endif
                                @if(!empty($book['actions_html']['download_link']))
                                    <a href="{{ $book['actions_html']['download_link'] }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-icon-green hover:bg-icon-blue text-white rounded-full transition-colors duration-300" title="Read Book Instantly">
                                        <!-- Read Instantly Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6 text-green-500 group-hover:opacity-100 opacity-60">
                                            <path d="M0 96C0 43 43 0 96 0L384 0l32 0c17.7 0 32 14.3 32 32l0 320c0 17.7-14.3 32-32 32l0 64c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0L96 512c-53 0-96-43-96-96L0 96zM64 416c0 17.7 14.3 32 32 32l256 0 0-64L96 384c-17.7 0-32 14.3-32 32zm90.4-234.4l-21.2-21.2c-3 10.1-5.1 20.6-5.1 31.6c0 .2 0 .5 .1 .8s.1 .5 .1 .8c0 23.4 12.8 43.7 32 54.7v16.5l160-160l-35.3-35.3L154.4 181.6zM320 236.8l-52.8 52.8l-30.8-30.8l31.2-31.2c5.1-5.1 13.4-5.1 18.4 0l31.2 31.2zM256 32L64 32c-35.3 0-64 28.7-64 64l0 112h64c17.7 0 32 14.3 32 32s-14.3 32-32 32H0l0 64l64 0c0-17.7 14.3-32 32-32s32-14.3 32-32s-14.3-32-32-32l-64 0l0-32l224 0 0-32H128c0-17.7-14.3-32-32-32L0 208l0-64l64 0L0 128l0 0l64 0l0-32L320 96c0-17.7 14.3-32 32-32L448 64c17.7 0 32 14.3 32 32l0 320c0 17.7-14.3 32-32 32L320 416l0-64l32 0c0-17.7-14.3-32-32-32l-32 0L320 272l0-32c0-17.7 14.3-32 32-32l0-32c0-17.7-14.3-32-32-32z"/>
                                        </svg>
                                        <div class="absolute left-1/2 transform -translate-x-1/2 top-full mt-2 bg-gray-700 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            Read Instantly
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- <p class="text-gray-600">No results found for "{{ request('query') }}"</p> -->
            @endif
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loadingContainer = document.getElementById('loading-container');
            var resultsContainer = document.getElementById('results-container');

            function showLoading() {
                loadingContainer.style.display = 'flex';
                resultsContainer.style.display = 'none';
            }

            function hideLoading() {
                loadingContainer.style.display = 'none';
                resultsContainer.style.display = 'block';
            }

            var searchForm = document.getElementById('search-form');
            searchForm.addEventListener('submit', function() {
                showLoading();
            });

            window.addEventListener('load', function() {
                hideLoading();
            });
        });
    </script>
</x-app-layout>
