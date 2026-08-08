<x-guest-layout>
    <!-- Title -->
    <h2 class="text-2xl font-bold text-center text-gray-900 mb-6 uppercase tracking-wider">
        {{ __('REGISTER') }}
    </h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama -->
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" placeholder="Your Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" placeholder="Enter Your Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" placeholder="Enter Your Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')"
                required autocomplete="tel" placeholder="Enter Your Phone Number" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                required placeholder="Enter Your Address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Submit Button (Pink Soft) -->
        <div class="mt-6">
            <button type="submit"
                class="w-full py-3 px-4 bg-[#FFB7C5] hover:bg-[#ff9eae] text-white font-semibold rounded-md shadow-sm transition duration-150 ease-in-out text-center">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
