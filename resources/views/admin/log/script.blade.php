<script>
    $(document).ready(function () {
        $('#logTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('log.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'id_log', name: 'id_log', className: 'text-slate-500' },
                {
                    data: 'user',
                    name: 'user.nama_lengkap',
                    render: function (data) {
                        if (data) {
                            return `<div class="font-medium text-slate-800">${data.nama_lengkap}</div><div class="text-xs text-indigo-500">${data.role}</div>`;
                        }
                        return '<span class="text-slate-400 italic">User Dihapus</span>';
                    }
                },
                { data: 'aktivitas', name: 'aktivitas', className: 'font-medium text-slate-700' },
                {
                    data: 'waktu_aktivitas',
                    name: 'waktu_aktivitas',
                    render: function (data) {
                        let d = new Date(data);
                        return d.toLocaleString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                    }
                }
            ],
            order: [[0, 'desc']], // Sort by ID Descending
            language: {
                search: "Cari Log:",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ catatan",
                emptyTable: "Belum ada rekaman aktivitas sistem",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });
    });
</script>