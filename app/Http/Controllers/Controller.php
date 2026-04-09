<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function resolveDataTableLimit(Request $request, int $default = 200, int $max = 500): int
    {
        $limit = (int) $request->query('limit', $default);

        if ($limit < 10) {
            return 10;
        }

        return min($limit, $max);
    }

    protected function logAktivitas($pesan)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'id_user' => Auth::user()->id_user,
                'aktivitas' => $pesan,
                'waktu_aktivitas' => now(),
            ]);
        }
    }
}
