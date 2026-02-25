<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    
    return response()->json([
        'message' => 'All caches cleared successfully!'
    ]);
});


Route::get('/', function () {
    return view('welcome');
});
