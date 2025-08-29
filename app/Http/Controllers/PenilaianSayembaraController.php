<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\PenilaianSayembara;
use App\Models\SayembaraProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenilaianSayembaraController extends Controller
{
    /**
     * Menyimpan atau memperbarui beberapa skor sekaligus untuk satu karya sayembara.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request)
    {
        // 1. Validasi data yang masuk dari frontend
        $validator = Validator::make($request->all(), [
            'sayembara_progress_id' => 'required|integer|exists:sayembara_progress,id',
            'juri_id'               => 'required|integer|exists:juris,id',
            'scores'                => 'required|array',
            'scores.*.aspek_id'     => 'required|integer|exists:aspek_penilaians,id',
            'scores.*.skor'         => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $progressId = $validated['sayembara_progress_id'];
        $juriId = $validated['juri_id'];
        $scores = $validated['scores'];

        // 2. Otorisasi: Pastikan juri yang menilai memang ditugaskan untuk aspek tersebut
        try {
            $juri = Juri::findOrFail($juriId);
            $assignedAspectIds = $juri->aspekPenilaians()->pluck('id')->toArray();

            foreach ($scores as $score) {
                if (!in_array($score['aspek_id'], $assignedAspectIds)) {
                    return response()->json(['message' => 'Akses ditolak. Anda tidak ditugaskan untuk menilai salah satu aspek yang dikirim.'], 403);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Juri tidak ditemukan.'], 404);
        }


        // 3. Proses penyimpanan data menggunakan database transaction
        DB::beginTransaction();
        try {
            foreach ($scores as $scoreData) {
                PenilaianSayembara::updateOrCreate(
                    // Kunci untuk mencari record yang sudah ada
                    [
                        'sayembara_progress_id' => $progressId,
                        'aspek_penilaian_id'    => $scoreData['aspek_id'],
                        'juri_id'               => $juriId,
                    ],
                    // Data yang akan di-update atau di-create
                    [
                        'skor' => $scoreData['skor'],
                    ]
                );
            }
            DB::commit(); // Jika semua berhasil, simpan perubahan
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada satu saja yang gagal, batalkan semua
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan skor.',
                'error' => $e->getMessage(),
            ], 500);
        }

        // 4. Berikan respons sukses
        return response()->json([
            'code' => 200,
            'message' => 'Semua skor berhasil disimpan.',
        ]);
    }

    public function show(SayembaraProgress $sayembaraProgress)
    {
        // muat juga relasi 'juri' dan 'aspekPenilaian' agar data lengkap di frontend.
        $penilaians = $sayembaraProgress->penilaians()->with(['juri', 'aspekPenilaian'])->get();

        return response()->json([
            'code'    => 200,
            'message' => 'success',
            'payload' => $penilaians,
        ]);
    }

    public function getScoresByJuri($progressId, $juriId)
    {
        $scores = PenilaianSayembara::where('sayembara_progress_id', $progressId)
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
