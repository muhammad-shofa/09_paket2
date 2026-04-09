@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('header_title', 'Catatan Aktivitas Sistem')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-slate-800">Riwayat Operasional</h3>
    </div>

    <div class="overflow-x-auto">
        <table id="logTable" class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tl-xl w-10">ID</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Petugas / User</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50">Deskripsi Aktivitas</th>
                    <th class="border-b-2 p-3 font-semibold text-slate-600 bg-slate-50 rounded-tr-xl">Waktu</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection

@push('css')
    @include('admin.log.style')
@endpush

@push('scripts')
    @include('admin.log.script')
@endpush
