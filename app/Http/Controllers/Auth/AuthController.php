<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use stdClass;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
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
        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // $user = Auth::user();
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = new stdClass();
            $response->token = $token;
            $response->name = $user->name;
            $response->email = $user->email;
            $response->tokenType = 'Bearer';
            return response()->json($response, 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function logout(Request $request)
    {
        // Auth::user()->tokens()->delete();
        $user = User::where('email', $request->email)->firstOrFail();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
