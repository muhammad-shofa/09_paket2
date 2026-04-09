@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard Overview')

@section('content')

<!-- Statistic Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    <!-- Card 1 -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Kendaraan</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalKendaraan) }}</h3>
            <p class="text-xs text-emerald-500 font-medium mt-2 flex items-center gap-1">
                <i class="ph-bold ph-trend-up"></i> +4.5% minggu ini
            </p>
        </div>
        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl">
            <i class="ph-fill ph-car"></i>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Pendapatan</p>
            <h3 class="text-3xl font-bold text-slate-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-500 font-medium mt-2 flex items-center gap-1">
                <i class="ph-bold ph-trend-up"></i> +12.3% bulan ini
            </p>
        </div>
        <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-3xl">
            <i class="ph-fill ph-wallet"></i>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Kapasitas Terisi</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $areaTerisi }}</h3>
            <p class="text-xs text-rose-500 font-medium mt-2 flex items-center gap-1">
                <i class="ph-bold ph-trend-down"></i> -2% rata-rata
            </p>
        </div>
        <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center text-3xl">
            <i class="ph-fill ph-map-pin"></i>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Pengguna</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalUser) }}</h3>
            <p class="text-xs text-slate-400 font-medium mt-2 flex items-center gap-1">
                User aktif di sistem
            </p>
        </div>
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-3xl">
            <i class="ph-fill ph-users"></i>
        </div>
    </div>
</div>

<!-- Chart Area -->
<div class="mt-8 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-slate-800">Aktivitas Parkir Mingguan</h3>
        <button class="p-2 text-slate-400 hover:bg-slate-50 rounded-lg transition-colors">
            <i class="ph ph-dots-three-outline-vertical text-xl"></i>
        </button>
    </div>
    <!-- ApexChart Container -->
    <div id="mainChart" class="w-full h-80"></div>
</div>

@endsection

@push('css')
    @include('admin.dashboard.style')
@endpush

@push('scripts')
    @include('admin.dashboard.script')
@endpush
