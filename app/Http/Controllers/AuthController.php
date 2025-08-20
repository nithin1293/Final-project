<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|unique:users',
            'password'=> 'required|string|min:6'
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $token = JWTAuth::fromuser($user);

        return response()->json([
            'token'=> $token,
            'user' => $user,
        ], 201);
       
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error'=> 'Invalid Credentials'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function me()
    {
        $user = auth()->user();
        // $user = new UserResource($user);
        return response()->json(['user'=>$user]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logged out Successfully'],200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token'=> $token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL() *60
        ]);
    }
}