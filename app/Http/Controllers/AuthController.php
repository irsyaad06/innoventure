<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Juri;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari juri berdasarkan email
        $juri = Juri::where('email', $request->email)->first();

        // Verifikasi juri dan password
        if (!$juri || !Hash::check($request->password, $juri->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password yang Anda masukkan salah.'],
            ]);
        }

        // Hapus token lama & buat token baru
        $juri->tokens()->delete();
        $token = $juri->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'user' => $juri,
            'token' => $token, // <-- Kirim token ke frontend
        ]);
    }

    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan untuk otentikasi
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
