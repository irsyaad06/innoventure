<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 👇 PERUBAHAN: Tentukan guard 'juri' saat mencoba login
        if (!Auth::guard('juri')->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password yang Anda masukkan salah.'],
            ]);
        }

        $request->session()->regenerate();

        // Mengembalikan data juri yang sedang login
        return response()->json([
            'message' => 'Login berhasil.',
            'user' => Auth::guard('juri')->user(),
        ]);
    }

    public function logout(Request $request)
    {
        // 👇 PERUBAHAN: Tentukan guard 'juri' saat logout
        Auth::guard('juri')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
