<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use Illuminate\Support\Facades\Log;
use Exception;

class ExploreController extends Controller{

    public function HandleGetAccommodationById($id){
        Log::info('Getting accomodation by id');
        try {
            $accomodation = Accommodation::with(relations: ['type', 'describe', 'aspects', 'services', 'prices', 'photos'])->where('id', $id)->first();
            if($accomodation == null){
                return response()->json(
                    [
                           'data'=>[],
                           'message' => 'No existen anuncios registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json([
                'data'=>$accomodation,
                'status'    => true,
                'message' => 'Anuncio encontrado'
            ],200);
        } catch (Exception $e) {
            Log::error('Error al obtener el anuncio: '.$e->getMessage());
            return response()->json([ 
                'data'=>[],
                'message' => 'Error al obtener el anuncio',
                'status'   => false
            ], 500);
        }
    }
    // Buscar anuncios cercanos falta completar el filtro de ubicaciones cercanas
    public function HandleGetNearbyAccomodation(Request $request){
        Log::info('Getting nearby accomodation');
        try {
            $accomodations = Accommodation::with(relations: ['type', 'describe', 'aspects', 'services', 'prices', 'photos'])
            ->where('status','=','true')->where('published','=',true)->get();
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