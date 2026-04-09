@extends('layouts.admin')

@section('title', 'Transaksi Parkir')
@section('header_title', 'Sistem Loket Parkir')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-slate-800">Riwayat & Proses Kendaraan</h3>
        <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-indigo-100">
            <i class="ph-bold ph-plus-circle"></i> Catat Kendaraan Masuk
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="transaksiTable" class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tl-xl w-10">ID</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Plat Nomor</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Area</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Waktu Masuk</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Status</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 text-right">Biaya (Rp)</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('petugas.transaksi.modal')

@endsection

@push('css')
    @include('petugas.transaksi.style')
@endpush

@push('scripts')
    @include('petugas.transaksi.script')
@endpush
