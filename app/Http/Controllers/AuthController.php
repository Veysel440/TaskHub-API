<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            if (!Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Şifre hatalı'], 401);
            }
        }

        $token = $this->getOrCreateToken($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Giriş başarısız'], 401);
        }

        $user = Auth::user();
        return response()->json([
            'token' => $this->getOrCreateToken($user),
        ]);
    }

    public function getOrCreateToken($user)
    {
        $tokenModel = $user->tokens()->latest('id')->first();

        if ($tokenModel && $tokenModel->expires_at > now()) {
            return $tokenModel->token;
        }

        $user->tokens()->delete();

        $tokenResult = $user->createToken('api_token');
        $token = $tokenResult->plainTextToken;

        $user->tokens()->latest('id')->first()->update([
            'expires_at' => now()->addDay(),
        ]);

        return $token;
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
