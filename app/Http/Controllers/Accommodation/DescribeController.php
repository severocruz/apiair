<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use App\Models\Describe;
// use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class DescribeController extends Controller
{
    //
    public function index()
    {
        try {
            $describes = Describe::where('status','=','true')
                                 ->get();
            if($describes->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay datos registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$describes,
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
