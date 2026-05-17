<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $userRole = Role::where('slug', 'user')->first();

        $user = User::create([
            'role_id' => $userRole?->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token, 'Registrasi berhasil.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        return $this->respondWithToken($token, 'Login berhasil.');
    }

    public function me()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diambil.',
            'data' => [
                'user' => $user->load('role'),
            ],
        ]);
    }

    public function logout()
    {
        JWTAuth::parseToken()->invalidate();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    public function refresh()
    {
        $token = JWTAuth::parseToken()->refresh();

        return $this->respondWithToken($token, 'Token berhasil diperbarui.');
    }

    protected function respondWithToken($token, string $message)
    {
        $user = JWTAuth::setToken($token)->authenticate();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
                'user' => $user?->load('role'),
            ],
        ]);
    }
}