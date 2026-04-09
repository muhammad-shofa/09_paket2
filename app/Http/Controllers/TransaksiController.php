<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $transaksi = Transaksi::with(['user', 'kendaraan', 'tarif', 'area'])->orderBy('id_parkir', 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $transaksi,
            ], 200);
        }

        $areas = AreaParkir::whereRaw('terisi < kapasitas')->get();
        $tarifs = Tarif::all();

        return view('petugas.transaksi.index', compact('areas', 'tarifs'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'plat_nomor' => 'required',
                'id_area' => 'required|exists:tb_area_parkir,id_area',
                'id_tarif' => 'required|exists:tb_tarif,id_tarif'
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => "Validation failed", 'errors' => $validator->errors()], 422);
            }

            // Check if kendaraan exists, otherwise auto-create
            $plat_nomor = strtoupper(trim($request->plat_nomor));
            $kendaraan = Kendaraan::where('plat_nomor', $plat_nomor)->first();

            if (!$kendaraan) {
                // Auto create real vehicle as requested by Petugas
                $jenis = $request->jenis_kendaraan ?? 'Lainnya';
                $warna = $request->warna ?? 'Tidak Diketahui';
                $pemilik = $request->pemilik ?? 'Anonim';

                $kendaraan = Kendaraan::create([
                    'id_user' => Auth::id() ?? 1,
                    'plat_nomor' => $plat_nomor,
                    'jenis_kendaraan' => $jenis,
                    'warna' => $warna,
                    'pemilik' => $pemilik
                ]);
            } else {
                // Optionally update vehicle info if they provided edits? Let Petugas just use what's found.
            }

            // Check area capacity
            $area = AreaParkir::find($request->id_area);
            if ($area->terisi >= $area->kapasitas) {
                return response()->json(['status' => false, 'message' => 'Area parkir sudah penuh!'], 400);
            }

            // Create Transaction
            $trans = Transaksi::create([
                'id_user' => Auth::id() ?? 1,
                'id_kendaraan' => $kendaraan->id_kendaraan,
                'id_tarif' => $request->id_tarif,
                'id_area' => $area->id_area,
                'waktu_masuk' => now(),
                'status' => 'masuk'
            ]);

            // Update Area Terisi
            $area->increment('terisi');

            $this->logAktivitas("Mencatat Kendaraan Masuk: Plat " . $kendaraan->plat_nomor);

            return response()->json(['status' => true, 'message' => 'Kendaraan berhasil terdaftar masuk!', 'data' => $trans], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => "System error: " . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id_parkir)
    {
        try {
            $transaksi = Transaksi::with(['tarif', 'area', 'kendaraan'])->find($id_parkir);

            if (!$transaksi || $transaksi->status == 'keluar') {
                return response()->json(['status' => false, 'message' => "Data tidak valid atau kendaraan sudah keluar."], 400);
            }

            $waktu_masuk = Carbon::parse($transaksi->waktu_masuk);
            $waktu_keluar = now();

            // Calculate hours (ceil)
            $durasi_menit = $waktu_keluar->diffInMinutes($waktu_masuk);
            $durasi_jam = ceil($durasi_menit / 60);
            if ($durasi_jam < 1)
                $durasi_jam = 1;

            $biaya_total = $durasi_jam * $transaksi->tarif->tarif_per_jam;

            // Update Transaction
            $transaksi->update([
                'waktu_keluar' => $waktu_keluar,
                'durasi_jam' => $durasi_jam,
                'biaya_total' => $biaya_total,
                'status' => 'keluar'
            ]);

            // Decrease Area Terisi
            if ($transaksi->area && $transaksi->area->terisi > 0) {
                $transaksi->area->decrement('terisi');
            }

            $this->logAktivitas("Mencatat Kendaraan Keluar: Plat " . $transaksi->kendaraan->plat_nomor . " dengan biaya Rp " . number_format($biaya_total, 0, ',', '.'));

            return response()->json([
                'status' => true,
                'message' => 'Kendaraan berhasil dicatat keluar.',
                'data' => [
                    'durasi' => $durasi_jam,
                    'biaya' => $biaya_total
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => "System error: " . $e->getMessage()], 500);
        }
    }

    public function cetakStruk($id_parkir)
    {
        $transaksi = Transaksi::with(['user', 'kendaraan', 'tarif', 'area'])->findOrFail($id_parkir);
        return view('petugas.transaksi.struk', compact('transaksi'));
    }

    public function cetakKarcis($id_parkir)
    {
        $transaksi = Transaksi::with(['user', 'kendaraan', 'tarif', 'area'])->findOrFail($id_parkir);
        return view('petugas.transaksi.karcis', compact('transaksi'));
    }
}
