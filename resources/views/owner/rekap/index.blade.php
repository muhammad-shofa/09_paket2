@extends('layouts.admin')

@section('title', 'Rekap Transaksi')
@section('header_title', 'Rekap Transaksi')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<style>
    .dt-buttons .dt-button {
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        color: #475569;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .dt-buttons .dt-button:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }
</style>
@endpush

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
        <h2 class="text-lg font-bold text-slate-800">Filter & Laporan Transaksi</h2>
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2">
                <label class="text-sm text-slate-500">Mulai:</label>
                <input type="date" id="start_date" class="border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-slate-500">Sampai:</label>
                <input type="date" id="end_date" class="border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-indigo-500">
            </div>
            <button id="btn-filter" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
                Terapkan Filter
            </button>
        </div>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table id="table-rekap" class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tl-xl">No</th>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Plat Nomor</th>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Area</th>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Waktu Masuk</th>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Waktu Keluar</th>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Durasi</th>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Biaya</th>
                        <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tr-xl">Petugas</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <!-- AJAX Data -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@include('owner.rekap.script')
