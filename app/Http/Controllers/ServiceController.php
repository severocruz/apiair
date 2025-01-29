<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreserviceRequest;
use App\Http\Requests\UpdateserviceRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Service::all();
        if($servicios->isEmpty()){
            return response()->json(
                ['message' => 'No hay servicios registrados',
                       'status'    => '404'], 
                200);

        }

        return response()->json($servicios,200);
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
     $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['message' => 'Error en la validación de datos',
                        'errors' => $validator->errors(),
                       'status'    => '400'], 
                400);
        }

        $service = Service::create($request->all());

        if(!$service){
            return response()->json(
                ['message' => 'Error al registrar el servicio',
                       'status'    => '500'], 
                500);
        }

        return response()->json($service, 201);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(service $service)
    {
        //
    }
}
