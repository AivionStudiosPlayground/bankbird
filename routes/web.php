<?php

use App\Support\Demo;
use Illuminate\Support\Facades\Route;

if (Demo::isMarketingSite()) {
    Route::get('/', fn () => view('welcome'));
    Route::get('/install', fn () => view('install'));
    Route::get('/docs', fn () => view('docs'));

    if (! Demo::isLocalCombined()) {
        Route::get('/demo', fn () => view('demo'));
    }

    Route::get('/updates', fn () => view('updates'));
    Route::get('/updates/technisch', fn () => view('updates-technisch'))->name('updates.technisch');
    Route::get('/kennisbank', fn () => view('kennisbank'));
    Route::get('/vibe-dev', fn () => view('vibe-dev'));
    Route::get('/over', fn () => view('over'));
    Route::get('/faq', fn () => view('faq'));
    Route::get('/legal', fn () => view('legal'));
}
