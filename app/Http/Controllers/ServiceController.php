<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreserviceRequest;
use App\Http\Requests\UpdateserviceRequest;
use App\Models\Service;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $services = Service::where('status','=',true)->get();
            if($services->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay servicios registrados',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$services,
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreserviceRequest $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|min:3',
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el servicio: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => '400'], 
                    400);
                    
            }
            $service = Service::create($request->all());
            return response()->json(
                ['data'=>$service,
                       'status'    => true,
                       'message' => 'Servicio registrado'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar el servicio: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el servicio',
                           'status'   => false], 
                    500);
            }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $service = Service::find($id);
        if(!$service){
            $data = ['message' => 'no se encontró el servicio',
                       'status'    => '404'];
            return response()->json(
                $data, 
                404);
        }
        $data = ['service' => $service,
                       'status'    => '200'];
        
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateserviceRequest $request, service $service)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|min:3',
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
            $service->update($request->all());
            $data = ['data'=>$service,
            'status'    => true,
            'message' => 'Servicio actualizado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar el servicio: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar el servicio',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(service $service)
    {
        //
    }
}
