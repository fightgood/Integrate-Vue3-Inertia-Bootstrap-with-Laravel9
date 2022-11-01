<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get(
    '/',
    static function () {
        return Inertia::render(
            'Home',
            [
                'title' => 'Homepage',
            ]
        );
    }
)->name('homepage');

Route::get(
    '/about',
    static function () {
        return Inertia::render(
            'About',
            [
                'title' => 'About',
            ]
        );
    }
)->name('about');

Route::get(
    '/contact',
    static function () {
        return Inertia::render(
            'Contact',
            [
                'title' => 'Contact',
            ]
        );
    }
)->name('contact');
