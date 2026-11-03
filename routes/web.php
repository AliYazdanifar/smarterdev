<?php

use App\Http\Controllers\Shop\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogPost'])->name('blog-post');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/project-request', [PageController::class, 'projectRequest'])->name('project-request');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

foreach (array_keys(sd_content('services')) as $serviceKey) {
    Route::get('/services/'.service_slug($serviceKey), fn () => app(PageController::class)->service($serviceKey))
        ->name($serviceKey);
}

Route::fallback([PageController::class, 'notFound']);
