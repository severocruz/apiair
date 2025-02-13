<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationInstruction;
class AccommodationInstructionController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationInstructions = AccommodationInstruction::with(relations: ['accommodation'])
            ->where('status','=','true')->get();
            if($accommodationInstructions->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay Instrucciones registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationInstructions,
                       'status'    => true,
                       'message' => 'Instrucciones encontradas'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los Instrucciones: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los Instrucciones',
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
                'description'=>'required|string|min:3',
                'type'=>'required|string|min:3'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el Instruccione: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => false], 
                    400);
                    
            }
            $accommodationInstruction = AccommodationInstruction::create($request->all());
            return response()->json(
                ['data'=>$accommodationInstruction,
                       'status'    => true,
                       'message' => 'Instrucción registrada'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la Instrucción: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar la Instrucción',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationInstruction $accommodationInstruction)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'title' => 'required|string|min:3',
                'description'=>'required|string|min:3',
                'type'=>'required|string|min:3'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el Instruccione: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationInstructionUpdated = $accommodationInstruction->update($request->all());
            $data = ['data'=>$accommodationInstructionUpdated,
            'status'    => true,
            'message' => 'Instruccione actualizada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar la Instruccione: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar la Instruccione',
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
            $accommodationInstructions = AccommodationInstruction::with(['accommodation'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationInstructions->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen Instrucciones para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationInstructions,
                       'status'    => true,
                       'message' => 'Instrucciones encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener las Instrucciones: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los Instrucciones',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodationInstruction = AccommodationInstruction::find($id);
            if($accommodationInstruction)
            {
             $accommodationInstructionUpdated = $accommodationInstruction->update(['status'=>0]);
            }else{
                $accommodationInstructionUpdated = false;
            }

            if (!$accommodationInstructionUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => '400'];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationInstructionUpdated,
            'status'    => true,
            'message' => 'Instruccione eliminada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar Instruccione: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar Instruccione',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
