<x-app-layout>

    <x-slot name="header">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <h1 class="text-3xl font-bold header-title">Reuters News</h1>
            <!-- Main Content Container -->
    <div class="relative">
        <!-- Swiper Navigation Buttons -->
        <div class="swiper-navigation absolute top-1/2 w-full flex justify-between transform -translate-y-1/2 px-4">
            <div class="swiper-button-prev bg-black text-white w-10 h-10 flex items-center justify-center rounded-full"></div>
            <div class="swiper-button-next bg-black text-white w-10 h-10 flex items-center justify-center rounded-full"></div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper-container w-full h-auto mx-auto px-4 py-0">
            <div class="swiper-wrapper flex p-0">
                @foreach ($articles as $article)
                    <div class="swiper-slide flex justify-center items-center bg-white p-0 m-0">
                        <!-- Article Container -->
                        <div class="article-container max-w-md w-full text-left bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Article Image -->
                            @if(isset($article['files'][0]['urlCdn']))
                                <img src="{{ $article['files'][0]['urlCdn'] }}" alt="Article Image" class="w-full h-auto">
                            @else
                                <img src="default-image.jpg" alt="Default Image" class="w-full h-auto">
                            @endif

                            <!-- Article Details -->
                            <div class="p-4">
                                <!-- Article Title -->
                                <h2 class="text-2xl font-bold">{{ $article['articlesName'] ?? 'Untitled Article' }}</h2>

                                <!-- Short Description -->
                                <p class="italic text-gray-700 mt-2">{{ $article['articlesShortDescription'] ?? 'No description available' }}</p>

                                <!-- Article Description -->
                                @if(is_array($article['articlesDescription']))
                                    @foreach($article['articlesDescription'] as $description)
                                        @if(isset($description['type']) && $description['type'] == 'paragraph')
                                            <p class="text-gray-600 mt-2">{{ $description['content'] ?? '' }}</p>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-gray-600 mt-2">No detailed description available.</p>
                                @endif

                                <!-- Published Date & Timezone -->
                                @if(isset($article['publishedAt']['date']))
                                    <p class="text-gray-500 mt-4">
                                        Published: {{ \Carbon\Carbon::parse($article['publishedAt']['date'])->format('F j, Y, g:i a') }} 
                                        ({{ $article['publishedAt']['timezone'] ?? 'Unknown Timezone' }})
                                    </p>
                                @endif

                                <!-- Author Name -->
                                @if(isset($article['authors'][0]['authorName']))
                                    <p class="text-gray-800 font-bold mt-2">By: {{ $article['authors'][0]['authorName'] }}</p>
                                @else
                                    <p class="text-gray-800 font-bold mt-2">By: Unknown Author</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Swiper Pagination -->
            <div class="swiper-pagination absolute bottom-0 w-full text-center px-4"></div>
        </div>
    </div>
    </x-slot>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.swiper-container', {
                direction: 'horizontal',
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    bulletClass: 'swiper-pagination-bullet',
                    bulletActiveClass: 'swiper-pagination-bullet-active',
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(isset($error))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ $error }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                @endif
            });
        </script>


    <style>
        /* Reset margin and padding for body to eliminate unexpected space */
        body, html {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important; /* Prevent horizontal scrolling */
        }

        .header-title {
            margin-bottom: 0 !important; /* Remove bottom margin from header */
        }

        .swiper-container {
            width: 100% !important;
            height: auto !important;
            position: relative !important;
        }

        .swiper-wrapper {
            display: flex !important;
            align-items: center !important;
            padding: 0 !important; /* Remove extra padding */
        }

        .swiper-slide {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            background: #fff !important;
            padding: 0 !important; /* Remove padding */
            margin: 0 !important; /* Remove margin */
        }

        .article-container {
            max-width: 600px !important;
            width: 100% !important;
            user-select: text; 
            text-align: left !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            margin: 0 !important; /* Remove margin */
        }

        .swiper-pagination {
            position: absolute !important;
            bottom: 0 !important; /* Position at the bottom */
            width: 100% !important;
            text-align: center !important;
            padding: 0 !important;
        }

        .swiper-pagination-bullet {
            background: #007BFF !important; /* Blue color for pagination dots */
        }

        .swiper-pagination-bullet-active {
            background: #0056b3 !important; /* Darker blue for active dot */
        }

        .swiper-navigation {
            position: absolute !important;
            top: 50% !important;
            width: calc(100% - 2.5rem) !important; /* Adjust width to fit with buttons */
            display: flex !important;
            justify-content: space-between !important;
            transform: translateY(-50%) !important;
            z-index: 10 !important;
        }

        .swiper-button-prev, .swiper-button-next {
            background-color: rgba(0, 0, 0, 0.5) !important;
            border-radius: 50% !important;
            color: #fff !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
        }

        .swiper-button-prev::after, .swiper-button-next::after {
            font-size: 20px !important;
        }

        .p-4 {
            padding: 1rem !important;
        }
    </style>
</x-app-layout>
