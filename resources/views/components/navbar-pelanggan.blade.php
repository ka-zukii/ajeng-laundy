<nav x-data="{ open: false }" 
    class="sticky top-0 z-50 flex w-full items-center justify-between px-6 py-5 bg-ajeng-white/90 backdrop-blur-md font-poppins border-b border-ajeng-gray-5 lg:border-none shadow-sm lg:shadow-none">

    <div class="flex items-center">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
            <img src="{{ asset('assets/logo-square.png') }}" alt="Logo Ajeng Laundry"
                class="w-10 md:w-12.5 object-contain">
            <span class="text-xl md:text-2xl font-bold text-ajeng-black tracking-tight">Ajeng Laundry.</span>
        </a>
    </div>

    <div class="lg:hidden flex items-center">
        <button @click="open = ! open"
            class="text-ajeng-black hover:text-ajeng-pink focus:outline-none p-2 transition-colors cursor-pointer">
            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="hidden lg:flex flex-row gap-8 xl:gap-12 items-center justify-center text-ajeng-black text-[15px] font-medium">
        <a href="/" class="hover:text-ajeng-pink transition-colors">Beranda</a>
        
        <a href="{{ route('dashboard') }}" 
           class="{{ request()->routeIs('dashboard') ? 'text-ajeng-pink' : 'hover:text-ajeng-pink transition-colors' }}">
            Dasbor
        </a>
        
        <a href="{{ route('profile.edit') }}" 
           class="{{ request()->routeIs('profile.edit') ? 'text-ajeng-pink' : 'hover:text-ajeng-pink transition-colors' }}">
            Profil
        </a>
    </div>

    <div class="hidden lg:flex flex-row gap-6 items-center justify-center text-[15px] font-medium">
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
            @csrf
            <button type="submit"
                class="px-5 py-2 text-ajeng-black border border-ajeng-gray-3 rounded-lg hover:border-ajeng-pink hover:text-ajeng-pink hover:bg-ajeng-bg-pink-2 transition-all cursor-pointer">
                Keluar
            </button>
        </form>
    </div>

    <div x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="absolute top-full left-0 w-full bg-ajeng-white shadow-lg flex-col z-50 lg:hidden border-t border-ajeng-gray-4 text-ajeng-black font-medium" 
        style="display: none;">
        
        <a href="/" class="block px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">Beranda</a>
        
        <a href="{{ route('dashboard') }}" 
            class="block px-6 py-4 border-b border-ajeng-gray-5 {{ request()->routeIs('dashboard') ? 'bg-ajeng-bg-pink-2 text-ajeng-pink' : 'hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink' }}">
            Dashboard
        </a>
        
        <a href="{{ route('profile.edit') }}" 
            class="block px-6 py-4 border-b border-ajeng-gray-5 {{ request()->routeIs('profile.edit') ? 'bg-ajeng-bg-pink-2 text-ajeng-pink' : 'hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink' }}">
            Profile
        </a>

        <div class="px-6 py-5 bg-ajeng-gray-5">
            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                @csrf
                <button type="submit"
                    class="block w-full text-center px-5 py-3 border border-ajeng-gray-3 bg-ajeng-white rounded-lg hover:border-ajeng-pink hover:text-ajeng-pink transition-all font-semibold cursor-pointer">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>
</nav>