<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Reserve;
class EventController extends Controller
{
    //
    public function index()
    {
        try {
            $events = Event ::where('id', '>',0)
                ->get();

            if ($events->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No hay eventos registrados',
                    'status' => false
                ], 200);
            }

            return response()->json([
                'data' => $events,
                'status' => true,
                'message' => 'Eventos encontrados'
            ], 200);
        } catch (Exception $e) {
            Log::error('Error al obtener los Eventos: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'Error al obtener los Eventos',
                'status' => false
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'reserve_id' => 'required|integer',
                'type' => 'required|string',
                'event_date' => 'nullable|date',
                'note' => 'nullable|string',
                'photo_url' => 'nullable|string',
                // 'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => null,
                    'message' => "Errores en la validación",//$validator->errors(),
                    'status' => false
                ], 422);
            }

            $event = Event::create($request->all());
            if($event->type == 'Checkin'){
                $reserve = Reserve::find($event->reserve_id);
                $reserve->update(['state' => "Ocupando"]);
            }
            if($event->type == 'Checkout'){
                $reserve = Reserve::find($event->reserve_id);
                $reserve->update(['state' => "Finalizado"]);
            }
                

            return response()->json([
                'data' => $event,
                'message' => 'Evento creado exitosamente',
                'status' => true
            ], 200);
        } catch (Exception $e) {
            Log::error('Error al crear el Evento: ' . $e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'Error al crear el Evento',
                'status' => false
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $event = Event::find($id);

            if (!$event) {
                return response()->json([
                    'data' => null,
                    'message' => 'Evento no encontrado',
                    'status' => false
                ], 404);
            }

            return response()->json([
                'data' => $event,
                'message' => 'Evento encontrado',
                'status' => true
            ], 200);
        } catch (Exception $e) {
            Log::error('Error al obtener el Evento: ' . $e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'Error al obtener el Evento',
                'status' => false
            ], 500);
        }
    }
    public function getByReserve($reserveId)
    {
        try {
            $event = Event::where('reserve_id', $reserveId)
                            ->get();

            if ($event->isEmpty() ) {
                return response()->json([
                    'data' => [],
                    'message' => 'Eventos no encontrados',
                    'status' => true
                ], 200);
            }

            return response()->json([
                'data' => $event,
                'message' => 'Eventos encontrados',
                'status' => true
            ], 200);
        } catch (Exception $e) {
            Log::error('Error al obtener el Eventos: ' . $e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'Error al obtener el Eventos',
                'status' => false
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $event = Event::find($id);

            if (!$event) {
                return response()->json([
                    'data' => null,
                    'message' => 'Evento no encontrado',
                    'status' => false
                ], 404);
            }

            $event->update($request->all());

            return response()->json([
                'data' => $event,
                'message' => 'Evento actualizado exitosamente',
                'status' => true
            ], 200);
        } catch (Exception $e) {
            Log::error('Error al actualizar el Evento: ' . $e->getMessage());
            return response()->json([
                'data' => null,
                'message' => 'Error al actualizar el Evento',
                'status' => false
            ], 500);
        }
    }
}
