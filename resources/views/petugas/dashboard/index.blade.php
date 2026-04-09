@extends('layouts.admin')

@section('title', 'Dashboard Petugas')
@section('header_title', 'Petugas Parkir')

@section('content')
    <!-- Welcome Alert -->
    <div class="mb-8 bg-indigo-600 rounded-3xl p-8 text-white shadow-lg shadow-indigo-200 relative overflow-hidden">
        <div class="relative z-10 w-full md:w-2/3">
            <h2 class="text-3xl font-bold mb-2">Selamat Bertugas, {{ auth()->user()->nama_lengkap ?? 'Petugas' }}! 👋</h2>
            <p class="text-indigo-100 mb-6">Sistem mencatat aktivitas parkir secara real-time. Pastikan Anda memeriksa ulang
                data kendaraan saat melakukan transaksi parkir hari ini.</p>
            <div class="flex gap-4">
                <a href="{{ route('transaksi.index') }}"
                    class="bg-white text-indigo-600 px-5 py-2.5 rounded-xl font-bold shadow-md hover:bg-slate-50 transition-colors flex items-center gap-2">
                    <i class="ph-bold ph-plus-circle"></i> Transaksi Baru
                </a>
            </div>
        </div>
        <div class="absolute right-0 top-0 w-1/3 h-full opacity-20 pointer-events-none">
            <i class="ph-fill ph-car-profile text-[200px] absolute -right-10 -bottom-10 mix-blend-overlay"></i>
        </div>
    </div>

    <!-- Statistic Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:-translate-y-1 transition-transform">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Kendaraan</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalKendaraan ?? 0) }}</h3>
                <p class="text-xs text-slate-400 font-medium mt-2">Dalam sistem</p>
            </div>
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl">
                <i class="ph-fill ph-car"></i>
            </div>
        </div>

        <!-- Card 2 -->
        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:-translate-y-1 transition-transform">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Pendapatan Total</p>
                <h3 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-slate-400 font-medium mt-2">Dari seluruh transaksi</p>
            </div>
            <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-3xl">
                <i class="ph-fill ph-money"></i>
            </div>
        </div>

        <!-- Card 3 -->
        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:-translate-y-1 transition-transform">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Slot Terisi</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $areaTerisi ?? 0 }}</h3>
                <p class="text-xs text-slate-400 font-medium mt-2">Kapasitas digunakan</p>
            </div>
            <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-3xl">
                <i class="ph-fill ph-parking-circle"></i>
            </div>
        </div>

        <!-- Card 4 -->
        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:-translate-y-1 transition-transform">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Sisa Slot</p>
                <h3 class="text-3xl font-bold text-slate-800">{{ $sisaParkir ?? 0 }}</h3>
                <p class="text-xs text-slate-400 font-medium mt-2">Tersedia saat ini</p>
            </div>
            <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center text-3xl">
                <i class="ph-fill ph-empty"></i>
            </div>
        </div>
    </div>
@endsection