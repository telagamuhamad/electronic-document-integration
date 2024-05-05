<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();
            if ($user->role !== 'Kurir') {
                return response()->json([
                    'error' => true,
                    'error_message' => 'Unauthorized access',
                ]);
            }
            $token = $user->createToken('authToken')->plainTextToken;
            
            return response()->json([
                'error' => false,
                'token' => $token,
                'user' => $user,
                'userId' => $user->id,
                'license_plate' => $user->username
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
