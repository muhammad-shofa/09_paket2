<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        table = $('#transaksiTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('transaksi.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'id_parkir', name: 'id_parkir', className: 'text-slate-500 font-medium' },
                {
                    data: 'kendaraan',
                    name: 'kendaraan.plat_nomor',
                    render: function (data) {
                        if (!data) return '-';
                        return `<div class="font-bold tracking-wider text-slate-800">${data.plat_nomor}</div>
                                <div class="text-xs text-slate-400 capitalize">${data.jenis_kendaraan}</div>`;
                    }
                },
                {
                    data: 'area',
                    name: 'area.nama_area',
                    render: function (data) {
                        return data ? `<span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded-md text-sm font-semibold border border-indigo-100">${data.nama_area}</span>` : '-';
                    }
                },
                {
                    data: 'waktu_masuk',
                    name: 'waktu_masuk',
                    render: function (data) {
                        return new Date(data).toLocaleString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        if (data === 'masuk') return `<span class="bg-sky-50 text-sky-600 px-3 py-1 rounded-full text-xs font-bold border border-sky-100 flex inline-flex items-center gap-1"><span class="w-1.5 h-1.5 bg-sky-500 rounded-full animate-pulse"></span> Parkir</span>`;
                        return `<span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-xs font-bold border border-emerald-100 flex inline-flex items-center gap-1"><i class="ph-fill ph-check-circle"></i> Selesai</span>`;
                    }
                },
                {
                    data: 'biaya_total',
                    name: 'biaya_total',
                    className: 'text-right font-bold text-slate-800',
                    render: function (data) {
                        return data ? 'Rp ' + Number(data).toLocaleString('id-ID') : '-';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function (data, type, row) {
                        if (row.status === 'masuk') {
                            return `
                                <div class="flex items-center gap-2">
                                    <button onclick='prosesKeluar(${row.id_parkir})' class="px-3 py-1.5 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition-colors shadow-sm">
                                        Proses Keluar
                                    </button>
                                    <a href="/transaksi/karcis/${row.id_parkir}" target="_blank" class="px-3 py-1.5 text-sm bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-md font-medium transition-colors shadow-sm inline-flex items-center gap-1">
                                        <i class="ph-bold ph-ticket"></i> Karcis
                                    </a>
                                </div>
                            `;
                        } else {
                            return `
                                <a href="/transaksi/cetak/${row.id_parkir}" target="_blank" class="px-3 py-1.5 text-sm bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-md font-medium transition-colors shadow-sm inline-flex items-center gap-1">
                                    <i class="ph-bold ph-printer"></i> Struk
                                </a>
                            `;
                        }
                    }
                }
            ],
            language: {
                search: "Cari Transaksi:",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ transaksi",
                emptyTable: "Belum ada riwayat transaksi",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        $('#transaksiForm').on('submit', function (e) {
            e.preventDefault();
            let btn = $('#btnSave');
            let originalContent = btn.html();
            btn.prop('disabled', true).html('<i class="ph ph-spinner animate-spin"></i> Memproses...');

            $.ajax({
                url: "{{ route('transaksi.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (res) {
                    closeModal();
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Tercatat!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
                },
                error: function (err) {
                    let errors = err.responseJSON?.errors;
                    let msg = err.responseJSON?.message || 'Terjadi kesalahan sistem';
                    if (errors) msg = Object.values(errors)[0][0];
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                        customClass: { popup: 'rounded-2xl' }
                    });
                },
                complete: function () {
                    btn.prop('disabled', false).html(originalContent);
                }
            });
        });
    });

    function openModal() {
        $('#transaksiForm')[0].reset();
        let modal = document.getElementById('transaksiModal');
        let modalContainer = modal.querySelector('div.bg-white');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContainer.classList.remove('scale-95');
        }, 10);
    }

    function closeModal() {
        let modal = document.getElementById('transaksiModal');
        let modalContainer = modal.querySelector('div.bg-white');

        modal.classList.add('opacity-0');
        modalContainer.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function prosesKeluar(id) {
        Swal.fire({
            title: 'Selesaikan Parkir?',
            text: "Sistem akan otomatis menghitung durasi jam dan total biaya",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl text-slate-700' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/transaksi/' + id,
                    type: 'PUT',
                    success: function (res) {
                        table.ajax.reload(null, false);
                        let durasi = res.data.durasi;
                        let biaya = Number(res.data.biaya).toLocaleString('id-ID');

                        Swal.fire({
                            icon: 'success',
                            title: 'Invoice Terbit',
                            html: `<div class="text-left mt-4 text-sm bg-slate-50 p-4 rounded-xl border border-slate-100">
                                   <div class="flex justify-between mb-2"><span>Durasi Parkir:</span> <b>${durasi} Jam</b></div>
                                   <div class="flex justify-between text-indigo-700 text-lg"><span>Total Tagihan:</span> <b>Rp ${biaya}</b></div>
                                   </div>`,
                            confirmButtonText: 'Cetak Struk Sekarang',
                            showCancelButton: true,
                            cancelButtonText: 'Tutup',
                            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl mt-3', cancelButton: 'rounded-xl mt-3' }
                        }).then((result2) => {
                            if (result2.isConfirmed) {
                                window.open('/transaksi/cetak/' + id, '_blank');
                            }
                        });
                    },
                    error: function (err) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: err.responseJSON?.message || 'Server menolak operasi', customClass: { popup: 'rounded-2xl' } });
                    }
                });
            }
        });
    }
</script>