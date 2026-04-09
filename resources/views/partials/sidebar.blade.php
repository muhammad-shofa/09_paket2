<aside class="flex flex-col w-64 h-screen px-4 py-6 overflow-y-auto bg-white border-r border-slate-200">
    <div class="flex items-center gap-3 px-2 mb-10">
        <div class="p-2.5 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200">
            <i class="ph-bold ph-car-profile text-2xl text-white"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight leading-none">Parkir Sek</h2>
            <p class="text-xs text-slate-400 mt-1 capitalize">{{ auth()->user()->role ?? 'Dashboard' }} Dashboard</p>
        </div>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-2">
        <nav class="space-y-2">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('dashboard.admin') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard.admin') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i
                        class="ph ph-squares-four text-xl mr-3 {{ request()->routeIs('dashboard.admin') ? 'text-indigo-600' : '' }}"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('user.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('user.*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i class="ph ph-users text-xl mr-3 {{ request()->routeIs('user.*') ? 'text-indigo-600' : '' }}"></i>
                    <span>Manage Users</span>
                </a>

                <a href="{{ route('tarif.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('tarif.*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i class="ph ph-tag text-xl mr-3 {{ request()->routeIs('tarif.*') ? 'text-indigo-600' : '' }}"></i>
                    <span>Tarif Parkir</span>
                </a>

                <a href="{{ route('area.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('area.*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i
                        class="ph ph-map-pin-line text-xl mr-3 {{ request()->routeIs('area.*') ? 'text-indigo-600' : '' }}"></i>
                    <span>Area Parkir</span>
                </a>

                <a href="{{ route('kendaraan.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('kendaraan.*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i class="ph ph-car text-xl mr-3 {{ request()->routeIs('kendaraan.*') ? 'text-indigo-600' : '' }}"></i>
                    <span>Kendaraan</span>
                </a>

                <div class="pt-4 mt-4 border-t border-slate-100">
                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Laporan</p>
                    <a href="{{ route('log.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('log.*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                        <i class="ph ph-scroll text-xl mr-3 {{ request()->routeIs('log.*') ? 'text-indigo-600' : '' }}"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </div>
            @endif

            @if(auth()->check() && auth()->user()->role === 'petugas')
                <a href="{{ route('dashboard.petugas') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard.petugas') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i
                        class="ph ph-squares-four text-xl mr-3 {{ request()->routeIs('dashboard.petugas') ? 'text-indigo-600' : '' }}"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('transaksi.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('transaksi.*') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i class="ph ph-swap text-xl mr-3 {{ request()->routeIs('transaksi.*') ? 'text-indigo-600' : '' }}"></i>
                    <span>Transaksi Parkir</span>
                </a>


            @endif

            @if(auth()->check() && auth()->user()->role === 'owner')
                <a href="{{ route('dashboard.owner') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard.owner') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i
                        class="ph ph-squares-four text-xl mr-3 {{ request()->routeIs('dashboard.owner') ? 'text-indigo-600' : '' }}"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('rekap.owner') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('rekap.owner') ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }} rounded-xl transition-all">
                    <i class="ph ph-file-text text-xl mr-3 {{ request()->routeIs('rekap.owner') ? 'text-indigo-600' : '' }}"></i>
                    <span>Rekap Transaksi</span>
                </a>
            @endif
        </nav>
    </div>
</aside>