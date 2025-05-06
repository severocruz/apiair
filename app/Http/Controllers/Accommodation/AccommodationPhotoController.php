<?php

namespace App\Http\Controllers\Accommodation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\AccommodationPhoto;
use Illuminate\Support\Facades\Storage;

class AccommodationPhotoController extends Controller
{
    //
    public function index()
    {
        try {
            $accommodationPhotos = AccommodationPhoto::with(relations: ['accommodation'])
            ->where('status',true)->get();
            if($accommodationPhotos->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No hay fotos registradas',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationPhotos,
                       'status'    => true,
                       'message' => 'fotos encontrada'],
               200);
        } catch (Exception $e) {
            Log::error('Error al obtener las fotos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las fotos',
                       'status'   => false], 
                500);
        }
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'photo_url'=>'required|string|min:3',
                'mainPhoto' => 'required|boolean',
                'order'=>'required|numeric'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el foto: ',
            // (array)$validator->errors());
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => false], 
                    400);
                    
            }
            $accommodationPhoto = AccommodationPhoto::create($request->all());
            return response()->json(
                ['data'=>$accommodationPhoto,
                       'status'    => true,
                       'message' => 'Foto registrada'],
               201);
            }catch (Exception $e) {
                
                Log::error('Error al registrar la foto: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
                return response()->json(
                    [ 'data'=>null,
                            'message' => 'Error al registrar el fotos',
                           'status'   => false], 
                    500);
            }

    }

    public function update(Request $request, AccommodationPhoto $accommodationPhoto)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'mainPhoto' => 'required|boolean',
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el foto: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $accommodationPhotoUpdated = $accommodationPhoto->update($request->all());
            $data = ['data'=>$accommodationPhotoUpdated,
            'status'    => true,
            'message' => 'Foto actualizada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar la foto: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar la foto',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }

    public function upload(Request $request)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required',
                'mainPhoto' => 'required|boolean',
                'order'=>'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el foto: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $photo = $request->file('image');
            $photoName = date('Ymd').time().'.'.$photo->extension();
            $photo->move(public_path('images/accommodations'), $photoName);
            Log::info('Subiendo imagen a: '.public_path('images/accommodations'));
             //Storage::putFileAs('public/images/accommodations',$photo,$photoName);
            $accommodationPhoto = new AccommodationPhoto();
            $accommodationPhoto->accommodation_id = $request->accommodation_id;
            $accommodationPhoto->photo_url = $photoName;
            $accommodationPhoto->mainPhoto = $request->mainPhoto;
            $accommodationPhoto->order = $request->order;
            $accommodationPhotoCreated = AccommodationPhoto::create($accommodationPhoto->toArray());
            $data = ['data'=>$accommodationPhotoCreated,
            'status'    => true,
            'message' => 'foto creada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al crear la foto: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al crear la foto',
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
            $accommodationPhotos = AccommodationPhoto::with(['accommodation'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->get();
            if($accommodationPhotos->isEmpty()){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen fotos para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationPhotos,
                       'status'    => true,
                       'message' => 'fotos encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener las fotos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las fotos',
                       'status'   => false], 
                500);
        }

    }

    public function showMainByAccommodation ($accommodationId)
    {
        //
        try {
            $accommodationPhotos = AccommodationPhoto::with(['accommodation'])
                                    ->where('accommodation_id','=',$accommodationId)
                                    ->first();
            if(!$accommodationPhotos){
                return response()->json(
                    [
                            'data'=>[],
                            'message' => 'No existen fotos para el Alojamiento',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodationPhotos,
                       'status'    => true,
                       'message' => 'fotos encontradas'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener las fotos: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener las fotos',
                       'status'   => false], 
                500);
        }

    }

    public function delete( $id)
    {
        //
        
        try{
            $accommodationPhoto = AccommodationPhoto::find($id);
            if($accommodationPhoto)
            {
                $image_path = public_path().'/images/accommodations/'.$accommodationPhoto->photo_url;
                unlink($image_path);
             $accommodationPhotoUpdated = $accommodationPhoto->delete();
            }else{
                $accommodationPhotoUpdated = false;
            }

            if (!$accommodationPhotoUpdated) {
            $data = ['message' => 'No se pudo eliminar',
            'errors' => [],
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $data = ['data'=>$accommodationPhoto,
            'status'    => true,
            'message' => 'descripcion eliminada'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                Log::error('Error al eliminar foto: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al eliminar descripcion',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }
}
