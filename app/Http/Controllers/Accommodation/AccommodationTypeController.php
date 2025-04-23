<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\AccommodationType;

class AccommodationTypeController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationTypes = AccommodationType::where('status',true)
                                                    ->get();
            if($accommodationTypes->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay datos registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationTypes,
                       'status'    => true,
                       'message' => 'Datos encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los datos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los datos',
                       'status'   => false], 
                500);
        }
    }
}
