<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CropImageController;

Route::get('/', [CropImageController::class, 'index']);
Route::post('crop-image-upload', [CropImageController::class, 'upload'])->name('crop.image.upload.store');
