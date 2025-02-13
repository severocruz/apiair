<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationAmenity;

class AccommodationAmenityController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationAmenitys = AccommodationAmenity::with(relations: ['accommodation'])
            ->where('status','=','true')->get();
            if($accommodationAmenitys->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay amenidades registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationAmenitys,
                       'status'    => true,
                       'message' => 'amenidades encontrada'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener las amenidades: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las amenidades',
                       'status'   => false], 
                500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'title' => 'required|string|min:3',
                'description'=>'required|string|min:3'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el amenidad: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => false], 
                    400);
                    
            }
            $accommodationAmenity = AccommodationAmenity::create($request->all());
            return response()->json(
                ['data'=>$accommodationAmenity,
                       'status'    => true,
                       'message' => 'amenidad registrada'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la amenidad: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el amenidades',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationAmenity $accommodationAmenity)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'title' => 'required|string|min:3',
                'description'=>'required|string|min:3'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el amenidad: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationAmenityUpdated = $accommodationAmenity->update($request->all());
            $data = ['data'=>$accommodationAmenityUpdated,
            'status'    => true,
            'message' => 'descripcion actualizada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar la amenidad: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar la amenidad',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }

    public function showByAccommodation ($accommodationId)
    {
        //
        try {
            $accommodationAmenitys = AccommodationAmenity::with(['accommodation'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationAmenitys->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen amenidades para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationAmenitys,
                       'status'    => true,
                       'message' => 'amenidades encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener las amenidades: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las amenidades',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodationAmenity = AccommodationAmenity::find($id);
            if($accommodationAmenity)
            {
             $accommodationAmenityUpdated = $accommodationAmenity->update(['status'=>0]);
            }else{
                $accommodationAmenityUpdated = false;
            }

            if (!$accommodationAmenityUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationAmenityUpdated,
            'status'    => true,
            'message' => 'descripcion eliminada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar amenidad: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar amenidad',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
