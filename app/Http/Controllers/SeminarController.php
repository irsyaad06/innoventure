<?php

namespace App\Http\Controllers;

use App\Models\Seminar; // Pastikan Anda mengimpor Model Seminar
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

      public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'payload' => Seminar::all()
        ]);
    }
}