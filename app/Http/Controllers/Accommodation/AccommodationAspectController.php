<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccommodationAspect;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class AccommodationAspectController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationAspects = AccommodationAspect::with(relations: ['aspect','accommodation'])
            ->where('status','=','true')->get();
            if($accommodationAspects->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay Aspectos registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationAspects,
                       'status'    => true,
                       'message' => 'Aspectos encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los Aspectos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los Aspectos',
                       'status'   => false], 
                500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'aspect_id' => 'required'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el Aspecto: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => false], 
                    400);
                    
            }
            $accommodationAspect = AccommodationAspect::create($request->all());
            return response()->json(
                ['data'=>$accommodationAspect,
                       'status'    => true,
                       'message' => 'Aspectos registrado'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar el Aspectos: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el Aspectos',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationAspect $accommodationAspect)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'aspect_id' => 'required'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el Aspecto: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationAspectUpdated = $accommodationAspect->update($request->all());
            $data = ['data'=>$accommodationAspectUpdated,
            'status'    => true,
            'message' => 'Aspectos actualizado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar el Aspectos: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar el Aspectos',
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
            $accommodationAspects = AccommodationAspect::with(['accommodation','Aspect'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationAspects->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existe Aspectos para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationAspects,
                       'status'    => true,
                       'message' => 'Aspectos encontrados'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener los Aspectos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los Aspectos',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodationAspect = AccommodationAspect::find($id);
            if($accommodationAspect)
            {
             $accommodationAspectUpdated = $accommodationAspect->update(['status'=>0]);
            }else{
                $accommodationAspectUpdated = false;
            }

            if (!$accommodationAspectUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationAspectUpdated,
            'status'    => true,
            'message' => 'Aspecto eliminado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar el Aspecto: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar el Aspecto',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
