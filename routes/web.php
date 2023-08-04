<?php

use App\Http\Controllers\ChatBoxController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordpressController;
use App\Models\ChatBox;
use Illuminate\Support\Facades\Route;

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
    Route::delete('/chatbox/{chatbox}', [ChatBoxController::class, 'destroy'])->name('chatbox.destroy');
    Route::get('/chatbox/{chatbox?}', [ChatBoxController::class, 'index'])->name('chatbox');

    Route::get('/wordpress', [WordpressController::class, 'index'])->name('wordpress');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
