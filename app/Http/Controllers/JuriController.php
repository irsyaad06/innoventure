<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use Illuminate\Http\Request;

class JuriController extends Controller
{
    public function index()
    {
        $juris = Juri::select('nama', 'role','instansi')->get();

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => $juris
        ]);
    }
}
