<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\VerificationCode;
use App\Mail\EmailVerification;
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
            $response->profile_photo_url = $user->profile_photo_url;
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

    public function sendVerificationEmail(Request $request)
    {
        try {
           $user = User::where('email', $request->email)->firstOrFail();
            $verificationCode = rand(100000, 999999);
            VerificationCode::create([
                'user_id' => $user->id,
                'code' => $verificationCode.'',
                'expires_at' => now()->addMinutes(5),
            ]);
            //$user->verification_code = $verificationCode;
           // $user->save();
            // Mail::to($user->email)->send(new EmailVerification($verificationCode));
             Mail::to($request->email)->send(new EmailVerification($verificationCode));
            return response()->json(
                [
                    'message' => 'Código de verificación enviado',
                    'status' => true],
                200
            );
        } catch (Exception $e) {
            Log::error('Error al enviar el correo de verificación: ' . $e->getMessage());
            return response()->json(
                ['message' => 'Error al enviar el correo de verificación',
                    'status' => false],
                500
            );
        }
    }

    public function verificate(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $code = VerificationCode::where('code', '=', $request->code)
                ->where('user_id','=', $user->id)
                ->where('is_used','=', false)
                ->where('expires_at', '>', now())
                ->first();
            if(isset($code)){
                if($code->is_used) {
                    return response()->json(
                        ['message' => 'El código ya ha sido utilizado',
                            'status' => false],
                        400
                    );
                }
                if($code->expires_at < now()) {
                    return response()->json(
                        ['message' => 'El código ha expirado',
                            'status' => false],
                        400
                    );
                }
            }else{
                return response()->json(
                    ['message' => 'Código no válido',
                        'status' => false],
                    400
                );
            }
           
            $code->update(['is_used' => true]);
            //$user = User::find($request->user_id);
            $user->update(['email_verified_at' => now(),
                'verified' => true]);
            return response()->json(
                [
                    'message' => 'Código verificado con éxito',
                    'status' => true],
                200
            );
        } catch (Exception $e) {
            Log::error('Error al verificar código: ' . $e->getMessage());
            return response()->json(
                ['message' => 'Error al verificar código',
                    'status' => false],
                500
            );
        }
    }

   
}
