<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function track(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|numeric'
        ]);

        $id_parkir = (int) $request->ticket_id;

        $transaksi = Transaksi::with(['kendaraan', 'area', 'tarif'])->find($id_parkir);

        if (!$transaksi) {
            return response()->json(['status' => false, 'message' => 'Tiket tidak ditemukan!'], 404);
        }

        $durasi_jam = $transaksi->durasi_jam;
        $biaya_total = $transaksi->biaya_total;

        // Jika masih 'masuk', hitung estimasi
        if ($transaksi->status === 'masuk') {
            $waktu_masuk = Carbon::parse($transaksi->waktu_masuk);
            $sekarang = now();
            $durasi_menit = $sekarang->diffInMinutes($waktu_masuk);
            $durasi_jam = ceil($durasi_menit / 60);
            if ($durasi_jam < 1) $durasi_jam = 1;

            $biaya_total = $durasi_jam * $transaksi->tarif->tarif_per_jam;
        }

        return response()->json([
            'status' => true,
            'data' => [
                'no_tiket' => str_pad($transaksi->id_parkir, 6, '0', STR_PAD_LEFT),
                'plat_nomor' => $transaksi->kendaraan->plat_nomor,
                'area' => $transaksi->area->nama_area,
                'waktu_masuk' => Carbon::parse($transaksi->waktu_masuk)->format('d-M-Y H:i'),
                'waktu_keluar' => $transaksi->status === 'keluar' ? Carbon::parse($transaksi->waktu_keluar)->format('d-M-Y H:i') : '-',
                'status' => $transaksi->status,
                'durasi_jam' => $durasi_jam,
                'biaya_estimasi' => number_format($biaya_total, 0, ',', '.')
            ]
        ]);
    }
}
