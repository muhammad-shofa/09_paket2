<!-- Modal Backdrop -->
<div id="userModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center opacity-0 transition-opacity duration-300">
    <!-- Modal Container -->
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300 mx-4">
        <div class="flex justify-between items-center p-6 border-b border-slate-100">
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800 tracking-tight">Tambah User</h3>
            <button type="button" onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>
        
        <form id="userForm">
            <div class="p-6 space-y-5">
                <input type="hidden" id="id_user" name="id_user">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Masukkan nama lengkap" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Masukkan username login" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5 flex justify-between items-center">
                        Password 
                        <span id="pwdHint" class="text-xs text-indigo-500 font-medium hidden">Kosongkan jika tidak diubah</span>
                    </label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Minimal 6 karakter" autocomplete="off">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Role (Peran)</label>
                    <select id="role" name="role" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all bg-white" required>
                        <option value="admin">Administrator (Akses Penuh)</option>
                        <option value="petugas">Petugas Parkir (Akses Transaksi)</option>
                        <option value="owner">Owner (Akses Laporan)</option>
                    </select>
                </div>
            </div>
            
            <div class="p-6 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50 rounded-b-3xl">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-200 font-medium rounded-xl transition-colors">Batal</button>
                <button type="submit" id="btnSave" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-lg shadow-indigo-200 flex items-center gap-2">
                    <i class="ph-bold ph-check"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
