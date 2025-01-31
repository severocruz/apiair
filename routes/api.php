<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\AuthController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::controller(AuthController::class)
->middleware('auth:sanctum')->prefix('auth')
->group(function () {
    Route::post('/logout', 'logout');
});
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);
// });


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::controller(ServiceController::class)->group(function () {
        Route::get('/servicios', 'index');
        Route::get('/servicios/{id}', 'show');
        Route::post('/servicios', 'store');
        
    });

});

// Route::get('/servicios', function () {
//     return 'servicios';
// });
