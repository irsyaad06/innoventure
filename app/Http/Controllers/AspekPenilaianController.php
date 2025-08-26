<?php

namespace App\Http\Controllers;

use App\Models\AspekPenilaian;
use Illuminate\Http\Request;

class AspekPenilaianController extends Controller
{
    /**
     * Menampilkan semua aspek penilaian berdasarkan id_cabang_lomba
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function aspekPenilaianByCabangLomba($id)
    {
        $aspek = AspekPenilaian::with('cabangLomba')
            ->where('id_cabang_lomba', $id)
            ->get();

        if ($aspek->isEmpty()) {
            return response()->json([
                'code' => 404,
                'message' => 'Aspek penilaian tidak ditemukan untuk cabang lomba ini',
                'payload' => [],
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => $aspek,
        ]);
    }
}
