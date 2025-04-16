<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validation->fails()) {
            //200 adalah status
            return response()->json($validation->errors(), 200);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            // 'password_confirmation' => $request->password_confirmation
        ]);

        //encode 
        try {
            $token = JWTAuth::fromUser($user);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }


        return response()->json([
            'message' => 'added user success',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validation->fails()) {

            return response()->json($validation->errors(), 442);
        }
        $credential = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credential)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logout Success']);
    }

    public function me()
    {
        try {
            $user = auth('api')->user();
            $employee = auth()->guard('api')->user()->employee;
            return response()->json([
                'message' => 'Fetch profil user success',
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
