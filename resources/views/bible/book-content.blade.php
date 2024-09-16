<!-- resources/views/bible/book-content.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <title>The Book of {{ $book }}</title>
        <!-- Swiper CSS -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-4">The Book of {{ $book }}</h1>

        <!-- Swiper -->
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($chapters as $chapterNumber => $entries)
                    <div class="swiper-slide">
                        <h2 class="text-xl font-semibold mb-4">Chapter {{ $chapterNumber }}</h2>
                        @foreach ($entries as $entry)
                            <div class="p-4 border-b border-gray-200">
                                <p><strong>Bible Verse:</strong> {{ $entry['bible_verse'] }}</p>
                                <p><strong>Text:</strong> {{ $entry['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            <div class="swiper-pagination"></div>
            </div>


            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper', {
                direction: 'horizontal', // Horizontal sliding
                loop: true, // Loop slides

                // Pagination
                pagination: {
                    el: '.swiper-pagination',
                },

                // Navigation
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
</x-app-layout>
