<?php

use Homeful\References\Http\Controllers\CreateReferenceController;
use Illuminate\Support\Facades\Route;

Route::post('create-reference', CreateReferenceController::class)
    ->prefix('api')
    ->middleware('api')
    ->name('create-reference');
