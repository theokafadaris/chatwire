<x-app-layout>
    <x-slot name="header">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
        <h1 class="text-3xl font-bold mb-6">Spotify Search</h1>
    </x-slot>

    <div class="container mx-auto py-8">
        <!-- Search Bar -->
        <div class="input-group custom-input-group">
            <form action="{{ route('spotify.search') }}" method="POST" class="flex items-center w-full">
                @csrf
                <input 
                    type="search" 
                    name="query" 
                    class="w-full max-w-[500px] px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-300"  
                    placeholder="Search for a track..." 
                    value="{{ old('query', $query ?? '') }}" 
                    aria-label="Search" 
                    aria-describedby="search-addon"
                />
                <button 
                    type="submit" 
                    class="bg-green-500 text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition-all duration-300 flex items-center space-x-2"
                    data-mdb-ripple-init
                >
                    <!-- SVG Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460 512" class="w-6 h-6 text-white">
                        <path d="M220.6 130.3l-67.2 28.2V43.2L98.7 233.5l54.7-24.2v130.3l67.2-209.3zm-83.2-96.7l-1.3 4.7-15.2 52.9C80.6 106.7 52 145.8 52 191.5c0 52.3 34.3 95.9 83.4 105.5v53.6C57.5 340.1 0 272.4 0 191.6c0-80.5 59.8-147.2 137.4-158zm311.4 447.2c-11.2 11.2-23.1 12.3-28.6 10.5-5.4-1.8-27.1-19.9-60.4-44.4-33.3-24.6-33.6-35.7-43-56.7-9.4-20.9-30.4-42.6-57.5-52.4l-9.7-14.7c-24.7 16.9-53 26.9-81.3 28.7l2.1-6.6 15.9-49.5c46.5-11.9 80.9-54 80.9-104.2 0-54.5-38.4-102.1-96-107.1V32.3C254.4 37.4 320 106.8 320 191.6c0 33.6-11.2 64.7-29 90.4l14.6 9.6c9.8 27.1 31.5 48 52.4 57.4s32.2 9.7 56.8 43c24.6 33.2 42.7 54.9 44.5 60.3s.7 17.3-10.5 28.5zm-9.9-17.9c0-4.4-3.6-8-8-8s-8 3.6-8 8 3.6 8 8 8 8-3.6 8-8z"/>
                    </svg>
                    <!-- Button Text -->
                    <span>Search</span>
                </button>
            </form>
        </div>

        <!-- Trending Albums -->
        @if(isset($albums) && count($albums) > 0)
            <h2 class="text-2xl font-bold mb-4 mt-8">Trending Albums</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($albums as $album)
                <div 
                    class="bg-white p-4 rounded-lg shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                    onclick="window.location.href='{{ route('spotify.album', ['id' => $album['id']]) }}'"
                >
                    <img src="{{ $album['thumbnail'] }}" alt="{{ $album['name'] }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-lg font-bold">{{ $album['name'] }}</h3>
                    <p class="text-gray-700">Artist: {{ $album['artist'] }}</p>
                    <p class="text-gray-500">Released: {{ $album['release_date'] }}</p>
                    <a href="{{ $album['url'] }}" target="_blank" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded">
                        Check on Spotify
                    </a>
                </div>
                @endforeach
            </div>
        @endif

        <!-- Search Results -->
        @if(isset($tracks) && count($tracks) > 0)
            <h2 class="text-2xl font-bold mb-4 mt-8">Search Results</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($tracks as $track)
                <div 
                    class="bg-white p-4 rounded-lg shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                    @if(isset($track['album_id']))
                        onclick="window.location.href='{{ route('spotify.album', ['id' => $track['album_id']]) }}'"
                    @endif
                >
                    <img src="{{ $track['thumbnail'] }}" alt="{{ $track['album'] }}" class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-lg font-bold">{{ $track['name'] }}</h3>
                    <p class="text-gray-700">Artist: {{ $track['artist'] }}</p>
                    <p class="text-gray-500">Album: {{ $track['album'] }}</p>
                    <p class="text-gray-500">Released: {{ $track['release_date'] }}</p>
                    @if($track['explicit'] === 'Explicit')
                        <span class="text-red-500 font-bold">Explicit</span>
                    @endif
                    <a href="{{ $track['url'] }}" target="_blank" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded">
                        Play on Spotify
                    </a>
                </div>
                @endforeach
            </div>
        @endif

        <!-- No Results -->
        @if(empty($albums) && empty($tracks))
            <p class="mt-8 text-gray-600">No results found. Please try again.</p>
        @endif
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"></script>
<script>
    import { Ripple, initMDB } from 'mdb-ui-kit';
    initMDB({ Ripple });
</script>

</x-app-layout>
