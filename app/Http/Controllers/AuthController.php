<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api")->except("login", "registration");
    }


    public function registration(RegistrationRequest $request)
    {
        User::create(array_merge([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]));

        return response()->json(["message" => "User successfully registered"]);
    }


    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->all())) {
            return response()->json(["error" => "Unauthorized"], 401);
        }
        return $this->createNewToken($token);
    }


    public function logout()
    {
        auth()->logout();
        return response()->json("Successfully logged out");
    }


    protected function createNewToken($token)
    {
        return response()->json([
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" => auth()->factory()->getTTL(),
            "user" => auth()->user()
        ]);
    }
}
