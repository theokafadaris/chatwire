<!-- resources/views/components/book-card.blade.php -->
<a href="{{ url('/bible/' . $name) }}" 
   class="book-card block w-48 h-64 text-left bg-white shadow-lg rounded-lg overflow-hidden">
    <!-- Book Image -->
    <img src="{{ asset($coverImage) }}" alt="{{ $name }} Book Cover" class="w-full h-3/4 object-cover">
    
    <!-- Book Details -->
    <div class="p-2 text-center">
        <!-- Book Title with Icon -->
        <span class="text-lg font-bold inline-flex items-center">
            {{ $name }}
        </span>
    </div>
</a>
