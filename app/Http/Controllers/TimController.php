<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;

class TimController extends Controller
{
    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => Tim::with(['instansi', 'cabangLomba'])->get()
        ]);
    }

    public function show($id)
    {
        $data = Tim::with(['instansi', 'cabangLomba'])->find($id);

        if (!$data) {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found',
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
