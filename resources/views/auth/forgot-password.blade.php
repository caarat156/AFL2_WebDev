<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- submit email ke controller PasswordResetLinkController@store. --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address input email-->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

{{-- Flow yang terjadi ketika dipakai:
User masuk halaman “Forgot Password”.
User isi email → klik submit.
Laravel validasi email → jika valid, kirim link reset.
User dapat link di email → klik → masuk halaman reset password untuk membuat password baru. --}}

