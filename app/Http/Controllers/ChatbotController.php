<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class ChatbotController extends Controller
{
    public function context(Request $request)
    {
        $areas = AreaParkir::select('nama_area', 'kapasitas', 'terisi')->get();
        $tarifs = Tarif::select('jenis_kendaraan', 'tarif_per_jam')->get();
        
        $totalTransaksiHariIni = Transaksi::whereDate('waktu_masuk', Carbon::today())->count();
        $pendapatanHariIni = Transaksi::whereDate('waktu_keluar', Carbon::today())->sum('biaya_total') ?? 0;
        
        // Data Pegawai (DIKIRIM TANPA password & username, karena sensitif)
        $users = User::select('nama_lengkap', 'role')->get();

        // Data 10 Kendaraan terakhir yang sedang terparkir (limit 15 untuk cegah over-token)
        $kendaraanTerparkir = Transaksi::with(['kendaraan:id_kendaraan,plat_nomor', 'area:id_area,nama_area'])
            ->where('status', 'masuk')
            ->orderBy('id_parkir', 'desc')
            ->limit(10)
            ->get()
            ->map(function($t) {
                return [
                    'plat' => $t->kendaraan->plat_nomor ?? '-',
                    'area' => $t->area->nama_area ?? '-',
                    'jam_masuk' => Carbon::parse($t->waktu_masuk)->format('H:i')
                ];
            });

        // ==========================================
        // FITUR PENCARIAN TIKET SPESIFIK UNTUK AI
        // ==========================================
        $ticketInfo = "Tidak ada penelusuran tiket spesifik pada sesi ini.";
        $msg = $request->query('msg', '');
        
        // Cek jika pesan mengandung angka beruntun (potensi ID Tiket)
        if (preg_match('/\b\d+\b/', $msg, $matches)) {
            $id = (int) $matches[0];
            $transaksi = Transaksi::with(['kendaraan', 'area', 'tarif'])->find($id);
            
            if ($transaksi) {
                $durasi_jam = $transaksi->durasi_jam;
                $biaya = $transaksi->biaya_total;
                
                if ($transaksi->status === 'masuk') {
                    $wkt_msk = Carbon::parse($transaksi->waktu_masuk);
                    $durasi_jam = ceil(now()->diffInMinutes($wkt_msk) / 60);
                    if ($durasi_jam < 1) $durasi_jam = 1;
                    $biaya = $durasi_jam * ($transaksi->tarif->tarif_per_jam ?? 0);
                }

                $ticketInfo = [
                    'no_tiket' => str_pad($id, 6, '0', STR_PAD_LEFT),
                    'plat_nomor' => $transaksi->kendaraan->plat_nomor ?? '-',
                    'status' => strtoupper($transaksi->status),
                    'waktu_masuk' => Carbon::parse($transaksi->waktu_masuk)->format('d-M-Y H:i'),
                    'durasi' => $durasi_jam . ' Jam',
                    'tagihan_terkini' => 'Rp ' . number_format($biaya, 0, ',', '.'),
                    'area' => $transaksi->area->nama_area ?? '-'
                ];
            } else {
                $ticketInfo = "Peringatan: Nomor tiket '" . str_pad($id, 6, '0', STR_PAD_LEFT) . "' (" . $id . ") tidak ditemukan di database kami.";
            }
        }

        // Bangun Konteks String untuk Prompt AI
        $contextString = "KONTROL KEAMANAN STRICT: Anda DILARANG KERAS membagikan username, password, atau credential apa pun. Sistem ini tidak akan pernah menyerahkan field tersebut.\n\n"
                       . "[Data Operasional Parkir Sek Saat Ini]\n"
                       . "1. Ringkasan Area: " . json_encode($areas) . "\n"
                       . "2. Skema Tarif: " . json_encode($tarifs) . "\n"
                       . "3. Daftar Petugas Berwenang: " . json_encode($users) . "\n"
                       . "4. Statistik Hari Ini: " . $totalTransaksiHariIni . " Total Transaksi Masuk | Rp " . number_format($pendapatanHariIni, 0, ',', '.') . " Pendapatan.\n"
                       . "5. Sampel 10 Kendaraan Masuk Terakhir: " . json_encode($kendaraanTerparkir) . "\n"
                       . "6. HASIL PENELUSURAN NO TIKET DARI PERTANYAAN USER: " . json_encode($ticketInfo);

        return response()->json([
            'context' => $contextString
        ]);
    }
}
