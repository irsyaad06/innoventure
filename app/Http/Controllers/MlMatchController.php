<?php

namespace App\Http\Controllers;

use App\Models\MlMatch;

use Illuminate\Http\Request;

class MlMatchController extends Controller
{
    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => MlMatch::with(['tim1', 'tim2', 'winner'])->get()
        ]);
    }

    public function show($id)
    {
        $data = MlMatch::with(['tim1', 'tim2', 'winner'])->find($id);

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
