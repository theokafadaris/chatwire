<!-- resources/views/bible/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
        <style>
            .loading-container {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
        </style>
        <h1 class="text-xl font-bold header-title leading-relaxed text-center">
            If you wish to download any book in the Bible, click this button 👇👇. However, you can click on any book below to read instantly.
        </h1>
        <div class="flex justify-center my-4">
            <button id="downloadButton" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-gray-700 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4 mr-2">
                    <path d="M256 464a208 208 0 1 1 0-416 208 208 0 1 1 0 416zM256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM128 256l0 32L256 416 384 288l0-32-80 0 0-128-96 0 0 128-80 0z"/>
                </svg>
                Initiate Download
            </button>
        </div>
    </x-slot>

    <div class="loading-container" id="loadingAnimation">
        <dotlottie-player src="https://lottie.host/01e63b5d-8695-46c0-a418-cc791a8cad85/83G2PVEYFe.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
    </div>

    <div class="container mx-auto py-8">
        <!-- Old Testament Section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-4">Old Testament</h1>

            <!-- Flexbox layout with horizontal alignment for Genesis to Deuteronomy -->
            <div class="flex flex-wrap justify-between gap-4 mb-6">
                @foreach(['Genesis', 'Exodus', 'Leviticus', 'Numbers', 'Deuteronomy'] as $book)
                    <x-book-card name="{{ $book }}" coverImage="gen-deut.jpeg" />
                @endforeach
            </div>

            <!-- Flexbox layout for Joshua to Esther -->
            <div class="flex flex-wrap justify-between gap-4 mb-6">
                @foreach(['Joshua', 'Judges', 'Ruth', '1 Samuel', '2 Samuel', '1 Kings', '2 Kings', '1 Chronicles', '2 Chronicles', 'Ezra', 'Nehemiah', 'Esther'] as $book)
                    <x-book-card name="{{ $book }}" coverImage="josh-esth.jpeg" />
                @endforeach
            </div>

            <!-- Flexbox layout for Job to Song of Solomon -->
            <div class="flex flex-wrap justify-between gap-4 mb-6">
                @foreach(['Job', 'Psalms', 'Proverbs', 'Ecclesiastes', 'Song of Solomon'] as $book)
                    <x-book-card name="{{ $book }}" coverImage="job-songs.jpeg" />
                @endforeach
            </div>

            <!-- Flexbox layout for Isaiah to Malachi -->
            <div class="flex flex-wrap justify-between gap-4">
                @foreach(['Isaiah', 'Jeremiah', 'Lamentations', 'Ezekiel', 'Daniel', 'Hosea', 'Joel', 'Amos', 'Obadiah', 'Jonah', 'Micah', 'Nahum', 'Habakkuk', 'Zephaniah', 'Haggai', 'Zechariah', 'Malachi'] as $book)
                    <x-book-card name="{{ $book }}" coverImage="isa-mal.jpeg" />
                @endforeach
            </div>
        </div>

        <!-- New Testament Section -->
        <div>
            <h1 class="text-2xl font-bold mb-4">New Testament</h1>

            <!-- Flexbox layout for Matthew to Acts -->
            <div class="flex flex-wrap justify-between gap-4 mb-6">
                @foreach(['Matthew', 'Mark', 'Luke', 'John', 'Acts'] as $book)
                    <x-book-card name="{{ $book }}" coverImage="matt-acts.jpeg" />
                @endforeach
            </div>

            <!-- Flexbox layout for Romans to Jude -->
            <div class="flex flex-wrap justify-between gap-4 mb-6">
                @foreach(['Romans', '1 Corinthians', '2 Corinthians', 'Galatians', 'Ephesians', 'Philippians', 'Colossians', '1 Thessalonians', '2 Thessalonians', '1 Timothy', '2 Timothy', 'Titus', 'Philemon', 'Hebrews', 'James', '1 Peter', '2 Peter', '1 John', '2 John', '3 John', 'Jude', 'Revelation'] as $book)
                    <x-book-card name="{{ $book }}" coverImage="rom-jude.jpeg" />
                @endforeach
            </div>
        </div>
    </div>
    <script>
    document.getElementById('downloadButton').addEventListener('click', function () {
        const loadingAnimation = document.getElementById('loadingAnimation');
        const books = [
            'Genesis', 'Exodus', 'Leviticus', 'Numbers', 'Deuteronomy', 'Joshua', 'Judges', 'Ruth',
            '1 Samuel', '2 Samuel', '1 Kings', '2 Kings', '1 Chronicles', '2 Chronicles', 'Ezra', 
            'Nehemiah', 'Esther', 'Job', 'Psalms', 'Proverbs', 'Ecclesiastes', 'Song of Solomon',
            'Isaiah', 'Jeremiah', 'Lamentations', 'Ezekiel', 'Daniel', 'Hosea', 'Joel', 'Amos',
            'Obadiah', 'Jonah', 'Micah', 'Nahum', 'Habakkuk', 'Zephaniah', 'Haggai', 'Zechariah', 
            'Malachi', 'Matthew', 'Mark', 'Luke', 'John', 'Acts', 'Romans', '1 Corinthians', 
            '2 Corinthians', 'Galatians', 'Ephesians', 'Philippians', 'Colossians', '1 Thessalonians',
            '2 Thessalonians', '1 Timothy', '2 Timothy', 'Titus', 'Philemon', 'Hebrews', 'James', 
            '1 Peter', '2 Peter', '1 John', '2 John', '3 John', 'Jude', 'Revelation'
        ];

        Swal.fire({
            title: 'Select a Book to Download',
            input: 'select',
            inputOptions: books.reduce((options, book) => {
                options[book] = book;
                return options;
            }, {}),
            inputPlaceholder: 'Select a book',
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to select a book!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading animation
                loadingAnimation.style.display = 'block';

                // Make an AJAX request to initiate the download
                fetch(`/download/${encodeURIComponent(result.value)}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        return response.blob();
                    } else {
                        throw new Error('Download failed');
                    }
                })
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `${result.value}.pdf`; 
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'There was an error with the download process.', 'error');
                })
                .finally(() => {
                    loadingAnimation.style.display = 'none';
                });
            } else {
                // Hide loading animation if canceled
                loadingAnimation.style.display = 'none';
            }
        });
    });
</script>

</x-app-layout>
