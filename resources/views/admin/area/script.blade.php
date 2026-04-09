<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;
    let mode = 'add';

    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        table = $('#areaTable').DataTable({
            processing: true,
            serverSide: false, 
            ajax: {
                url: "{{ route('area.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'id_area', name: 'id_area' },
                { data: 'nama_area', name: 'nama_area', className: 'font-semibold text-slate-800' },
                { data: 'kapasitas', name: 'kapasitas', className: 'text-center font-medium text-slate-600' },
                { data: 'terisi', name: 'terisi', className: 'text-center font-medium text-indigo-600' },
                {
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let tersedia = row.kapasitas - row.terisi;
                        let pct = row.kapasitas > 0 ? (row.terisi / row.kapasitas) * 100 : 0;
                        let clr = pct >= 90 ? 'text-rose-500 fill-rose-500 bg-rose-50' : 
                                 (pct >= 60 ? 'text-amber-500 fill-amber-500 bg-amber-50' : 'text-emerald-500 fill-emerald-500 bg-emerald-50');
                        
                        return `<span class="px-3 py-1 rounded-full text-xs font-bold ${clr}">${tersedia} Sisa</span>`;
                    }
                },
                {
                    data: 'id_area',
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
                search: "Cari Area:",
                lengthMenu: "Tampilkan _MENU_ area",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ area",
                emptyTable: "Belum ada data area parkir",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        $('#areaForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#id_area').val();
            let url = mode === 'add' ? "{{ route('area.store') }}" : "/area/" + id;
            let type = mode === 'add' ? "POST" : "PUT";

            // Validasi client-side: Terisi tidak boleh lebih dari kapasitas
            if(parseInt($('#terisi').val()) > parseInt($('#kapasitas').val())) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Valid',
                    text: 'Jumlah slot terisi tidak boleh melebihi kapasitas maksimal!',
                    customClass: { popup: 'rounded-2xl' }
                });
                return;
            }

            let btn = $('#btnSave');
            let originalContent = btn.html();
            btn.prop('disabled', true).html('<i class="ph ph-spinner animate-spin"></i>');

            $.ajax({
                url: url,
                type: type,
                data: $(this).serialize(),
                success: function(res) {
                    closeModal();
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersimpan',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl' }
                    });
                },
                error: function(err) {
                    let errors = err.responseJSON?.errors;
                    let msg = err.responseJSON?.message || 'Error pada server';
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
        $('#areaForm')[0].reset();
        
        let modal = document.getElementById('areaModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContainer.classList.remove('scale-95');
        }, 10);

        if (mode === 'add') {
            $('#modalTitle').text('Tambah Area Parkir');
            $('#id_area').val('');
            $('#terisi').val(0); // Default for new
        } else {
            $('#modalTitle').text('Edit Area Parkir');
            $('#id_area').val(data.id_area);
            $('#nama_area').val(data.nama_area);
            $('#kapasitas').val(data.kapasitas);
            $('#terisi').val(data.terisi);
        }
    }

    function closeModal() {
        let modal = document.getElementById('areaModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.add('opacity-0');
        modalContainer.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function deleteData(id) {
        Swal.fire({
            title: 'Hapus Area?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl text-slate-700' }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/area/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        table.ajax.reload(null, false);
                        Swal.fire({ icon: 'success', title: 'Dihapus!', showConfirmButton: false, timer: 1500, customClass:{popup:'rounded-2xl'} });
                    },
                    error: function(err) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: err.responseJSON?.message || 'Data terkait dengan record lain.', customClass:{popup:'rounded-2xl'} });
                    }
                });
            }
        });
    }
</script>
