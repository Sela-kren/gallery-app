<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
Route::get('/', function () {
    
    return view('welcome');
});

Route::post('/upload', [ImageController::class, 'store'])->name('image.upload');
