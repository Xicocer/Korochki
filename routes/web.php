<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;

$welcomPage = fn () => view('layouts.app', [
    'title' => 'Корочки.есть',
    'slot' => new HtmlString(view('pages.⚡welcom-page.welcom-page')->render()),
]);

Route::get('/', $welcomPage)->name('home');
Route::get('/welcom-page', $welcomPage)->name('welcom-page');
Route::livewire('/dashboard', 'pages::user-dashboard')
    ->middleware('auth')
    ->name('dashboard');
Route::livewire('/admin', 'pages::admin-applications')
    ->middleware('auth')
    ->name('admin.applications');
Route::livewire('/admin/slides', 'pages::admin-slider')
    ->middleware('auth')
    ->name('admin.slides');
Route::livewire('/admin/users', 'pages::admin-users')
    ->middleware('auth')
    ->name('admin.users');
Route::livewire('/create-application', 'pages::create-application')
    ->middleware('auth')
    ->name('applications.create');
Route::post('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');
Route::livewire('/login', 'pages::login-page')->name('login');
Route::livewire('/register', 'pages::register-page')->name('register');
