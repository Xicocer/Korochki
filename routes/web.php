<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;

$welcomPage = fn () => view('layouts.app', [
    'title' => 'Корочки.есть',
    'metaDescription' => 'Онлайн-запись на курсы дополнительного профессионального образования.',
    'metaKeywords' => 'курсы, обучение, онлайн-запись, квалификация',
    'ogTitle' => 'Корочки.есть - онлайн-запись на курсы',
    'ogDescription' => 'Выберите курс и отправьте заявку в несколько кликов.',
    'ogType' => 'website',
    'ogUrl' => route('home'),
    'ogImage' => asset('favicon.ico'),
    'twitterCard' => 'summary',
    'socialSchema' => [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Корочки.есть',
        'url' => route('home'),
        'description' => 'Онлайн-запись на курсы дополнительного профессионального образования.',
    ],
    'slot' => new HtmlString(view("pages.\u{26A1}welcom-page.welcom-page")->render()),
]);

Route::get('/', $welcomPage)->name('home');
Route::get('/welcom-page', $welcomPage)->name('welcom-page');
Route::livewire('/reviews', 'pages::reviews-page')->name('reviews.index');

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::login-page')->name('login');
    Route::livewire('/register', 'pages::register-page')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::user-dashboard')->name('dashboard');
    Route::livewire('/my-reviews', 'pages::my-reviews')->name('dashboard.reviews');
    Route::livewire('/create-application', 'pages::create-application')->name('applications.create');

    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    })->name('logout');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::livewire('/', 'pages::admin-applications')->name('applications');
        Route::livewire('/slides', 'pages::admin-slider')->name('slides');
        Route::livewire('/users', 'pages::admin-users')->name('users');
        Route::livewire('/reviews', 'pages::admin-reviews')->name('reviews');
        Route::livewire('/courses', 'pages::admin-courses')->name('courses');
    });
