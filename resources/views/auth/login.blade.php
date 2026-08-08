<x-layout>

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

</x-layout>