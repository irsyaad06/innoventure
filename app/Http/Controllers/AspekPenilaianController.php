<?php

namespace App\Http\Controllers;

use App\Models\AspekPenilaian;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class AspekPenilaianController extends Controller
{
    /**
     * Menampilkan semua aspek penilaian berdasarkan id_cabang_lomba
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function aspekPenilaianByCabangLomba($cabangLombaId, $progressId)
    {
        // Ambil semua aspek penilaian berdasarkan ID cabang lomba
        $aspek = AspekPenilaian::with('cabangLomba')
            ->where('id_cabang_lomba', $cabangLombaId)
            ->get();

        if ($aspek->isEmpty()) {
            return response()->json([
                'code' => 404,
                'message' => 'Aspek penilaian tidak ditemukan untuk cabang lomba ini',
                'payload' => [],
            ], 404);
        }

        // Ambil skor untuk progressId yang diberikan, ubah format menjadi key-value
        $scores = Penilaian::where('webdev_progress_id', $progressId)
            ->pluck('skor', 'aspek_penilaian_id');

        // Gabungkan data skor ke dalam setiap objek aspek penilaian
        $aspekWithScores = $aspek->map(function ($item) use ($scores) {
            // Cek apakah skor untuk aspek ini ada, jika tidak, default ke 0
            $item->skor = $scores->get($item->id, 0);
            return $item;
        });

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => $aspekWithScores,
        ]);
    }
}
