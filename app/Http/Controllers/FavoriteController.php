<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Exception;
use Illuminate\Http\Request;
use Log;

class FavoriteController extends Controller
{
    public function HandleGetFavoritesByUser(Request $request){
        Log::info('HandleGetFavoritesByUser', [
            'user_id' => $request->user()->id,
        ]);
        try{
            $user = $request->user();
            $favorites = Favorite::with(['accommodation.photos', 'accommodation.prices'])
                ->where('user_id', $user->id)
                ->get();

            if($favorites->isEmpty()){
                return response()->json([
                    'data'=>[],
                    'message' => 'No existen favoritos registrados',
                    'status'    => false
                ],200);
            }

            // extraer solo los accommodations con sus relaciones 
            $accommodations = $favorites->map(function ($favorite) {
                return $favorite->accommodation;
            });

            return response()->json([
                'data'=>$accommodations,
                'status'    => true,
                'message' => 'Favoritos encontrados'
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'data'=>[],
                'message' => 'Ocurrio un error al obtener los favoritos',
                'status'   => false
            ], 500);
        }
    }

    public function HandleRemoveAccommodationFavoriteUser(Request $request){
        try {
            $user = $request->user();
            $accommodationId = $request->input('accommodation_id'); 
            $existingFavorite = Favorite::where('user_id', $user->id)
                ->where('accommodation_id', $accommodationId)
                ->first();

            if (!$existingFavorite) {
                return response()->json([
                    'data' => [],
                    'message' => 'El alojamiento no está en favoritos',
                    'status' => false
                ], 200);
            }

            // Delete the favorite
            $existingFavorite->delete();

            return response()->json([
                'data' => [],
                'message' => 'Alojamiento eliminado de favoritos',
                'status' => true
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => 'Ocurrio un error al eliminar el alojamiento de favoritos',
                'status' => false
            ], 500);
        }
    }
    public function HandleStoreAccommodationFavoriteUser(Request $request){
        try {
            $user = $request->user();
            $accommodationId = $request->input('accommodation_id');

            // Check if the accommodation already exists in favorites
            $existingFavorite = Favorite::where('user_id', $user->id)
                ->where('accommodation_id', $accommodationId)
                ->first();

            if ($existingFavorite) {
                return response()->json([
                    'data' => [],
                    'message' => 'El alojamiento ya está en favoritos',
                    'status' => false
                ], 200);
            }

            // Create a new favorite
            $favorite = Favorite::create([
                'user_id' => $user->id,
                'accommodation_id' => $accommodationId,
            ]);

            return response()->json([
                'data' => $favorite,
                'message' => 'Alojamiento agregado a favoritos',
                'status' => true
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => 'Ocurrio un error al agregar el alojamiento a favoritos',
                'status' => false
            ], 500);
        }
    }
}
