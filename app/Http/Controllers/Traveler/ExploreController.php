<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use Log;
use Exception;

class ExploreController extends Controller{

    // Buscar anuncios cercanos falta completar el filtro de ubicaciones cercanas
    public function HandleGetNearbyAccomodation(Request $request){
        Log::info('Getting nearby accomodation');
        try {
            $accomodations = Accommodation::with(relations: ['type', 'describe', 'aspects', 'services', 'prices', 'photos'])
            ->where('status','=','true')->get();
            if($accomodations->isEmpty()){
                return response()->json(
                    [
                           'data'=>[],
                           'message' => 'No existen anuncios registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json([
                'data'=>$accomodations,
                'status'    => true,
                'message' => 'Anuncios encontrados'
            ],200);
            
        } catch (Exception $e) {
            Log::error('Error al obtener los anuncios: '.$e->getMessage());
            return response()->json([ 
                'data'=>[],
                'message' => 'Error al obtener las amenidades',
                'status'   => false
            ], 500);
        }
    }
}