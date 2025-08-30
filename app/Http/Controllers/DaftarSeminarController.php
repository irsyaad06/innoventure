<?php

namespace App\Http\Controllers;

use App\Models\DaftarSeminar;
use Illuminate\Http\Request;

class DaftarSeminarController extends Controller
{
    public function getUndianData()
    {
        $peserta = DaftarSeminar::whereNotNull('no_undian')
            ->select('nama', 'no_undian')
            ->get();

        return response()->json($peserta);
    }
}
