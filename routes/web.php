<?php

use Illuminate\Support\Facades\Route;

// API routes are handled separately
// All frontend routes should return the same view for Vue Router to handle
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
