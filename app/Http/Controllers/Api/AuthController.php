<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::query()->create([
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'message' => 'User created',
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::query()
            ->where('email', '=', $request->input('username'))
            ->orWhere('phone_number', '=', $request->input('username'))
            ->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
