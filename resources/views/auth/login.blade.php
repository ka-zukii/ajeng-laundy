<x-landing-page-layout>

    <section class="min-h-screen bg-ajeng-bg-pink-1 py-16">
        <div class="container mx-auto px-6">

            <div class="max-w-md mx-auto bg-ajeng-white rounded-2xl shadow-lg p-8">

                <div class="text-center mb-8">
                    <img src="{{ asset('assets/logo-square.png') }}"
                        class="w-20 mx-auto mb-4">

                    <h1 class="text-3xl font-bold text-ajeng-black">
                        Selamat Datang
                    </h1>

                    <p class="text-ajeng-gray-1 mt-2">
                        Masuk ke akun Ajeng Laundry
                    </p>
                </div>

                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-5">
                        <label
                            class="block mb-2 font-medium text-ajeng-black">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-lg border border-ajeng-gray-4 px-4 py-3 focus:border-ajeng-pink focus:ring-ajeng-pink">

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div class="mb-5">
                        <label
                            class="block mb-2 font-medium text-ajeng-black">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-lg border border-ajeng-gray-4 px-4 py-3 focus:border-ajeng-pink focus:ring-ajeng-pink">

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2" />
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center mb-6">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-ajeng-gray-3">

                        <label
                            for="remember_me"
                            class="ml-2 text-sm text-ajeng-dark-1">
                            Ingat Saya
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-ajeng-pink py-3 text-ajeng-white font-semibold hover:opacity-90 transition">
                        Masuk
                    </button>

                    <div class="mt-6 flex items-center justify-center gap-4">
                        <hr class="w-full border-ajeng-gray-4">
                        <span class="text-sm text-ajeng-gray-1 font-medium font-poppins">ATAU</span>
                        <hr class="w-full border-ajeng-gray-4">
                    </div>

                    <a href="{{ route('google.login') }}" class="mt-6 flex w-full items-center justify-center gap-3 rounded-lg border border-ajeng-gray-3 bg-white px-4 py-3 font-semibold text-ajeng-black hover:bg-gray-50 transition shadow-sm font-poppins">
                        <svg class="h-5 w-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        Masuk dengan Google
                    </a>

                    @if(Route::has('password.request'))
                        <div class="text-center mt-5">
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-ajeng-pink hover:underline">
                                Lupa Password?
                            </a>
                        </div>
                    @endif

                    <div class="text-center mt-6">
                        <span class="text-ajeng-gray-1">
                            Belum punya akun?
                        </span>

                        <a href="{{ route('register') }}"
                            class="font-semibold text-ajeng-pink hover:underline">
                            Daftar
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </section>

</x-landing-page-layout>