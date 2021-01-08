<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'api' => env('APP_URL') . '/api'
    ]);
});
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});


Route::get('mail', function () {
    mail('rayhan095@gmail.com', 'test subject', 'hello from laravel');
    return "mail sent";
});
