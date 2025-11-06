<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileUpdateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PenyuKitaController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TurtleNestFindingController;
use App\Http\Controllers\TurtleNestingLocationController;
use App\Http\Controllers\TurtleDataDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;

// Landing Page (Public - Hanya untuk Guest)
Route::get('/', [HomeController::class, 'index'])->middleware('guest')->name('home');

// // Redirect authenticated users dari home ke penyukita
// Route::get('/', function () {
//     return redirect()->route('penyukita.index');
// })->middleware('auth');

// PenyuKita (Authenticated Users Only)
Route::middleware('auth')->group(function () {
    Route::get('/penyukita', [PenyuKitaController::class, 'index'])->name('penyukita.index');
});

// Dashboard (Authenticated)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (Default Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Profile Routes (Public untuk semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/user/{user}', [UserProfileController::class, 'show'])->name('user.profile');
});

// Custom Profile Routes (dengan JavaScript/Tabs)
Route::middleware('auth')->group(function () {
    Route::get('/profile/custom', [ProfileUpdateController::class, 'edit'])->name('profile.custom');
    Route::post('/profile/update', [ProfileUpdateController::class, 'updateProfile'])->name('profile.update.info');
    Route::post('/profile/password', [ProfileUpdateController::class, 'updatePassword'])->name('profile.update.password');
});

// Posts Routes (Semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Like & Comment (AJAX)
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::post('/posts/{post}/comment', [PostController::class, 'storeComment'])->name('posts.comment');
    Route::delete('/comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy');
});


// Chat Global Routes (Semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
});



// Turtle Eggs Routes (Hanya untuk role penangkaran)
Route::middleware(['auth', 'isPenangkaran'])->group(function () {
    Route::get('/turtle-eggs', function () {
        return view('turtle-eggs.index');
    })->name('turtle-eggs.index');
    
    // Nest Findings Management
    Route::resource('turtle-eggs/findings', TurtleNestFindingController::class)
        ->names([
            'index' => 'turtle-eggs.findings.index',
            'create' => 'turtle-eggs.findings.create',
            'store' => 'turtle-eggs.findings.store',
            'show' => 'turtle-eggs.findings.show',
            'edit' => 'turtle-eggs.findings.edit',
            'update' => 'turtle-eggs.findings.update',
            'destroy' => 'turtle-eggs.findings.destroy',
        ]);
    
    // Nesting Locations Management
    Route::resource('turtle-eggs/locations', TurtleNestingLocationController::class)
        ->names([
            'index' => 'turtle-eggs.locations.index',
            'create' => 'turtle-eggs.locations.create',
            'store' => 'turtle-eggs.locations.store',
            'show' => 'turtle-eggs.locations.show',
            'edit' => 'turtle-eggs.locations.edit',
            'update' => 'turtle-eggs.locations.update',
            'destroy' => 'turtle-eggs.locations.destroy',
        ]);
});

// Public Turtle Data Dashboard (Transparansi untuk semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/turtle-data', [TurtleDataDashboardController::class, 'index'])->name('turtle-data.dashboard');
});

// Articles Management (Hanya untuk role penangkaran)
Route::middleware(['auth', 'isPenangkaran'])->group(function () {
    Route::resource('articles', ArticleController::class);
});

// Article Public View & Interactions (Semua authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/penyukita/article/{article:slug}', [ArticleController::class, 'show'])->name('articles.public.show');
    Route::post('/articles/{article}/like', [ArticleController::class, 'toggleLike'])->name('articles.like');
    Route::post('/articles/{article}/comment', [ArticleController::class, 'storeComment'])->name('articles.comment');
    Route::delete('/article-comments/{comment}', [ArticleController::class, 'destroyComment'])->name('articles.comments.destroy');
});

require __DIR__.'/auth.php';