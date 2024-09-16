<x-app-layout>
    <x-slot name="header">
        <title>Search Results</title>
        <h1 class="text-3xl font-bold mb-6">Search Results for "{{ request()->input('query') }}"</h1>
    </x-slot>

    <div class="container mx-auto py-8">
        @if(isset($books) && count($books) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                    <div class="bg-white p-4 rounded-lg shadow-lg relative">
                        <!-- Book Image -->
                        <img src="{{ $book['Image'] ?? 'default-image-url' }}" alt="{{ $book['title'] ?? 'No Title' }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        <!-- Book Title -->
                        <h3 class="text-lg font-bold">{{ $book['title'] ?? 'No Title' }}</h3>
                        <!-- Authors -->
                        <p class="text-gray-700">Author: {{ $book['authors'] ?? 'Unknown' }}</p>
                        <!-- Publisher -->
                        <p class="text-gray-500">Publisher: {{ $book['publisher'] ?? 'Unknown' }}</p>
                            <!-- Published Year -->
                        <p class="text-gray-500">Published: {{ $book['year'] ?? 'Unknown' }}</p>
                            <!-- Language -->
                        <p class="text-gray-500">Language: {{ $book['language'] ?? 'Unknown' }}</p>
                            <!-- File Size -->
                        <p class="text-gray-500">File: {{ $book['file'] ?? 'Unknown' }}</p>
                        <div class="mt-4 flex items-center space-x-8">
                            @if(!empty($book['actions_html']['Actual Download Link']))
                                <a href="{{ $book['actions_html']['Actual Download Link'] }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-icon-blue hover:bg-icon-green text-white rounded-full transition-colors duration-300" title="Download Book">
                                    <!-- Download Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                                    <span class="sr-only">Download Book</span>
                                </a>
                            @endif
                            @if(!empty($book['actions_html']['download_link']))
                                <a href="{{ $book['actions_html']['download_link'] }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-icon-green hover:bg-icon-blue text-white rounded-full transition-colors duration-300" title="Read Book Instantly">
                                    <!-- Read Instantly Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 43 43 0 96 0L384 0l32 0c17.7 0 32 14.3 32 32l0 320c0 17.7-14.3 32-32 32l0 64c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0L96 512c-53 0-96-43-96-96L0 96zM64 416c0 17.7 14.3 32 32 32l256 0 0-64L96 384c-17.7 0-32 14.3-32 32zm90.4-234.4l-21.2-21.2c-3 10.1-5.1 20.6-5.1 31.6c0 .2 0 .5 .1 .8s.1 .5 .1 .8L165.2 226c2.5 2.1 3.4 5.8 2.3 8.9c-1.3 3-4.1 5.1-7.5 5.1c-1.9-.1-3.8-.8-5.2-2l-23.6-20.6C142.8 267 186.9 304 240 304s97.3-37 108.9-86.6L325.3 238c-1.4 1.2-3.3 2-5.3 2c-2.2-.1-4.4-1.1-6-2.8c-1.2-1.5-1.9-3.4-2-5.2c.1-2.2 1.1-4.4 2.8-6l37.1-32.5c0-.3 0-.5 .1-.8s.1-.5 .1-.8c0-11-2.1-21.5-5.1-31.6l-21.2 21.2c-3.1 3.1-8.1 3.1-11.3 0s-3.1-8.1 0-11.2l26.4-26.5c-8.2-17-20.5-31.7-35.9-42.6c-2.7-1.9-6.2 1.4-5 4.5c8.5 22.4 3.6 48-13 65.6c-3.2 3.4-3.6 8.9-.9 12.7c9.8 14 12.7 31.9 7.5 48.5c-5.9 19.4-22 34.1-41.9 38.3l-1.4-34.3 12.6 8.6c.6 .4 1.5 .6 2.3 .6c1.5 0 2.7-.8 3.5-2s.6-2.8-.1-4L260 225.4l18-3.6c1.8-.4 3.1-2.1 3.1-4s-1.4-3.5-3.1-3.9l-18-3.7 8.5-14.3c.8-1.2 .9-2.9 .1-4.1s-2-2-3.5-2l-.1 0c-.7 .1-1.5 .3-2.1 .7l-14.1 9.6L244 87.9c-.1-2.2-1.9-3.9-4-3.9s-3.9 1.6-4 3.9l-4.6 110.8-12-8.1c-1.5-1.1-3.6-.9-5 .4s-1.6 3.4-.8 5l8.6 14.3-18 3.7c-1.8 .4-3.1 2-3.1 3.9s1.4 3.6 3.1 4l18 3.8-8.6 14.2c-.2 .6-.5 1.4-.5 2c0 1.1 .5 2.1 1.2 3c.8 .6 1.8 1 2.8 1c.7 0 1.6-.2 2.2-.6l10.4-7.1-1.4 32.8c-19.9-4.1-36-18.9-41.9-38.3c-5.1-16.6-2.2-34.4 7.6-48.5c2.7-3.9 2.3-9.3-.9-12.7c-16.6-17.5-21.6-43.1-13.1-65.5c1.2-3.1-2.3-6.4-5-4.5c-15.3 10.9-27.6 25.6-35.8 42.6l26.4 26.5c3.1 3.1 3.1 8.1 0 11.2s-8.1 3.1-11.2 0z"/></svg>
                                    <span class="sr-only">Read Book Instantly</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-8 text-gray-600">No results found. Please try again later.</p>
        @endif
    </div>

</x-app-layout>
@else
            <!-- Default books if no search results -->
            @foreach($books as $keyword => $bookList)
                @if(count($bookList) > 0)
                    <h2 class="text-2xl font-bold mb-6">{{ $keyword }} Books</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($bookList as $book)
                            <div class="bg-white p-4 rounded-lg shadow-lg relative">
                                <img src="{{ $book['Image'] ?? 'default-image-url' }}" alt="{{ $book['title'] ?? 'No Title' }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                <h3 class="text-lg font-bold">{{ $book['title'] ?? 'No Title' }}</h3>
                                <p class="text-gray-700">Author: {{ $book['authors'] ?? 'Unknown' }}</p>
                                <p class="text-gray-500">Publisher: {{ $book['publisher'] ?? 'Unknown' }}</p>
                                <p class="text-gray-500">Published: {{ $book['year'] ?? 'Unknown' }}</p>
                                <p class="text-gray-500">Language: {{ $book['language'] ?? 'Unknown' }}</p>
                                <p class="text-gray-500">File: {{ $book['file'] ?? 'Unknown' }}</p>
                                <div class="mt-4 flex items-center space-x-4">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6 text-green-500 group-hover:opacity-100 opacity-60">
                                                <path d="M0 96C0 43 43 0 96 0L384 0l32 0c17.7 0 32 14.3 32 32l0 320c0 17.7-14.3 32-32 32l0 64c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32 0L96 512c-53 0-96-43-96-96L0 96zM64 416c0 17.7 14.3 32 32 32l256 0 0-64L96 384c-17.7 0-32 14.3-32 32zm90.4-234.4l-21.2-21.2c-3 10.1-5.1 20.6-5.1 31.6c0 .2 0 .5 .1 .8s.1 .5 .1 .8L165.2 226c2.5 2.1 3.4 5.8 2.3 8.9c-1.3 3-4.1 5.1-7.5 5.1c-1.9-.1-3.8-.8-5.2-2l-23.6-20.6C142.8 267 186.9 304 240 304s97.3-37 108.9-86.6L325.3 238c-1.4 1.2-3.3 2-5.3 2c-2.2-.1-4.4-1.1-6-2.8c-1.2-1.5-1.9-3.4-2-5.2c.1-2.2 1.1-4.4 2.8-6l37.1-32.5c0-.3 0-.5 .1-.8s.1-.5 .1-.8c0-11-2.1-21.5-5.1-31.6l-21.2 21.2c-3.1 3.1-8.1 3.1-11.3 0s-3.1-8.1 0-11.2l26.4-26.5c-8.2-17-20.5-31.7-35.9-42.6c-2.7-1.9-6.2 1.4-5 4.5c8.5 22.4 3.6 48-13 65.6c-3.2 3.4-3.6 8.9-.9 12.7c9.8 14 12.7 31.9 7.5 48.5c-5.9 19.4-22 34.1-41.9 38.3l-1.4-34.3 12.6 8.6c.6 .4 1.5 .6 2.3 .6c1.5 0 2.7-.8 3.5-2s.6-2.8-.1-4L260 225.4l18-3.6c1.8-.4 3.1-2.1 3.1-4s-1.4-3.5-3.1-3.9l-18-3.7 8.5-14.3c.8-1.2 .9-2.9 .1-4.1s-2-2-3.5-2l-.1 0c-.7 .1-1.5 .3-2.1 .7l-14.1 9.6L244 87.9c-.1-2.2-1.9-3.9-4-3.9s-3.9 1.6-4 3.9l-4.6 110.8-12-8.1c-1.5-1.1-3.6-.9-5 .4s-1.6 3.4-.8 5l8.6 14.3-18 3.7c-1.8 .4-3.1 2-3.1 3.9s1.4 3.6 3.1 4l18 3.8-8.6 14.2c-.2 .6-.5 1.4-.5 2c0 1.1 .5 2.1 1.2 3c.8 .6 1.8 1 2.8 1c.7 0 1.6-.2 2.2-.6l10.4-7.1-1.4 32.8c-19.9-4.1-36-18.9-41.9-38.3c-5.1-16.6-2.2-34.4 7.6-48.5c2.7-3.9 2.3-9.3-.9-12.7c-16.6-17.5-21.6-43.1-13.1-65.5c1.2-3.1-2.3-6.4-5-4.5c-15.3 10.9-27.6 25.6-35.8 42.6l26.4 26.5c3.1 3.1 3.1 8.1 0 11.2s-8.1 3.1-11.2 0z"/>
                                            </svg>
                                            <div class="absolute left-1/2 transform -translate-x-1/2 top-full mt-2 bg-gray-700 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                Read Book Instantly
                                            </div>                                        
                                        </a>
                                    @endif
                                </div>
                                <a href="{{ $book['url'] }}" target="_blank" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded">View on zLibrary</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        @endif