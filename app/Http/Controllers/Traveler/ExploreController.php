<?php

namespace App\Http\Controllers\Traveler;

use App\Http\Controllers\Controller;
use App\Models\Describe;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use Illuminate\Support\Facades\Log;
use Exception;

class ExploreController extends Controller{

    public function HandleGetDescribesAvailables(){
        Log::info("Obteniendo descripciones disponibles");
        try {
            $describes = Describe::where('status','=','true')->get();
            Log::info('Descripciones disponibles: '.$describes->count());
            if($describes->isEmpty()){
                return response()->json([
                    'data'=>[],
                    'message' => 'No existen descripciones registradas',
                    'status'    => false
                ],200);
            }
            return response()->json([
                'data'=>$describes,
                'status'    => true,
                'message' => 'Descripciones encontradas'
            ],200);
        } catch (Exception $e) {
            Log::error('Error al obtener los datos: '.$e->getMessage());
            return response()->json([ 
                'data'=>[],
                'message' => 'Ocurrio un error al obtener las descripciones',
                'status'   => false
            ], 500);
        }
    }

    public function HandleGetAccomodationByDescribe($describe_id, Request $request){
        Log::info('Getting accomodation by describe');
        $user = $request->user();
        Log::info("Datos de usuario:",$user->toArray());
        try {
            $accomodations = Accommodation::with(relations: [
                'type', 
                'describe', 
                'aspects.aspect', 
                'services.service', 
                'photos',
                'discounts',
                'rules',
                'instructions',
                'user'
            ])->where('describe_id', $describe_id)->where('status','=','true')->where('published','=',true)->get();
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
                'message' => 'Error al obtener los anuncios',
                'status'   => false
            ], 500);
        }
    }

    public function HandleGetAccommodationById($id){
        Log::info('Getting accomodation by id');
        try {
            $accomodation = Accommodation::with(relations: [
                'type', 
                'describe', 
                'aspects.aspect', 
                'services.service', 
                'photos',
                'discounts',
                'rules',
                'instructions',
                'user'
            ])->where('id', $id)->first();
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