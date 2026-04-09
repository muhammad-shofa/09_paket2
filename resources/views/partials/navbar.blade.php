<header class="sticky top-0 z-30 flex items-center justify-between px-8 py-4 bg-white/80 backdrop-blur-md border-b border-slate-200">
    <div class="flex items-center">
        <!-- Optional Hamburger Menu for Mobile -->
        <button class="text-slate-500 focus:outline-none lg:hidden">
            <i class="ph ph-list text-2xl"></i>
        </button>
        <span class="text-2xl font-bold text-slate-800 ml-2 tracking-tight">@yield('header_title', 'Overview')</span>
    </div>

    <div class="flex items-center gap-6">
        <div class="relative flex border border-slate-200 p-1.5 rounded-2xl pr-4">
            <button class="flex items-center gap-3 focus:outline-none">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-400 text-white flex items-center justify-center font-bold shadow-md">
                    {{ substr(auth()->user()->nama_lengkap ?? 'A', 0, 1) }}
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-slate-800 leading-tight">{{ auth()->user()->nama_lengkap ?? 'Admin User' }}</p>
                    <p class="text-xs text-indigo-600 font-medium capitalize">{{ auth()->user()->role ?? 'Administrator' }}</p>
                </div>
            </button>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex flex-row items-center justify-center p-2 text-slate-400 hover:text-red-600 transition-colors bg-slate-50 rounded-xl hover:bg-red-50" title="Logout">
                <i class="ph-bold ph-sign-out text-xl"></i>
            </button>
        </form>
    </div>
</header>
