<!-- Modal Backdrop -->
<div id="tarifModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center opacity-0 transition-opacity duration-300">
    <!-- Modal Container -->
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300 mx-4">
        <div class="flex justify-between items-center p-6 border-b border-slate-100">
            <h3 id="modalTitle" class="text-xl font-bold text-slate-800 tracking-tight">Tambah Tarif</h3>
            <button type="button" onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>
        
        <form id="tarifForm">
            <div class="p-6 space-y-5">
                <input type="hidden" id="id_tarif" name="id_tarif">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kendaraan</label>
                    <select id="jenis_kendaraan" name="jenis_kendaraan" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all bg-white" required>
                        <option value="">Pilih Jenis</option>
                        <option value="motor">Motor</option>
                        <option value="mobil">Mobil</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tarif Per Jam (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-medium">Rp</span>
                        <input type="number" id="tarif_per_jam" name="tarif_per_jam" class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="0" min="0" required>
                    </div>
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
