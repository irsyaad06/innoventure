<?php

namespace App\Http\Controllers;

use App\Models\Instansi;

use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => Instansi::all()
        ]);
    }

    public function show($id)
    {
        $data = Instansi::find($id);

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
