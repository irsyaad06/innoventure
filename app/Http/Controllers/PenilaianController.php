<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\WebdevProgress;
use Illuminate\Support\Facades\Validator;
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
                'juri_id'            => 'required|exists:juris,id', // Validasi bahwa juri_id ada di tabel 
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

    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => Penilaian::all()
        ]);
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
    public function getScoresByProgress($progressId)
    {
        $scores = Penilaian::where('webdev_progress_id', $progressId)->get();

        // Mengubah format data agar mudah digunakan di Vue: { aspek_id: skor }
        $hasilKarya
            = $scores->pluck('skor', 'aspek_penilaian_id');

        return response()->json([
            'code' => 200,
            'message' => 'Skor berhasil diambil.',
            'payload' => $hasilKarya,
        ]);
    }
    public function getAverageScores($progressId)
    {
        $penilaians = Penilaian::where('webdev_progress_id', $progressId)
            ->with('aspekPenilaian')
            ->get();

        // Mengelompokkan berdasarkan aspek penilaian
        $scoresByAspek = $penilaians->groupBy('aspek_penilaian_id');

        $averageScores = [];

        // Hitung rata-rata untuk setiap aspek
        foreach ($scoresByAspek as $aspekId => $scores) {
            if ($scores->count() > 0) {
                $averageScores[$aspekId] = $scores->avg('skor');
            }
        }

        return response()->json([
            'code' => 200,
            'message' => 'Skor rata-rata berhasil diambil.',
            'payload' => $averageScores,
        ]);
    }
    public function updateCatatanJuri(Request $request)
    {
        // 1. Validasi input, pastikan tim_id dan catatan ada
        $validator = Validator::make($request->all(), [
            'tim_id'  => 'required|integer|exists:tims,id',
            'catatan' => 'nullable|string', // nullable agar catatan bisa dikosongkan
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $progress = WebdevProgress::updateOrCreate(
                ['tim_id' => $request->input('tim_id')],
                ['catatan' => $request->input('catatan')]
            );

            return response()->json([
                'message' => 'Catatan juri berhasil disimpan.',
                'data'    => $progress
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
