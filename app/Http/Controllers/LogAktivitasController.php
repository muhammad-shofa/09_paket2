<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $logs = LogAktivitas::with('user')
                ->orderBy('id_log', 'desc')
                ->limit(100) 
                ->get();

            return response()->json([
                'status' => true,
                'data' => $logs
            ]);
        }
        return view('admin.log.index');
    }
}