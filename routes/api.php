<?php


// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Accommodation\AccommodationController;
use App\Http\Controllers\Accommodation\AccommodationServiceController;
use App\Http\Controllers\Accommodation\AccommodationAspectController;
use App\Http\Controllers\Accommodation\AccommodationRulesController;
use App\Http\Controllers\Accommodation\AccommodationInstructionController;
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

    Route::controller(AccommodationController::class)->prefix('accommodations')->group(function(){
        Route::get('', 'index');
        Route::get('/{id}', 'show');
        Route::post('', 'store');
        Route::put('/{accommodation}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationServiceController::class)->prefix('accommodation_services')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationService}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationAspectController::class)->prefix('accommodation_aspects')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationAspect}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationRulesController::class)->prefix('accommodation_rules')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationRule}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationInstructionController::class)->prefix('accommodation_instructions')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationInstruction}', 'update');
        Route::delete('/{id}', 'delete');
    });

});

// Route::get('/servicios', function () {
//     return 'servicios';
// });
