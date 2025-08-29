<?php

namespace App\Http\Controllers;

use App\Models\SayembaraProgress;
use Illuminate\Http\Request;

class SayembaraController extends Controller
{
    public function index(Request $request)
    {
        $juri = $request->user('sanctum');
        $allProgresses = SayembaraProgress::with(['tim.instansi'])->get();
        $sorted = $allProgresses->sortByDesc('total_skor');
        if ($juri) {
            $sorted->transform(function ($progress) use ($juri) {

                $progress->is_judged_by_current_user = $progress->isJudgingCompleteFor($juri);
                return $progress;
            });
        }
        return response()->json([
            'code' => 200,
            'message' => 'success',

            'payload' => $sorted->values()->all(),
        ]);
    }


    public function show($id)
    {
        // Mencari data SayembaraProgress berdasarkan ID, dengan relasi tim dan instansi
        $progress = SayembaraProgress::with('tim.instansi')->find($id);

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
}
