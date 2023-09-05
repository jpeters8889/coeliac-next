<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ReviewImageUploadController;
use Illuminate\Support\Facades\Route;

Route::post('review/image-upload', ReviewImageUploadController::class)
    ->name('api.wheretoeat.review.image-upload');
