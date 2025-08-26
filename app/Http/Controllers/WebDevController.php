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

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tim_id'          => 'required|exists:tims,id',
            'email_ketua'     => 'required|email|unique:webdev_progress,email_ketua',
            'judul_proyek'    => 'required|string|max:255',
            'deskripsi_pdf'   => 'required',
            'link_repository' => 'nullable|url',
            'link_demo'       => 'nullable|url',
            'link_hosting'    => 'nullable|url',
            'ppt'             => 'nullable',
        ]);

        // Upload PDF
        if ($request->hasFile('deskripsi_pdf')) {
            $validated['deskripsi_pdf'] = $request->file('deskripsi_pdf')->store('deskripsi_pdf', 'public');
        }

        // Upload PPT jika ada
        if ($request->hasFile('ppt')) {
            $validated['ppt'] = $request->file('ppt')->store('ppt', 'public');
        }

        // Simpan ke DB
        $progress = WebdevProgress::create($validated);

        return response()->json([
            'code' => 201,
            'message' => 'Data berhasil disimpan',
            'payload' => $progress->load('tim.instansi')
        ], 201);
    }

    
}
