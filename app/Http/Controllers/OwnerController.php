<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\AreaParkir;
use App\Models\Tarif;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $totalPendapatan = Transaksi::sum('biaya_total') ?? 0;
        $totalTransaksi = Transaksi::count();
        $areaTerisi = AreaParkir::sum('terisi');
        $kapasitasTotal = AreaParkir::sum('kapasitas');
        
        // Get revenue for last 7 days
        $chartCategories = [];
        $chartSeries = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartCategories[] = $date->format('d M');
            $dailyRevenue = Transaksi::whereDate('waktu_keluar', $date)->sum('biaya_total') ?? 0;
            $chartSeries[] = $dailyRevenue;
        }

        return view('owner.dashboard.index', compact('totalPendapatan', 'totalTransaksi', 'areaTerisi', 'kapasitasTotal', 'chartCategories', 'chartSeries'));
    }

    public function rekap(Request $request)
    {
        if ($request->ajax()) {
            $query = Transaksi::with(['user', 'kendaraan', 'tarif', 'area'])->whereNotNull('waktu_keluar');
            
            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('waktu_keluar', '>=', $request->start_date);
            }
            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('waktu_keluar', '<=', $request->end_date);
            }

            $data = $query->orderBy('waktu_keluar', 'desc')->get();
            return response()->json(['data' => $data]);
        }

        return view('owner.rekap.index');
    }
}
