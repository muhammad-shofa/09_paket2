@extends('layouts.admin')

@section('title', 'Manajemen Kendaraan')
@section('header_title', 'Kendaraan Terdaftar')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-slate-800">Daftar Kendaraan Aktif</h3>
        <button onclick="openModal('add')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-indigo-100">
            <i class="ph-bold ph-car-profile"></i> Tambah Kendaraan
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="kendaraanTable" class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tl-xl w-10">ID</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Plat Nomor</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Jenis</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Warna</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Pemilik</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tr-xl w-24">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('admin.kendaraan.modal')

@endsection

@push('css')
    @include('admin.kendaraan.style')
@endpush

@push('scripts')
    @include('admin.kendaraan.script')
@endpush
