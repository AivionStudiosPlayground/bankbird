<?php

use Illuminate\Support\Facades\Route;

if (! config('app.demo_mode', false)) {
    Route::get('/', fn () => view('welcome'));
    Route::get('/install', fn () => view('install'));
    Route::get('/docs', fn () => view('docs'));
    Route::get('/demo', fn () => view('demo'));
    Route::get('/updates', fn () => view('updates'));
    Route::get('/kennisbank', fn () => view('kennisbank'));
    Route::get('/vibe-dev', fn () => view('vibe-dev'));
    Route::get('/over', fn () => view('over'));
    Route::get('/legal', fn () => view('legal'));
}
