<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationRule;

class AccommodationRulesController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationRules = AccommodationRule::with(relations: ['accommodation'])
            ->where('status','=','true')->get();
            if($accommodationRules->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay reglas registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationRules,
                       'status'    => true,
                       'message' => 'reglas encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los reglas: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los reglas',
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
            //     Log::error('Error al validar el regla: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => '400'], 
                    400);
                    
            }
            $accommodationRule = AccommodationRule::create($request->all());
            return response()->json(
                ['data'=>$accommodationRule,
                       'status'    => true,
                       'message' => 'regla registrada'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la regla: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el reglas',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationRule $accommodationRule)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'title' => 'required|string|min:3',
                'description'=>'required|string|min:3'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el regla: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationRuleUpdated = $accommodationRule->update($request->all());
            $data = ['data'=>$accommodationRuleUpdated,
            'status'    => true,
            'message' => 'regla actualizada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar la regla: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar la regla',
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
            $accommodationRules = AccommodationRule::with(['accommodation'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationRules->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen reglas para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationRules,
                       'status'    => true,
                       'message' => 'reglas encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener las reglas: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los reglas',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodationRule = AccommodationRule::find($id);
            if($accommodationRule)
            {
             $accommodationRuleUpdated = $accommodationRule->update(['status'=>0]);
            }else{
                $accommodationRuleUpdated = false;
            }

            if (!$accommodationRuleUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationRuleUpdated,
            'status'    => true,
            'message' => 'regla eliminada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar regla: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar regla',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
