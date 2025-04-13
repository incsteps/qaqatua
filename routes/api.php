<?php

use App\Http\Controllers\Qaqatua\EchoController;
use App\Http\Controllers\Qaqatua\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group( function () {
    Route::resource('projects', ProjectController::class);

    Route::post('/encrypt', [EchoController::class, 'encrypt'])
        ->name("encrypt");

    Route::post('/decrypt', [EchoController::class, 'decrypt'])
        ->name("decrypt");

    Route::post('/ofuscate', [EchoController::class, 'ofuscate'])
        ->name("ofuscate");
});
