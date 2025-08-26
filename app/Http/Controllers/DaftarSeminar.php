<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;


class DaftarSeminar extends Controller
{
    public function createDaftarSeminar(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama'     => 'required|string|max:255',
                'instansi' => 'required|string|max:255',
                'email'    => 'required|email|unique:daftar_seminars,email',
                'no_hp'    => 'required|string|max:20',
            ]);

            // Generate no_undian
            $tahun = date('Y');
            $randomNumber = rand(1000, 9999);
            $noUndian = "INNOVENTURE-{$tahun}{$randomNumber}";

            // Generate kode_absen (random 8 karakter unik)
            $kodeAbsen = strtoupper(substr(md5(uniqid()), 0, 8));

            // Simpan ke database
            $dseminar = \App\Models\DaftarSeminar::create([
                'nama'       => $validated['nama'],
                'instansi'   => $validated['instansi'],
                'email'      => $validated['email'],
                'no_hp'      => $validated['no_hp'],
                'no_undian'  => $noUndian,
                'kode_absen' => $kodeAbsen,
            ]);

            return response()->json([
                'code'    => 201,
                'message' => 'Berhasil Daftar Seminar',
                'payload' => [
                    'nama'       => $dseminar->nama,
                    'instansi'   => $dseminar->instansi,
                    'email'      => $dseminar->email,
                    'no_hp'      => $dseminar->no_hp,
                    'no_undian'  => $dseminar->no_undian,
                    'kode_absen' => $dseminar->kode_absen,
                ]
            ], 201);
        } catch (ValidationException $e) {
            // Tangani kegagalan validasi (misal: email sudah terdaftar)
            return response()->json([
                'code'    => 422,
                'message' => 'Validasi Gagal',
                'errors'  => $e->errors()
            ], 422);
        } catch (Exception $e) {
            // Tangani kesalahan server umum (misal: gagal koneksi database)
            Log::error('Gagal membuat data seminar: ' . $e->getMessage());
            return response()->json([
                'code'    => 500,
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'
            ], 500);
        }
    }

    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => \App\Models\DaftarSeminar::all()
        ]);
    }

    public function showByAbsen($kode_absen) // Ganti parameter menjadi $kode_absen
{
    // Cari pendaftar berdasarkan kolom 'kode_absen'
    $data = \App\Models\DaftarSeminar::where('kode_absen', $kode_absen)->first();

    if (!$data) {
        return response()->json([
            'code' => 404,
            'message' => 'Data pendaftar dengan kode tersebut tidak ditemukan.',
            'payload' => null
        ], 404);
    }

    return response()->json([
        'code' => 200,
        'message' => 'success',
        'payload' => $data
    ]);
}
}
