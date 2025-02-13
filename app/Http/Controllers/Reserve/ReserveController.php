<?php

namespace App\Http\Controllers\Reserve;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserve;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class ReserveController extends Controller
{
    //
    public function index()
    {
        try {
            $reserves = Reserve::with(relations: ['accommodation','user'])
            ->where('status','=','true')->get();
            if($reserves->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay reservas registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$reserves,
                       'status'    => true,
                       'message' => 'Reservas encontradas'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener las Reservas: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las Reservas',
                       'status'   => false], 
                500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'user_id' => 'required',
                'start_date'=>'date|required',
                'enda_date'=>'date|required',
                'number_guests'=>'required',
                'total_price'=>'required',
                'cash_discount'=>'required',
                'commission'=>'required'
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
            $reserve = Reserve::create($request->all());
            return response()->json(
                ['data'=>$reserve,
                       'status'    => true,
                       'message' => 'Reserva registrada'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la reserva: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar la reserva',
                           'status'   => false], 
                    500);
            }

    }
}
