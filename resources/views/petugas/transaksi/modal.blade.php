<!-- Modal Backdrop -->
<div id="transaksiModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex justify-center items-center opacity-0 transition-opacity duration-300">
    <!-- Modal Container -->
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300 mx-4">
        <div class="flex justify-between items-center p-6 border-b border-slate-100">
            <h3 class="text-xl font-bold text-slate-800 tracking-tight">Catat Kendaraan Masuk</h3>
            <button type="button" onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>
        
        <form id="transaksiForm">
            <div class="p-6 space-y-5">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 mb-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Registrasi Kendaraan Baru / Cari Plat</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Plat Nomor Kendaraan</label>
                            <input type="text" id="plat_nomor" name="plat_nomor" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all uppercase" placeholder="Ketik Plat Nomor..." required>
                            <p class="text-[11px] text-slate-400 mt-1 pb-2"><i class="ph-fill ph-info"></i> Isikan data di bawah jika plat baru.</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-200/60">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kendaraan</label>
                                <select id="jenis_kendaraan" name="jenis_kendaraan" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all bg-white" required>
                                    <option value="Motor">Motor</option>
                                    <option value="Mobil">Mobil</option>
                                    <option value="Lainnya">Lainnya...</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Warna</label>
                                <input type="text" id="warna" name="warna" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Contoh: Hitam" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Pemilik / Supir</label>
                            <input type="text" id="pemilik" name="pemilik" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Misal: Anonim" value="Anonim" required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1 mt-2">Pilihan Lokasi & Tarif</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilih Area Lokasi Parkir</label>
                        <select id="id_area" name="id_area" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all bg-white" required>
                            <option value="">-- Pilih Area --</option>
                            @foreach($areas as $ar)
                                <option value="{{ $ar->id_area }}">{{ $ar->nama_area }} (Sisa: {{ $ar->kapasitas - $ar->terisi }} slot)</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilih Golongan Tarif</label>
                        <select id="id_tarif" name="id_tarif" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all bg-white" required>
                            <option value="">-- Pilih Tarif --</option>
                            @foreach($tarifs as $tr)
                                <option value="{{ $tr->id_tarif }}" class="capitalize">{{ $tr->jenis_kendaraan }} - Rp{{ number_format($tr->tarif_per_jam, 0, ',', '.') }}/jam</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
            </div>
            
            <div class="p-6 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50 rounded-b-3xl">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-200 font-medium rounded-xl transition-colors">Batal</button>
                <button type="submit" id="btnSave" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-lg shadow-indigo-200 flex items-center gap-2">
                    <i class="ph-bold ph-sign-in"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>
