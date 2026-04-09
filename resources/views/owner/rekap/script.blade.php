@push('scripts')
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#table-rekap').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('rekap.owner') }}",
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            dom: '<"flex flex-col md:flex-row justify-between mb-4"<"flex items-center gap-4"lB>f>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="ph-bold ph-file-xls mr-1"></i> Export Excel',
                    title: 'Laporan Rekap Transaksi Parkir'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="ph-bold ph-file-pdf mr-1"></i> Export PDF',
                    title: 'Laporan Rekap Transaksi Parkir',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ],
            columns: [
                { 
                    data: null, 
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'kendaraan.plat_nomor', name: 'kendaraan.plat_nomor' },
                { data: 'area.nama_area', name: 'area.nama_area' },
                { 
                    data: 'waktu_masuk', 
                    render: function(data) {
                        return new Date(data).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' });
                    }
                },
                { 
                    data: 'waktu_keluar',
                    render: function(data) {
                        return data ? new Date(data).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : '-';
                    }
                },
                { 
                    data: 'durasi_jam',
                    render: function(data) {
                        return data ? data + ' Jam' : '-';
                    }
                },
                { 
                    data: 'biaya_total',
                    render: function(data) {
                        return data ? 'Rp ' + new Intl.NumberFormat('id-ID').format(data) : 'Rp 0';
                    }
                },
                { data: 'user.nama_lengkap', name: 'user.nama_lengkap' }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Tidak ada data transaksi yang tersedia",
            }
        });

        $('#btn-filter').on('click', function() {
            table.ajax.reload();
        });
    });
</script>
@endpush
