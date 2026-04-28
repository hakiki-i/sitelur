<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiLoginController extends Controller
{
   public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // DEBUG
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan']);
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Password salah']);
        }

        // LOGIN
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Auth gagal']);
        }

        $token = $user->createToken('android')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user
        ]);
    }
}
