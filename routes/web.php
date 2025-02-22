<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\DataLogger;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([DataLogger::class])->group(function () {
    Route::get('/logs', function () {
        return view('logs');
    });
});