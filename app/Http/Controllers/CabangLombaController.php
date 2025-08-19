<?php

namespace App\Http\Controllers;

use App\Models\CabangLomba;

use Illuminate\Http\Request;

class CabangLombaController extends Controller
{
    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => CabangLomba::all()
        ]);
    }

    public function show($id)
    {
        $data = CabangLomba::find($id);

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
