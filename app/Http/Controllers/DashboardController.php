<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\AreaParkir;

class DashboardController extends Controller
{
    public function admin()
    {
        // Gather summary data for cards
        $totalKendaraan = Kendaraan::count();
        $totalUser = User::count();
        
        // Calculate estimated revenue
        $totalPendapatan = Transaksi::sum('biaya_total') ?? 0;
        
        // Calculate how many areas/slots are currently occupied
        $areaTerisi = AreaParkir::sum('terisi');

        // For the sake of the minimalist template demonstration, we will
        // use randomized or simulated data for the 7 days chart if DB is empty,
        // or you can query actual `waktu_masuk`.
        $chartCategories = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $chartSeries = [12, 19, 15, 25, 32, 45, 38];

        return view('admin.dashboard.index', compact(
            'totalKendaraan',
            'totalUser',
            'totalPendapatan',
            'areaTerisi',
            'chartCategories',
            'chartSeries'
        ));
    }

    public function petugas()
    {
        // For Petugas, maybe we show today's stats or simple counts
        $totalKendaraan = Kendaraan::count();
        $totalPendapatan = Transaksi::sum('biaya_total') ?? 0;
        $areaTerisi = AreaParkir::sum('terisi');
        $kapasitas = AreaParkir::sum('kapasitas');
        
        $sisaParkir = $kapasitas - $areaTerisi;

        return view('petugas.dashboard.index', compact(
            'totalKendaraan',
            'totalPendapatan',
            'areaTerisi',
            'sisaParkir'
        ));
    }
}
