<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccommodationService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class AccommodationServiceController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationServices = AccommodationService::with(relations: ['service','accommodation'])
            ->where('status','=','true')->get();
            if($accommodationServices->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay servicios registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationServices,
                       'status'    => true,
                       'message' => 'Servicios encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los Servicios: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los Servicios',
                       'status'   => false], 
                500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'service_id' => 'required'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el servicio: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => false], 
                    400);
                    
            }
            $accommodationService = AccommodationService::create($request->all());
            return response()->json(
                ['data'=>$accommodationService,
                       'status'    => true,
                       'message' => 'Servicios registrado'],
               200);
            }catch (Exception $e) {
                
                Log::error('Error al registrar el Servicios: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el Servicios',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationService $accommodationService)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'service_id' => 'required'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el servicio: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationServiceUpdated = $accommodationService->update($request->all());
            $data = ['data'=>$accommodationServiceUpdated,
            'status'    => true,
            'message' => 'Servicios actualizado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar el Servicios: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar el Servicios',
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
            $accommodationServices = AccommodationService::where('accommodation_id','=',$accommodationId)
                                                         ->where('status','=',true)
                                    ->get();
            if($accommodationServices->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existe servicios para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationServices,
                       'status'    => true,
                       'message' => 'Servicios encontrados'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener los servicios: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los servicios',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $accommodationId,$serviceId)
    {
        //
        
        try{
            $accommodationService = AccommodationService::where('accommodation_id',"=",$accommodationId )
                                                        ->where('service_id',"=",$serviceId )->first();
            $accommodationService
            ?$accommodationServiceUpdated = $accommodationService->delete()
            : $accommodationServiceUpdated = false;
            
            if (!$accommodationServiceUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationService,
            'status'    => true,
            'message' => 'Servicio eliminado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar el Servicio: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar el Servicio',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
