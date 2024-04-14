<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UserLoginRequest;
use App\Http\Requests\Api\V1\User\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $login = $request->validated("login");
        $password = $request->validated("password");
        if(!Auth::guard("web")->attempt(["login" => $login, "password" => $password])){
            return response()->json(["message" => "Incorrect Login or Password"], 401);
        }
        $user = Auth::guard("web")->user();
        $token = $user->createToken("login");
        return response()->json(["token" => $token->plainTextToken]);
    }

    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            "login" => $request->validated("login"),
            "email" => $request->validated("email"),
            "password" => bcrypt($request->validated("password"))
        ]);
        $token = $user->createToken("login");
        return response()->json([
            "message" => "You are registered",
            "token" => $token->plainTextToken
        ], 200);
    }
}
