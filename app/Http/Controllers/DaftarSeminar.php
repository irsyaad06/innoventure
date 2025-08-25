<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarSeminar extends Controller
{
    public function createDaftarSeminar(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'nama'     => 'required|string|max:255',
        'instansi' => 'required|string|max:255',
        'email'    => 'required|email',
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
        'message' => 'Sponsor berhasil dibuat',
        'payload' => [
            'nama'       => $dseminar->nama,
            'instansi'   => $dseminar->instansi,
            'email'      => $dseminar->email,
            'no_hp'      => $dseminar->no_hp,
            'no_undian'  => $dseminar->no_undian,
            'kode_absen' => $dseminar->kode_absen, // ini bisa dipakai buat QR
        ]
    ], 201);
}

}
