<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $token = $user->createToken('library-api')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user->only([
                'user_id', 'name', 'email', 'phone', 'address'
            ]),
            'token' => $token,
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check(
                $validated['password'],
                $user->password
            )) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $token = $user->createToken('library-api')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user->only([
                'user_id', 'name', 'email', 'phone', 'address'
            ]),
            'token' => $token,
        ], 200);
    }

    // Current user
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()->only([
                'user_id', 'name', 'email', 'phone', 'address'
            ]),
        ], 200);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful.',
        ], 200);
    }
}
