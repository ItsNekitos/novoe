<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //register user
    public function registration(RegisterRequest $request)
    {

        $user = User::create($request->only(["email", "password", "first_name", "last_name"]));
        $token = $user->createToken("api");
        return response([
            "success" => true, "message" => "Success",
            'token' => $token->plainTextToken
        ]);
    }

    //auth
    public function authorization(AuthRequest $request)
    {

        if ($user = User::where("email", $request->email)->first() and Hash::check($request->password, $user->password)) {
            $token = $user->createToken("api");
            return response([
                "success" => true, "message" => "Success",
                'token' => $token->plainTextToken
            ]);
        } else {
            return response([
                "success" => false, "message" => "Login failed"
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            "success" => true, "message" => "Logout",
        ]);
    }
}
