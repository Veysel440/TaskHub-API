<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::post('/login', function () {
    $credentials = request(['email', 'password']);
    if (auth()->attempt($credentials)) {
        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('tags', TagController::class);
});
