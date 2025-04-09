<?php


// use Illuminate\Http\Request;
use App\Http\Controllers\Accommodation\DescribeController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Accommodation\AccommodationController;
use App\Http\Controllers\Accommodation\AccommodationServiceController;
use App\Http\Controllers\Accommodation\AccommodationAspectController;
use App\Http\Controllers\Accommodation\AccommodationRulesController;
use App\Http\Controllers\Accommodation\AccommodationInstructionController;
use App\Http\Controllers\Accommodation\AccommodationDescriptionController;
use App\Http\Controllers\Accommodation\AccommodationPriceController;
use App\Http\Controllers\Accommodation\AccommodationAmenityController;
use App\Http\Controllers\Accommodation\AccommodationAvailabilityController;
use App\Http\Controllers\Accommodation\AccommodationPhotoController;
use App\Http\Controllers\Accommodation\AccommodationTypeController;
use App\Http\Controllers\Accommodation\AccommodationDiscountController;
use App\Http\Controllers\AspectController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Traveler\ExploreController;
use App\Http\Controllers\Reserve\ReserveController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verification', [AuthController::class, 'sendVerificationEmail'])->name('verification');
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
        Route::get('/services', 'index');
        Route::get('/services/{id}', 'show');
        Route::post('/services', 'store');
        
    });

    Route::controller(ExploreController::class)->group(function () {
        Route::prefix('explore')->group(function () {
            Route::get('accommodation/nearby', 'HandleGetNearbyAccomodation');
            Route::get('accommodation/{id}', 'HandleGetAccommodationById');
            Route::get('accommodation/describe/{describe_id}', 'HandleGetAccomodationByDescribe');
            Route::get('describes', 'HandleGetDescribesAvailables');
        });
    });

    Route::controller(FavoriteController::class)->prefix('favorites')->group(function () {
        Route::get('', 'HandleGetFavoritesByUser');
        Route::post('', 'HandleStoreAccommodationFavoriteUser');
        // Route::delete('/{id}', 'HandleDeleteFavorite');
    });
    Route::controller(AccommodationController::class)->prefix('accommodations')->group(function(){
        Route::get('', 'index');
        Route::get('/{id}', 'show');
        Route::get('/{userId}/user', 'showByUserId');
        Route::post('', 'store');
        Route::put('/{accommodation}', 'update');
        Route::delete('/{id}', 'delete');
        Route::post('/filter', 'filter');
    });

    Route::controller(AccommodationServiceController::class)->prefix('accommodation_services')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationService}', 'update');
        Route::delete('/{accommodationId}/{serviceId}', 'delete');
    });

    Route::controller(AccommodationAspectController::class)->prefix('accommodation_aspects')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationAspect}', 'update');
        Route::delete('/{accommodationId}/{aspectId}', 'delete');
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

    Route::controller(AccommodationDescriptionController::class)->prefix('accommodation_descriptions')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationDescription}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationPriceController::class)->prefix('accommodation_prices')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationPrice}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationDiscountController::class)->prefix('accommodation_discounts')->group(function(){
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationPrice}', 'update');
        Route::delete('/{id}', 'delete');
    });


    Route::controller(AccommodationAmenityController::class)->prefix('accommodation_amenities')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::post('', 'store');
        Route::put('/{accommodationAmenity}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationAvailabilityController::class)->prefix('accommodation_availabilities')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        // Route::post('', 'store');
        // Route::put('/{accommodationAvailability}', 'update');
        // Route::delete('/{id}', 'delete');
    });

    Route::controller(AccommodationPhotoController::class)->prefix('accommodation_photos')->group(function(){
        Route::get('', 'index');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::get('/main/{accommodationId}/accommodation', 'showMainByAccommodation');
        Route::post('', 'store');
        Route::post('/upload', 'upload');
        Route::put('/{accommodationPhoto}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(DescribeController::class)->prefix('describes')->group(function(){
        Route::get('', 'index');
    });
    Route::controller(AspectController::class)->prefix('aspects')->group(function(){
        Route::get('', 'index');
        Route::get('/{describeId}/describe', 'showByDescribeId');
    });
    Route::controller(AccommodationTypeController::class)->prefix('accommodation_types')->group(function(){
        Route::get('', 'index');
    });

    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::put('/{user}', 'update');
        Route::put('/{user}/password', 'changePassword');
        Route::get('/{id}', 'show');
        Route::post('upload/{user}', 'upload');
    });
    
    Route::controller(ReserveController::class)->prefix('reserves')->group(function(){
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('/{accommodationId}/accommodation', 'showByAccommodation');
        Route::get('/{userId}/user', 'showByUser');
    });



});

// Route::get('/servicios', function () {
//     return 'servicios';
// });
