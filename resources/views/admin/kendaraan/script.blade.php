<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;
    let mode = 'add';

    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        table = $('#kendaraanTable').DataTable({
            processing: true,
            serverSide: false, 
            ajax: {
                url: "{{ route('kendaraan.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'id_kendaraan', name: 'id_kendaraan' },
                { 
                    data: 'plat_nomor', 
                    name: 'plat_nomor', 
                    render: function(data){
                        return `<span class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-3 py-1 rounded-md font-bold tracking-widest">${data.toUpperCase()}</span>`;
                    }
                },
                { data: 'jenis_kendaraan', name: 'jenis_kendaraan', className: 'font-medium text-slate-700' },
                { data: 'warna', name: 'warna' },
                { data: 'pemilik', name: 'pemilik', className: 'text-slate-500' },
                {
                    data: 'id_kendaraan',
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
                search: "Cari Kendaraan:",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ kendaraan",
                emptyTable: "Belum ada data kendaraan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        $('#kendaraanForm').on('submit', function(e) {
            e.preventDefault();
            
            // Sync logic for jenis_kendaraan
            if($('#jenis_kendaraan_select').val() === 'Lainnya') {
                $('#jenis_kendaraan').val($('#jenis_kendaraan_input').val());
            } else {
                $('#jenis_kendaraan').val($('#jenis_kendaraan_select').val());
            }

            // check if custom empty
            if($('#jenis_kendaraan_select').val() === 'Lainnya' && !$('#jenis_kendaraan_input').val().trim()) {
                Swal.fire({icon: 'warning', title: 'Perhatian', text: 'Tuliskan spesifik jenis kendaraannya!'});
                return;
            }

            let id = $('#id_kendaraan').val();
            let url = mode === 'add' ? "{{ route('kendaraan.store') }}" : "/kendaraan/" + id;
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
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
                },
                error: function(err) {
                    let errors = err.responseJSON?.errors;
                    let msg = err.responseJSON?.message || 'Terjadi kesalahan eksekusi pada server';
                    if(errors) msg = Object.values(errors)[0][0];
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
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
        $('#kendaraanForm')[0].reset();
        
        let modal = document.getElementById('kendaraanModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContainer.classList.remove('scale-95');
        }, 10);

        if (mode === 'add') {
            $('#modalTitle').text('Registrasi Kendaraan Baru');
            $('#id_kendaraan').val('');
            $('#jenis_kendaraan_select').val('').trigger('change');
            $('#jenis_kendaraan_input').val('');
        } else {
            $('#modalTitle').text('Perbarui Data Kendaraan');
            $('#id_kendaraan').val(data.id_kendaraan);
            $('#plat_nomor').val(data.plat_nomor);
            
            let valTypes = ['Motor', 'Mobil'];
            if(valTypes.includes(data.jenis_kendaraan)) {
                $('#jenis_kendaraan_select').val(data.jenis_kendaraan).trigger('change');
                $('#jenis_kendaraan_input').val('');
            } else {
                $('#jenis_kendaraan_select').val('Lainnya').trigger('change');
                $('#jenis_kendaraan_input').val(data.jenis_kendaraan);
            }
            
            $('#warna').val(data.warna);
            $('#pemilik').val(data.pemilik);
        }
    }

    function handleJenisChange(sel) {
        if(sel.value === 'Lainnya') {
            $('#jenis_kendaraan_input').removeClass('hidden').prop('required', true);
        } else {
            $('#jenis_kendaraan_input').addClass('hidden').prop('required', false);
        }
    }

    function closeModal() {
        let modal = document.getElementById('kendaraanModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.add('opacity-0');
        modalContainer.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function deleteData(id) {
        Swal.fire({
            title: 'Hapus Kendaraan ini?',
            text: "Data kendaraan yang sudah terhubung dengan transaksi parkir mungkin menyebabkan anomali laporan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: 'Ya hapus!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl text-slate-700' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/kendaraan/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        table.ajax.reload(null, false);
                        Swal.fire({ icon: 'success', title: 'Terhapus', text: 'Kendaraan berhasil dihapus!', showConfirmButton: false, timer:1500, customClass:{popup:'rounded-2xl'} });
                    },
                    error: function(err) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: err.responseJSON?.message || 'Server menolak aksi penghapusan', customClass:{popup:'rounded-2xl'} });
                    }
                });
            }
        });
    }
</script>
