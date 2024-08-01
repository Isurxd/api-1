<?php

use App\Http\Controllers\Api\KlubController;
use App\Http\Controllers\Api\LigaController;
use App\Http\Controllers\Api\FanController;
use App\Http\Controllers\Api\PemainController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('liga', LigaController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Route::get('liga',[LigaController::class,'index']);
// Route::post('liga',[LigaController::class,'store']);
// Route::get('liga/{id}',[LigaController::class,'show']);
// Route::put('liga/{id}',[LigaController::class,'update']);
// Route::delete('liga/{id}',[LigaController::class,'destroy']);
Route::resource('liga', LigaController::class)->except(['create', 'edit']);
Route::resource('klub', KlubController::class)->except(['create', 'edit']);
Route::resource('pemain', PemainController::class)->except(['create', 'edit']);
Route::resource('fan', FanController::class)->except(['create', 'edit']);
