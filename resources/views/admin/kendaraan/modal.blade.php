<!-- Modal Backdrop -->
<div id="kendaraanModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center opacity-0 transition-opacity duration-300">
    <!-- Modal Container -->
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300 mx-4">
        <div class="flex justify-between items-center p-6 border-b border-slate-100">
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800 tracking-tight">Tambah Kendaraan</h3>
            <button type="button" onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>
        
        <form id="kendaraanForm">
            <div class="p-6 space-y-5">
                <input type="hidden" id="id_kendaraan" name="id_kendaraan">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Plat Nomor Kendaraan</label>
                    <input type="text" id="plat_nomor" name="plat_nomor" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all uppercase" placeholder="Contoh: B 1234 CD" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kendaraan</label>
                        <select id="jenis_kendaraan_select" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all bg-white" required onchange="handleJenisChange(this)">
                            <option value="">Pilih Jenis</option>
                            <option value="Motor">Motor</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Lainnya">Lainnya...</option>
                        </select>
                        <input type="text" id="jenis_kendaraan_input" class="w-full mt-2 px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all hidden" placeholder="Ketik jenis kendaraan...">
                        <input type="hidden" id="jenis_kendaraan" name="jenis_kendaraan">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Warna</label>
                        <input type="text" id="warna" name="warna" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Contoh: Hitam" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Pemilik / Supir</label>
                    <input type="text" id="pemilik" name="pemilik" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Nama pemilik kendaraan" required>
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
