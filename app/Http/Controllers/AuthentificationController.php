<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthentificationController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->validate([
            "name" => 'required',
            "password" => 'required|confirmed',
            "email" => 'email|required'
        ]);

        User::create([
            "name" => $request->nom,
            "password" => Hash::make($request->password),
            "name" => $request->email
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'token' => $user->createToken(time())->plainTextToken,
                    'user' => $user
                ]);
            }
        }
        return response()->json([
            "message" => "Email ou mot de passe éronné"
        ], 401);
    }

    public function logout(Request $request)
    {
        User::whereEmail($request->email)->first()->tokens()->delete();
        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function checkToken(Request $request)
    {
        try {
            $user = User::whereEmail($request->email)->first();
            /*             if ($$user) {
                return response()->json([
                    'message' => 'ok'
                ]);
            } */
            return response()->json([
                'message' => 'ok'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "token n'existe plus"
            ], 401);
        }
    }
}