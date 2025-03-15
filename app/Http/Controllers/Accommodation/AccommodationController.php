<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\AccommodationInstruction;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class AccommodationController extends Controller
{
    //
    
    public function index()
    {
        try {
            $accommodations = Accommodation::with(relations: ['user','type'])
            ->where('status','=','true')->get();
            if($accommodations->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay alojamientos registra',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodations,
                       'status'    => true,
                       'message' => 'Alojamientos encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los alojamientos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los alojamientos',
                       'status'   => false], 
                500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'host_id' => 'required',
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
            $accommodation = Accommodation::create($request->all());

            AccommodationInstruction::create([
                                                     'accommodation_id'=>$accommodation->id,
                                                     'title'=>'¿Como llegar?',
                                                     'description'=>'',
                                                     'type'=>'encontrar',
                                                     'status'=>1]);
            AccommodationInstruction::create([
                                                        'accommodation_id'=>$accommodation->id,
                                                        'title'=>'Instrucciones de llegada',
                                                        'description'=>'',
                                                        'type'=>'llegada',
                                                        'status'=>1]);                                                     
            AccommodationInstruction::create([
                                                        'accommodation_id'=>$accommodation->id,
                                                        'title'=>'Instrucciones de salida',
                                                        'description'=>'',
                                                        'type'=>'salida',
                                                        'status'=>1]);
            return response()->json(
                ['data'=>$accommodation,
                       'status'    => true,
                       'message' => 'Alojamiento registrado'],
               200);
            }catch (Exception $e) {
                
                Log::error('Error al registrar el Alojamiento: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el alojamiento',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, Accommodation $accommodation)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'host_id' => 'required',
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el servicio: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationUpdated = $accommodation->update($request->all());
            $data = ['data'=>$accommodationUpdated,
            'status'    => true,
            'message' => 'Alojamiento actualizado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar el alojamiento: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar el alojamiento',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }

    public function show($id)
    {
        //
        try {
            $accommodation = Accommodation::with(['user',
                                                            'type',
                                                            'describe',
                                                            'aspects',
                                                            'services',
                                                            'prices',
                                                            'photos',
                                                            'discounts'])
                            ->find($id);
            if(!$accommodation){
                return response()->json(
                    [
                            'data'=>json_decode('{}') ,
                            'message' => 'No existe este alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodation,
                       'status'    => true,
                       'message' => 'Alojamiento encontrado'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener el alojamiento: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener el alojamiento',
                       'status'   => false], 
                500);
        }

    }
    public function showByUserId($userId)
    {
        try {
            // with(relations: ['user','type'])
             $accommodations = Accommodation::orderBy('id','DESC')
                                            ->with(['user',
                                                            'type',
                                                            'describe',
                                                            'aspects',
                                                            'services',
                                                            'prices',
                                                            'photos',
                                                            'discounts'])
                                            ->where('status','=','true')
                                            ->where('host_id','=',$userId)->get();
            if($accommodations->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No tienes alojamientos registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodations,
                       'status'    => true,
                       'message' => 'Alojamientos encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los alojamientos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los alojamientos',
                       'status'   => false], 
                500);
        }
    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodation = Accommodation::find($id);
            if($accommodation)
            {
             $accommodationUpdated = $accommodation->update(['status'=>0]);
            }else{
                $accommodationUpdated = false;
            }

            if (!$accommodationUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationUpdated,
            'status'    => true,
            'message' => 'Alojamiento eliminado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar el alojamiento: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar el alojamiento',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }

}
