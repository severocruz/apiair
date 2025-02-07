<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationDescription;

class AccommodationDescriptionController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationDescriptions = AccommodationDescription::with(relations: ['accommodation'])
            ->where('status','=','true')->get();
            if($accommodationDescriptions->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay descripciones registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationDescriptions,
                       'status'    => true,
                       'message' => 'descripciones encontrada'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener las descripciones: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las descripciones',
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
            //     Log::error('Error al validar el descripción: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => '400'], 
                    400);
                    
            }
            $accommodationDescription = AccommodationDescription::create($request->all());
            return response()->json(
                ['data'=>$accommodationDescription,
                       'status'    => true,
                       'message' => 'descripcion registrada'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la descripción: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el descripciones',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationDescription $accommodationDescription)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'title' => 'required|string|min:3',
                'description'=>'required|string|min:3'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el descripción: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationDescriptionUpdated = $accommodationDescription->update($request->all());
            $data = ['data'=>$accommodationDescriptionUpdated,
            'status'    => true,
            'message' => 'descripcion actualizada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar la descripción: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar la descripcion',
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
            $accommodationDescriptions = AccommodationDescription::with(['accommodation'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationDescriptions->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen descripciones para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationDescriptions,
                       'status'    => true,
                       'message' => 'descripciones encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener las descripciones: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las descripciones',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodationDescription = AccommodationDescription::find($id);
            if($accommodationDescription)
            {
             $accommodationDescriptionUpdated = $accommodationDescription->update(['status'=>0]);
            }else{
                $accommodationDescriptionUpdated = false;
            }

            if (!$accommodationDescriptionUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationDescriptionUpdated,
            'status'    => true,
            'message' => 'descripcion eliminada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar descripción: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar descripcion',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
