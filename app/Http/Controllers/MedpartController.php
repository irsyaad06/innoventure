<?php

namespace App\Http\Controllers;

use App\Models\External;
use Illuminate\Http\Request;

class MedpartController extends Controller
{
    /**
     * Get all active sponsors
     */
    public function getAllMedpartByType()
    {
        $medpart = External::where('jenis', 'medpart')
                            ->where('is_aktif', true)
                            ->get();

        return response()->json([
            'code'    => 200,
            'message' => 'success',
            'payload' => $medpart
        ]);
    }
    public function getMedpartById(int $id)
    {
        $medpart = External::where('jenis', 'medpart')
                           ->where('is_aktif', true)
                           ->find($id);
                           
        if (!$medpart) {
            return response()->json([
                'code'    => 404,
                'message' => 'Medpart tidak ditemukan atau tidak aktif',
                'payload' => null
            ], 404);
        }

        return response()->json([
            'code'    => 200,
            'message' => 'success',
            'payload' => $medpart
        ]);
    }
}

