<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Exception;
use Storage;

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
        try {
            $validator = Validator::make($request->all(), [
                'column' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error en la validación de datos',
                    'errors' => $validator->errors(),
                    'status' => false
                ], 400);
            }

            // Configuración del disco
            $disk = 'custom_images';
            $directory = 'users'; // Subdirectorio dentro de 'public_html/apisamay/images/'
            $photo = $request->file('image');
            
            // Generar nombre único para la imagen
            $photoName = date('YmdHis').'_'.Str::random(10).'.'.$photo->extension();
            
            // Eliminar imagen anterior si existe
            if (!empty($user->{$request->column})) {
                $oldImagePath = $directory.'/'.$user->{$request->column};
                if (Storage::disk($disk)->exists($oldImagePath)) {
                    Storage::disk($disk)->delete($oldImagePath);
                }
            }
            
            // Guardar nueva imagen usando el filesystem de Laravel
            Storage::disk($disk)->putFileAs(
                $directory,
                $photo,
                $photoName
            );
            
            // Actualizar usuario
            $isUpdated = $user->update([$request->column => $photoName]);
            
            if ($isUpdated) {
                return response()->json([
                    'data' => User::find($user->id),
                    'status' => true,
                    'message' => 'Foto actualizada correctamente',
                    'url' => Storage::disk($disk)->url($directory.'/'.$photoName) // URL completa
                ], 200);
            }
            
            return response()->json([
                'message' => 'No se pudo actualizar el usuario',
                'errors' => [],
                'status' => false
            ], 400);
            
        } catch (Exception $e) {
            Log::error('Error al actualizar la foto: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id ?? null
            ]);
            
            return response()->json([
                'data' => null,
                'message' => 'Error interno al procesar la imagen',
                'status' => false
            ], 500);
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
