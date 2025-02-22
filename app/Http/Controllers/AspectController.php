<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspect;
use Exception;
use Illuminate\Support\Facades\Log;

class AspectController extends Controller
{
    //
    public function index()
    {
        try {
            $aspects = Aspect::where('status','=',true)->get();
            if($aspects->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay aspectos registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$aspects,
                       'status'    => true,
                       'message' => 'Aspectos encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los aspectos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los aspectos',
                       'status'   => false], 
                500);
        }
    }

    public function showByDescribeId($describeId)
    {
        try {
            // $aspects = Aspect::where('status','=',true)
            //                  ->where('describe_id', '=',$describeId)
                                // ->get();
            $aspects = Aspect::where('status','=',true)
                             ->get() ;
            if($aspects->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay aspectos registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$aspects,
                       'status'    => true,
                       'message' => 'Aspectos encontrados'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener los aspectos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener los aspectos',
                       'status'   => false], 
                500);
        }
    }
}
