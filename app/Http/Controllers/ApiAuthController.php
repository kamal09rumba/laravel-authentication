<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validated_data = $request->validate([
            "name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|string|confirmed"
        ]);

        $validated_data["password"] = Hash::make($validated_data["password"]);
        $user = new User($validated_data);
        $user->save();

        return response()->json([
            "user" => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|string|email",
            "password" => "required|string",
        ]);

        $credentials = request(["email", "password"]);

        if (!auth()->attempt($credentials)) {
            return response()->json(["message" => "Invalid credentials"], 401);
        }
        $user = auth()->user();
        $access_token = $user->createToken("authToken")->accessToken;
        return response()->json([
            "access_token" => $access_token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            "message" => "Successfully logged out"
        ], 200);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
