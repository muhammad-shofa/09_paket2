<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let table;
    let mode = 'add';

    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        table = $('#userTable').DataTable({
            processing: true,
            serverSide: false, // For simplicity we use client-side data processing of the returned array
            ajax: {
                url: "{{ route('user.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'id_user', name: 'id_user' },
                { data: 'nama_lengkap', name: 'nama_lengkap', className: 'font-medium text-slate-800' },
                { data: 'username', name: 'username', className: 'text-slate-500' },
                { 
                    data: 'role', 
                    name: 'role',
                    render: function(data) {
                        let colors = {
                            'admin': 'bg-indigo-50 text-indigo-600',
                            'petugas': 'bg-emerald-50 text-emerald-600',
                            'owner': 'bg-amber-50 text-amber-600'
                        };
                        let c = colors[data] || 'bg-slate-50 text-slate-600';
                        return `<span class="px-3 py-1 ${c} rounded-full text-[11px] font-bold uppercase tracking-wider">${data}</span>`;
                    }
                },
                { 
                    data: 'status_aktif', 
                    name: 'status_aktif',
                    render: function(data) {
                        return data == 1 
                            ? '<div class="flex items-center gap-1.5"><div class="w-2 h-2 rounded-full bg-emerald-500"></div><span class="text-sm font-medium text-slate-700">Aktif</span></div>' 
                            : '<div class="flex items-center gap-1.5"><div class="w-2 h-2 rounded-full bg-rose-500"></div><span class="text-sm font-medium text-slate-700">Nonaktif</span></div>';
                    }
                },
                {
                    data: 'id_user',
                    orderable: false,
                    render: function(data, type, row) {
                        // Protect super admin deletion (optional logic, based on ID 1)
                        let delBtn = row.id_user == 1 
                            ? `<button disabled class="p-2 text-slate-300 bg-slate-50 rounded-xl cursor-not-allowed"><i class="ph-bold ph-trash"></i></button>`
                            : `<button onclick='deleteData(${data})' class="p-2 text-rose-500 bg-rose-50 hover:bg-rose-100 hover:text-rose-600 rounded-xl transition-colors shadow-sm"><i class="ph-bold ph-trash"></i></button>`;

                        return `
                            <div class="flex gap-2">
                                <button onclick='openModal("edit", ${JSON.stringify(row)})' class="p-2 text-indigo-500 bg-indigo-50 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </button>
                                ${delBtn}
                            </div>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                emptyTable: "Belum ada data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            }
        });

        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#id_user').val();
            let url = mode === 'add' ? "{{ route('user.store') }}" : "/user/" + id;
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
                        msg = Object.values(errors)[0][0]; // get first validation error
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
        $('#userForm')[0].reset();
        
        let modal = document.getElementById('userModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.remove('hidden');
        // Small delay for CSS transition
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContainer.classList.remove('scale-95');
        }, 10);

        if (mode === 'add') {
            $('#modalTitle').text('Tambah Pengguna Baru');
            $('#pwdHint').addClass('hidden');
            $('#password').prop('required', true);
            $('#id_user').val('');
        } else {
            $('#modalTitle').text('Edit Data Pengguna');
            $('#pwdHint').removeClass('hidden');
            $('#password').prop('required', false);
            
            // Populate form
            $('#id_user').val(data.id_user);
            $('#nama_lengkap').val(data.nama_lengkap);
            $('#username').val(data.username);
            $('#role').val(data.role);
        }
    }

    function closeModal() {
        let modal = document.getElementById('userModal');
        let modalContainer = modal.querySelector('div.bg-white');
        
        modal.classList.add('opacity-0');
        modalContainer.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function deleteData(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: "Pengguna ini tidak akan bisa login lagi!",
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
                    url: '/user/' + id,
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
