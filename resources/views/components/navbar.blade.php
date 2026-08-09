@php
    $home = '/';
@endphp

<nav
    class="sticky top-0 z-50 flex w-full items-center justify-between px-6 py-5 bg-ajeng-white/90 backdrop-blur-md font-poppins border-b border-ajeng-gray-5 lg:border-none shadow-sm lg:shadow-none">

    <div class="flex items-center">
        <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
            <img src="{{ asset('assets/logo-square.png') }}" alt="Logo Ajeng Laundry"
                class="w-10 md:w-12.5 object-contain">

            <span class="text-xl md:text-2xl font-bold text-ajeng-black tracking-tight">Ajeng Laundry.</span>
        </a>
    </div>

    <div class="lg:hidden flex items-center">
        <button id="mobile-menu-button"
            class="text-ajeng-black hover:text-ajeng-pink focus:outline-none p-2 transition-colors">
            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div
        class="hidden lg:flex flex-row gap-8 xl:gap-12 items-center justify-center text-ajeng-black text-[15px] font-medium">
        <a href="{{ $home }}#beranda" class="hover:text-ajeng-pink transition-colors">Beranda</a>
        <a href="{{ $home }}#tentang" class="hover:text-ajeng-pink transition-colors">Tentang</a>
        <a href="{{ $home }}#layanan" class="hover:text-ajeng-pink transition-colors">Layanan</a>
        <a href="{{ $home }}#faq" class="hover:text-ajeng-pink transition-colors">FAQ</a>
        <a href="/cek-pesanan" class="hover:text-ajeng-pink transition-colors">Cek Pesanan Kamu</a>
    </div>

    <div class="hidden lg:flex flex-row gap-6 items-center justify-center text-[15px] font-medium">
        @guest
            <a href="/login" class="text-ajeng-black hover:text-ajeng-pink transition-colors">Masuk</a>
        @endguest

        @auth
            <a href="/dashboard" class="text-ajeng-black hover:text-ajeng-pink transition-colors">Dashboard</a>
        @endauth

        <a href=""
            class="px-5 py-2 text-ajeng-black border border-ajeng-gray-3 rounded-lg hover:border-ajeng-pink hover:text-ajeng-pink hover:bg-ajeng-bg-pink-2 transition-all">
            Get In Touch
        </a>
    </div>

    <div id="mobile-menu"
        class="hidden absolute top-full left-0 w-full bg-ajeng-white shadow-lg flex-col z-50 lg:hidden border-t border-ajeng-gray-4 text-ajeng-black font-medium">
        <a href="{{ $home }}#beranda"
            class="mobile-link px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">Beranda</a>
        <a href="{{ $home }}#tentang"
            class="mobile-link px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">Tentang</a>
        <a href="{{ $home }}#layanan"
            class="mobile-link px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">Layanan</a>
        <a href="{{ $home }}#faq"
            class="mobile-link px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">FAQ</a>
        <a href="/cek-pesanan"
            class="mobile-link px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">Cek
            Pesanan Kamu</a>

        @guest
            <a href="/login"
                class="mobile-link px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">
                Masuk
            </a>
        @endguest

        @auth
            <a href="/dashboard"
                class="mobile-link px-6 py-4 border-b border-ajeng-gray-5 hover:bg-ajeng-bg-pink-2 hover:text-ajeng-pink">
                Dashboard
            </a>
        @endauth

        <div class="px-6 py-5 bg-ajeng-gray-5">
            <a href=""
                class="block w-full text-center px-5 py-3 border border-ajeng-gray-3 bg-ajeng-white rounded-lg hover:border-ajeng-pink hover:text-ajeng-pink transition-all">
                Get In Touch
            </a>
        </div>
    </div>
</nav>
