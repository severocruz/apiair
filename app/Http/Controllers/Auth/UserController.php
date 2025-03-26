<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                //  'lastname' => '',
            ]);

            if ($validator->fails()) {
            //     Log::error('Error al validar el servicio: ',
            // (array)$validator->errors());
            $data = ['message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
           'status'  => false];
                return response()->json(
                    $data, 
                    400);
                    
            }
            $userUpdated = $user->update($request->all());
            $data = [
            'data'=>$userUpdated,
            'status'    => true,
            'message' => 'usuario actualizado'];
            return response()->json(
                $data,
               200);
            }catch (Exception $e) {
                
                Log::error('Error al actualizar el usuario: '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al actualizar el usuario',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }

    public function show($id)
    {
        //
        try {
            $accommodation = User::find($id);
            if(!$accommodation){
                return response()->json(
                    [
                            'data'=>json_decode('{}') ,
                            'message' => 'No existe este usuario',
                           'status'    => false], 
                    200);
    
            }
            return response()->json(
                ['data'=>$accommodation,
                       'status'    => true,
                       'message' => 'Usuario encontrado'],
               200);


        } catch (Exception $e) {
            Log::error('Error al obtener el usuario: '.$e->getMessage());
            return response()->json(
                [ 'data'=>[],
                        'message' => 'Error al obtener el usuario',
                       'status'   => false], 
                500);
        }

    }

    public function upload(User $user, Request $request)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'column' => 'required',
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
            $photo->move(public_path('images/users'), $photoName);
            
            if(isset($user->toArray()[$request['column']])){
                $image_path =public_path('images/users')."/".$user->toArray()[$request['column']];
                if (file_exists($image_path)){
                    unlink($image_path);
                }    
            }
             //Storage::putFileAs('public/images/accommodations',$photo,$photoName);
            $isUpdated = $user->update([$request['column']=>$photoName]);
             
            if($isUpdated){
                $userUpdated = User::find($user->id);
                $data = ['data'=>$userUpdated,
                'status'    => true,
                'message' => 'foto creada'];
                return response()->json(
                    $data,
                   200);
             } else{
                $data = ['message' => 'No se pudo completar la tarea',
                'errors' => [],
               'status'  => false];
                    return response()->json(
                        $data, 
                        400);
                        
             }
          
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
    public function changePassword(User $user, Request $request)
    {
        //
        try{
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6',
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
          
           
             //Storage::putFileAs('public/images/accommodations',$photo,$photoName);
            $isUpdated = $user->update($request->all());
             
            if($isUpdated){
                $userUpdated = User::find($user->id);
                $data = ['data'=>$userUpdated,
                'status'    => true,
                'message' => 'contraseña editada'];
                return response()->json(
                    $data,
                   200);
             } else{
                $data = ['message' => 'No se pudo editar la contraseña',
                'errors' => [],
               'status'  => false];
                    return response()->json(
                        $data, 
                        400);
                        
             }
          
            }catch (Exception $e) {
                
                Log::error('Error al editar contraseña : '.$e->getMessage(),
            ['trace' => $e->getTraceAsString()]);
            $data=[ 'data'=>null,
                    'message' => 'Error al editar contraseña',
                    'status'   => false];
                return response()->json(
                    $data, 
                    500);
            }	
    }

}
