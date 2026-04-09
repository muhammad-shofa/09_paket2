@extends('layouts.admin')

@section('title', 'Owner Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <i class="ph-bold ph-money text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <i class="ph-bold ph-swap text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalTransaksi) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                    <i class="ph-bold ph-car text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Kendaraan Terparkir</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $areaTerisi }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <i class="ph-bold ph-stack text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Kapasitas Area</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $kapasitasTotal }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chart -->
    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-slate-800">Pendapatan 7 Hari Terakhir</h2>
            <div class="p-2 bg-slate-50 rounded-lg">
                <i class="ph ph-chart-line-up text-slate-500"></i>
            </div>
        </div>
        <div id="revenueChart"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [{
                name: 'Pendapatan (Rp)',
                data: {!! json_encode($chartSeries) !!}
            }],
            chart: {
                type: 'area',
                height: 350,
                fontFamily: 'Outfit, sans-serif',
                toolbar: { show: false }
            },
            colors: ['#4f46e5'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1, stops: [0, 100] }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: { categories: {!! json_encode($chartCategories) !!} },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
        chart.render();
    });
</script>
@endpush
