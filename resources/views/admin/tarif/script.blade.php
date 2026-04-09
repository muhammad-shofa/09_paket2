<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;
    let mode = 'add';

    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        table = $('#tarifTable').DataTable({
            processing: true,
            serverSide: false, 
            ajax: {
                url: "{{ route('tarif.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'id_tarif', name: 'id_tarif' },
                { data: 'jenis_kendaraan', name: 'jenis_kendaraan', className: 'font-medium text-slate-800' },
                { 
                    data: 'tarif_per_jam', 
                    name: 'tarif_per_jam', 
                    className: 'text-slate-600',
                    render: function(data) {
                        return 'Rp ' + Number(data).toLocaleString('id-ID');
                    }
                },
                {
                    data: 'id_tarif',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="flex gap-2">
                                <button onclick='openModal("edit", ${JSON.stringify(row)})' class="p-2 text-indigo-500 bg-indigo-50 hover:bg-indigo-100 hover:text-indigo-600 rounded-md transition-colors shadow-sm">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </button>
                                <button onclick='deleteData(${data})' class="p-2 text-rose-500 bg-rose-50 hover:bg-rose-100 hover:text-rose-600 rounded-md transition-colors shadow-sm">
                                    <i class="ph-bold ph-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                emptyTable: "Belum ada data tarif",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        $('#tarifForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#id_tarif').val();
            let url = mode === 'add' ? "{{ route('tarif.store') }}" : "/tarif/" + id;
            let type = mode === 'add' ? "POST" : "PUT";

            let btn = $('#btnSave');
            let originalContent = btn.html();
            btn.prop('disabled', true).html('<i class="ph ph-spinner animate-spin"></i> Menyimpan...');

            $.ajax({
                url: url,
                type: type,
                data: $(this).serialize(),
                success: function(res) {
                    closeModal();
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
                },
                error: function(err) {
                    let errors = err.responseJSON?.errors;
                    let msg = err.responseJSON?.message || 'Terjadi kesalahan sistem';
                    if(errors) {
                        msg = Object.values(errors)[0][0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: msg,
                        customClass: { popup: 'rounded-2xl' }
                    });
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalContent);
                }
            });
        });
    });

    function openModal(action, data = null) {
        mode = action;
        $('#tarifForm')[0].reset();
        
        let modal = document.getElementById('tarifModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContainer.classList.remove('scale-95');
        }, 10);

        if (mode === 'add') {
            $('#modalTitle').text('Tambah Tarif Baru');
            $('#id_tarif').val('');
        } else {
            $('#modalTitle').text('Edit Data Tarif');
            $('#id_tarif').val(data.id_tarif);
            $('#jenis_kendaraan').val(data.jenis_kendaraan);
            $('#tarif_per_jam').val(Math.floor(data.tarif_per_jam));
        }
    }

    function closeModal() {
        let modal = document.getElementById('tarifModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.add('opacity-0');
        modalContainer.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function deleteData(id) {
        Swal.fire({
            title: 'Hapus Data Tarif?',
            text: "Pastikan tidak ada transaksi yang bermasalah jika tarif ini dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl text-slate-700' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/tarif/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        table.ajax.reload(null, false);
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false,
                            customClass: { popup: 'rounded-2xl' }
                        });
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: err.responseJSON?.message || 'Data gagal dihapus',
                            customClass: { popup: 'rounded-2xl' }
                        });
                    }
                });
            }
        });
    }
</script>
