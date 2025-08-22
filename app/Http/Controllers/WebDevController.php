<?php

namespace App\Http\Controllers;

use App\Models\WebdevProgress;
use Illuminate\Http\Request;

class WebDevController extends Controller
{

    public function index()
    {
        // Mengambil semua data dari model WebdevProgress, dengan relasi tim dan instansi
        $progress = WebdevProgress::with('tim.instansi')->get();

        // Mengembalikan data dalam format JSON
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => $progress
        ]);
    }


    public function show($id)
    {
        // Mencari data WebdevProgress berdasarkan ID, dengan relasi tim dan instansi
        $progress = WebdevProgress::with('tim.instansi')->find($id);

        // Jika data tidak ditemukan, kembalikan response error 404
        if (!$progress) {
            return response()->json([
                'code' => 404,
                'message' => 'error',
                'payload' => null
            ], 404);
        }

        // Jika data ditemukan, kembalikan dalam format JSON
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => $progress
        ]);
    }

    // Anda bisa menambahkan method lain seperti store, update, destroy di sini
}
