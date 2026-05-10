<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CommentController;


// Authenticated users සඳහා පමණක් ඇති රූට්ස්
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard එකට ගිය විට කෙලින්ම ටිකට් ලැයිස්තුව පෙන්වීම
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');

    // Ticket Management Routes [cite: 14, 15]
    Route::resource('tickets', TicketController::class)->only(['index', 'store', 'show']);

    // Admin හට Status එක Update කිරීමට ඇති රූට් එක 
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])
        ->name('tickets.updateStatus');

    // Threaded Discussion (Comments) සඳහා රූට් එක [cite: 17, 18]
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});