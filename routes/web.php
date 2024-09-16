<?php

use App\Http\Controllers\ChatBoxController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordpressController;
use App\Models\ChatBox;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\ReutersController;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\BibleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $chatboxes = ChatBox::whereUserId(auth()->id())->paginate(10);

    return view('dashboard', [
        'chatboxes' => $chatboxes,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/spotify', [SpotifyController::class, 'index'])->name('spotify');
    Route::post('/spotify/search', [SpotifyController::class, 'search'])->name('spotify.search');
    Route::get('/spotify/album/{id}', [SpotifyController::class, 'showAlbum'])->name('spotify.album');
    Route::get('/spotify/download-album/{albumId}', [SpotifyController::class, 'downloadAlbum'])->name('spotify.download.album');
    
    Route::get('/video/fetch/{album}/{artist}', [VideoController::class, 'fetchVideo'])->name('video.fetch');
    Route::get('/video/stream', [VideoController::class, 'streamVideo'])->name('video.stream');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    // Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

    Route::delete('/chatbox/{chatbox}', [ChatBoxController::class, 'destroy'])->name('chatbox.destroy');
    Route::get('/chatbox/{chatbox?}', [ChatBoxController::class, 'index'])->name('chatbox');

    Route::get('/wordpress', [WordpressController::class, 'index'])->name('wordpress');

    Route::get('/ai', [AIController::class, 'index'])->name('ai');
    Route::post('/ai/send', [AIController::class, 'send'])->name('ai.send');
    Route::post('/ai/send-gemini', [AIController::class, 'sendGemini'])->name('ai.send-gemini');


    Route::get('/reuters', [ReutersController::class, 'index'])->name('reuters.index');

    Route::get('/bible', [BibleController::class, 'index'])->name('bible.index');
    // Route::get('/api/fetch-book', [BibleController::class, 'fetchBook']);
    Route::get('/bible/{book}', [BibleController::class, 'show'])->name('bible.show');
    Route::get('/download/{book}', [BibleController::class, 'download']); 

    
    Route::get('/translate', [TranslateController::class, 'index'])->name('translate.index');
    Route::post('/translate/detect', [TranslateController::class, 'detect'])->name('translate.detect');
    Route::post('/translate/translate', [TranslateController::class, 'translate'])->name('translate.translate');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
