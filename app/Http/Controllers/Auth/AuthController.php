<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use stdClass;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2',
                'lastname' => 'required|string|min:2',
                'email' => 'required|email|unique:users|min:4',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => '400'], 
                    400);
            }
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = new stdClass();
            $response->token = $token;
            $response->name = $user->name;
            $response->email = $user->email;
            $response->tokenType = 'Bearer';
            return response()->json(
                ['data'=>$response,
                       'status'    => true,
                       'message' => 'Usuario registrado'],
               200);
            // return response()->json($response, 200);
        } catch (Exception $e) {
            Log::error('Error al registrar el usuario: ' . $e->getMessage());
            return response()->json(
                ['message' => 'Error al registrar el usuario',
                    'status' => false],
                500
            );
        }
    }

    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                           'status'  => '400'], 
                    400);

        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // $user = Auth::user();
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = new stdClass();
            $response->id = $user->id;
            $response->token = $token;
            $response->name = $user->name;
            $response->email = $user->email;
            $response->tokenType = 'Bearer';
            $response->profile_photo =$user->profile_photo;
            return response()->json(
                ['data'=>$response,
                       'status'    => true,
                       'message' => 'Usuario Autorizado'],
               200);
        }
        
        return response()->json(
            ['data'=>[],
                   'status'    => false,
                   'message' => 'Usuario no autorizado'],
           401);
        }catch(Exception $e){
            Log::error('Error al iniciar sesión: '.$e->getMessage());
            return response()->json(
                ['message' => 'Error al iniciar sesión',
                    'status' => false],
                500
            );
        }
    }
    public function logout(Request $request)
    {
        // Auth::user()->tokens()->delete();
        $user = User::where('email', $request->email)->firstOrFail();
        $user->tokens()->delete();
        return response()->json(
            ['message' => 'sesión terminada',
                'status' => true],
            200
        );
        
    }

   
}
