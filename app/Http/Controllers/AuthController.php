<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected function jwt($id)
    {
        $payload = [
            'iss' => "lumen~jwt~linkmedis", // Issuer of the token
            'sub' => $id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];
        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => [
                    'code' => 200,
                    'message' => 'ok',
                ],
                'token' => $this->jwt(Auth::user()->id),
                'user' => Auth::user(),
            ], 200);
        }
        return response()->json([
            'status' => [
                'code' => 406,
                'message' => 'Login Failed',
            ],
            'detail' => 'Email atau Password Salah',
        ], 406);
    }

    public function cekToken(Request $request){
        $token = $request->header('token');
        $user_id = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'))->sub;
        $user = User::find($user_id);

        return response()->json([
            'status' => [
                'code' => 200,
                'message' => 'ok',
            ],
            'user' => $user,
        ], 200);
    }
}
