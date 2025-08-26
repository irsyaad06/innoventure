<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Http\Request;
// Hapus 'use Illuminate\Support\Facades\Auth;' karena tidak dipakai lagi
use Illuminate\Support\Facades\Log;

class PenilaianController extends Controller
{
    /**
     * Store a newly created or update an existing assessment in storage.
     */
    public function store(Request $request)
    {
        try {
            // PERUBAHAN 1: Tambahkan 'juri_id' di validasi
            $validated = $request->validate([
                'webdev_progress_id' => 'required|exists:webdev_progress,id',
                'aspek_penilaian_id' => 'required|exists:aspek_penilaians,id',
                'skor'               => 'required|integer|min:0|max:100',
                'juri_id'            => 'required|exists:users,id', // Validasi bahwa juri_id ada di tabel users
            ]);

            // PERUBAHAN 2: Hapus pengambilan Auth::id()

            $penilaian = Penilaian::updateOrCreate(
                [
                    'webdev_progress_id' => $validated['webdev_progress_id'],
                    'aspek_penilaian_id' => $validated['aspek_penilaian_id'],
                    // PERUBAHAN 3: Gunakan juri_id dari hasil validasi
                    'juri_id'            => $validated['juri_id'],
                ],
                [
                    'skor' => $validated['skor'],
                ]
            );

            return response()->json([
                'code' => 200,
                'message' => 'Skor berhasil disimpan.',
                'payload' => $penilaian,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan penilaian: ' . $e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    public function getScoresByJuri($progressId, $juriId)
    {
        $scores = Penilaian::where('webdev_progress_id', $progressId)
            ->where('juri_id', $juriId)
            ->get();

        // Mengubah format data agar mudah digunakan di Vue: { aspek_id: skor }
        $formattedScores = $scores->pluck('skor', 'aspek_penilaian_id');

        return response()->json([
            'code' => 200,
            'message' => 'Skor berhasil diambil.',
            'payload' => $formattedScores,
        ]);
    }
}
