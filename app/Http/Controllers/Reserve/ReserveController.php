<?php

namespace App\Http\Controllers\Reserve;

use App\Http\Controllers\Controller;
use App\Models\AccommodationAvailability;
use DateTime;
use DatePeriod;
use DateInterval;
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
            ->where('status','=',true)->get();
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
                'end_date'=>'date|required',
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
            $rango = $this->getRangeDate($request['start_date'], $request['end_date'], 'Y-m-d');
            $reserve_id = $reserve->id;
            $reserveSend = Reserve::with(relations: ['accommodation','user'])->findOrFail($reserve_id);
            foreach ($rango as $value) {
                # code...
                $availability =["accommodation_id"=>$reserve->accommodation_id,
                "start_date"=>$value,
                "availability"=>0,
                "reserve_id"=>$reserve_id,
                                ]; 
                AccommodationAvailability::create($availability);
            }
            return response()->json(
                ['data'=>$reserveSend,
                       'status'    => true,
                       'message' => 'Reserva registrada'],
               200);
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
    public function showByAccommodation ($accommodationId)
    {
        //
        try {
            $accommodationPrices = Reserve::where('accommodation_id','=',$accommodationId)
                                       ->where('status','=',true)
                                       ->get();
            if($accommodationPrices->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen reservas para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationPrices,
                       'status'    => true,
                       'message' => 'reservas encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener reservas: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener reservas',
                       'status'   => false], 
                500);
        }

    }

    public function showByUser ($userId)
    {
        //
        try {
            $fecha_actual = date("Y-m-d");
            $fechaAyer=date("Y-m-d",strtotime($fecha_actual."- 1 days"));
            $accommodationReserves = Reserve::orderByDesc('id')
                                       ->with(['accommodation'])
                                       ->where('user_id','=',$userId)
                                       ->where('status','=',true)
                                       ->where('end_date','>',$fechaAyer)
                                       ->get();
            if($accommodationReserves->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen reservas para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationReserves,
                       'status'    => true,
                       'message' => 'reservas encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener reservas: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener reservas',
                       'status'   => false], 
                500);
        }

    }
    public function getRangeDate($date_ini, $date_end, $format) {

        $dt_ini = DateTime::createFromFormat($format, $date_ini);
        $dt_end = DateTime::createFromFormat($format, $date_end);
        $period = new DatePeriod(
            $dt_ini,
            new DateInterval('P1D'),
            $dt_end,
        );
        $range = [];
        foreach ($period as $date) {
            $range[] = $date->format($format);
        }
        $range[] = $date_end;
        return $range;
    }
}
