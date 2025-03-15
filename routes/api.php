<?php

use App\Http\Controllers\Qaqatua\EchoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/encrypt', [EchoController::class, 'encrypt'])
    ->name("encrypt");
    //->middleware('auth:sanctum');

Route::post('/decrypt', [EchoController::class, 'decrypt'])
    ->name("decrypt");
//->middleware('auth:sanctum');
