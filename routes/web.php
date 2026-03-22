<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;

$welcomPage = fn () => view('layouts.app', [
    'title' => 'Корочки.есть',
    'slot' => new HtmlString(view('pages.⚡welcom-page.welcom-page')->render()),
]);

Route::get('/', $welcomPage)->name('home');
Route::get('/welcom-page', $welcomPage)->name('welcom-page');
Route::livewire('/login', 'pages::login-page')->name('login');
Route::livewire('/register', 'pages::register-page')->name('register');
