<x-app-layout>
    <x-slot name="header">
    <link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/8.16.1/video.min.js"></script>
        <link rel="preload" href="{{ $album['images'][0]['url'] }}" as="image">
        <h1 class="text-3xl font-bold mb-6">{{ $album['name'] }}</h1>
    </x-slot>

    <div class="container mx-auto py-8">
        <!-- Album Details -->
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            <div class="lg:w-1/3">
                <!-- Resize the album image -->
                <img src="{{ $album['images'][0]['url'] }}" alt="{{ $album['name'] }}" class="rounded-lg shadow-lg w-48 h-48 object-cover" loading="lazy" width="192" height="192">
            </div>
            <div class="lg:w-2/3 mt-6 lg:mt-0">
                <h2 class="text-2xl font-bold">{{ $album['name'] }}</h2>
                <p class="text-gray-600">Released: {{ $album['release_date'] }}</p>
                <a href="{{ $album['uri'] }}" target="_blank" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded">
                    Check Album on Spotify
                </a>
               <!-- Download Album Link -->
                <a 
                    id="downloadAlbumBtn"
                    href="{{ route('spotify.download.album', ['albumId' => explode(':', $album['uri'])[2]]) }}" 
                    class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors"
                >
                    Download Album
                </a>
            
                <!-- Additional Details -->
                <div class="mt-6">
                    <h3 class="text-xl font-bold mb-2">Artists</h3>
                    <div class="flex flex-wrap space-x-4">
                        @foreach($artists as $artist)
                            <div class="flex flex-col items-center">
                                <img src="{{ $artistImages[$artist['id']] ?? '' }}" alt="{{ $artist['name'] }}" class="rounded-full w-16 h-16 object-cover shadow-md">
                                <p class="mt-4 text-center text-sm">{{ $artist['name'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-bold mb-2">Genres</h3>
                    <div class="flex flex-wrap space-x-2">
                        @foreach($album['genres'] as $genre)
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full">{{ $genre }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-bold mb-2">Label</h3>
                    <p class="text-gray-600">{{ $album['label'] }}</p>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-bold mb-2">Popularity</h3>
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 {{ $i <= ceil($album['popularity'] / 20) ? 'text-yellow-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.951a1 1 0 00.95.69h4.186c.969 0 1.371 1.24.588 1.81l-3.39 2.478a1 1 0 00-.364 1.118l1.287 3.95c.3.922-.755 1.688-1.539 1.118l-3.392-2.478a1 1 0 00-1.176 0l-3.39 2.478c-.784.57-1.84-.196-1.539-1.118l1.286-3.951a1 1 0 00-.364-1.118L2.5 9.378c-.784-.57-.381-1.81.588-1.81h4.186a1 1 0 00.95-.69l1.287-3.951z" />
                            </svg>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Video Player Section -->
        <div class="mt-6">
        <h3 class="text-xl font-bold mb-2">Play Video</h3>
        <div id="video-player-container" class="video-container">
            <img id="video-thumbnail" src="" alt="Video Thumbnail" class="video-thumbnail" style="cursor: pointer;">
            <video id="video-player" controls class="video-player" style="display: none;">
                <source id="video-source" src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        </div>
        
        <!-- Tracks Table -->
        <div class="mt-8">
            <h3 class="text-2xl font-bold mb-4">Tracks</h3>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Track Number</th>
                        <th class="px-4 py-2">Track Name</th>
                        <th class="px-4 py-2">Artist</th>
                        <th class="px-4 py-2">Preview</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($album['tracks']['items'] as $track)
                        <tr>
                            <td class="border px-4 py-2">{{ $track['track_number'] }}</td>
                            <td class="border px-4 py-2">{{ $track['name'] }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    @foreach($track['artists'] as $trackArtist)
                                        @if(isset($artistImages[$trackArtist['id']]))
                                            <img src="{{ $artistImages[$trackArtist['id']] }}" alt="{{ $trackArtist['name'] }}" class="w-6 h-6 rounded-full object-cover">
                                        @else
                                            <span class="text-gray-500">{{ $trackArtist['name'] }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="border px-4 py-2">
                                @if($track['preview_url'])
                                    <audio controls class="w-full">
                                        <source src="{{ $track['preview_url'] }}" type="audio/mpeg">
                                    </audio>
                                @else
                                    <span class="text-gray-500">No Preview Available</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- SweetAlert Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('downloadAlbumBtn').addEventListener('click', function(event) {
        event.preventDefault();
        const downloadUrl = this.href;

        fetch(downloadUrl)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Download Initiated!',
                        text: 'Your album download will begin shortly.',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            data.downloadLinks.forEach(link => {
                                const a = document.createElement('a');
                                a.href = link;
                                a.download = ''; 
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                            });
                        } else if (result.isDismissed) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'Download has been cancelled.',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    });
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const albumName = "{{ $album['name'] }}";
    const artistName = "{{ $artist['name'] }}";

    fetch(`/video/fetch/${encodeURIComponent(albumName)}/${encodeURIComponent(artistName)}`)
        .then(response => response.json())
        .then(data => {
            if (data.thumbnailUrl && data.videoUrl) {
                const thumbnail = document.getElementById('video-thumbnail');
                const videoPlayer = document.getElementById('video-player');
                const videoSource = document.getElementById('video-source');

                thumbnail.src = data.thumbnailUrl;
                thumbnail.style.display = 'block';

                videoSource.src = data.videoUrl; // This now points to the Laravel proxy
                videoPlayer.load(); // Load the video source

                thumbnail.addEventListener('click', function() {
                    videoPlayer.style.display = 'block';
                    videoPlayer.play().catch(error => {
                        console.error('Error playing video:', error);
                    });
                    thumbnail.style.display = 'none';
                });
            } else {
                console.error('Failed to load video data:', data.error);
            }
        })
        .catch(error => {
            console.error('Error fetching video:', error);
        });
});
</script>
</x-app-layout>
