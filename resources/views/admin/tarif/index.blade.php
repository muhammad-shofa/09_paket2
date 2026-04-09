@extends('layouts.admin')

@section('title', 'Manajemen Tarif Parkir')
@section('header_title', 'Manajemen Tarif')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-slate-800">Daftar Tarif Parkir Kendaraan</h3>
        <button onclick="openModal('add')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-indigo-100">
            <i class="ph-bold ph-plus"></i> Tambah Tarif
        </button>
    </div>

    <div class="overflow-x-auto">
        <table id="tarifTable" class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tl-xl w-10">ID</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Jenis Kendaraan</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Tarif per Jam</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tr-xl w-24">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include('admin.tarif.modal')

@endsection

@push('css')
    @include('admin.tarif.style')
@endpush

@push('scripts')
    @include('admin.tarif.script')
@endpush
