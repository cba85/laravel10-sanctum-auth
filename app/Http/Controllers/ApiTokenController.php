<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiTokenLoginRequest;
use App\Http\Requests\ApiTokenRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiTokenController extends Controller
{
    public function register(ApiTokenRegisterRequest $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['error' => "User already register"], 409);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken($request->token_name);

        // Abilities
        //$token = $user->createToken($request->token_name, ['repo:view', 'repo:create']);

        return [
            'token' => $token->plainTextToken,
            'user' => $user
        ];
    }

    public function login(ApiTokenLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => "Invalid credentials"], 401);
        }

        $user->tokens()->where('name', $request->token_name)->delete();

        $token = $user->createToken($request->token_name);
        // Abilities
        //$token = $user->createToken($request->token_name, ['repo:view']);

        return [
            'token' => $token->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(null, 204);
    }
}
