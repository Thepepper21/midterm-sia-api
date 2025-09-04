<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

Route::get('/pexels/search', [GalleryController::class, 'search']);


