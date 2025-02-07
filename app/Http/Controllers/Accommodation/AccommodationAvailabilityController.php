<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationAvailability;
class AccommodationAvailabilityController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationAvailabilitys = AccommodationAvailability::with(relations: ['accommodation'])
            ->where('status','=','true')->get();
            if($accommodationAvailabilitys->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay fechas de disponibilidad registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationAvailabilitys,
                       'status'    => true,
                       'message' => 'fecha de disponibilidad encontrada'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener las fechas de disponibilidad: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las fechas de disponibilidad',
                       'status'   => false], 
                500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'start_date' => 'required|date',
                'end_date'=>'date',
                'availability'=>'required'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el fecha de disponibilidad: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => '400'], 
                    400);
                    
            }
            $accommodationAvailability = AccommodationAvailability::create($request->all());
            return response()->json(
                ['data'=>$accommodationAvailability,
                       'status'    => true,
                       'message' => 'descripcion registrada'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la fecha de disponibilidad: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar fecha de disponibilidad',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationAvailability $accommodationAvailability)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
               'accommodation_id' => 'required',
                'start_date' => 'required|date',
                'end_date'=>'date',
                'availability'=>'required'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el fecha de disponibilidad: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationAvailabilityUpdated = $accommodationAvailability->update($request->all());
            $data = ['data'=>$accommodationAvailabilityUpdated,
            'status'    => true,
            'message' => 'descripcion actualizada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar la fecha de disponibilidad: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar la fecha de disponibilidad',
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
            $accommodationAvailabilitys = AccommodationAvailability::with(['accommodation'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationAvailabilitys->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen fechas de disponibilidad para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationAvailabilitys,
                       'status'    => true,
                       'message' => 'fechas de disponibilidad encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener las fechas de disponibilidad: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las fechas de disponibilidad',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodationAvailability = AccommodationAvailability::find($id);
            if($accommodationAvailability)
            {
             $accommodationAvailabilityUpdated = $accommodationAvailability->update(['status'=>0]);
            }else{
                $accommodationAvailabilityUpdated = false;
            }

            if (!$accommodationAvailabilityUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationAvailabilityUpdated,
            'status'    => true,
            'message' => 'descripcion eliminada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar fecha de disponibilidad: '.$e->getMessage(),
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
