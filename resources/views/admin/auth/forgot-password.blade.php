<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="d-flex justify-content-center">
                <x-application-logo width=64 height=64 />
            </a>
            <div class="mb-4 text-center">
                <p class="name mb-1">e-Shiksha</p>
                <span class="subhead">Govt. of Madhya Pradesh</span>
            </div>
        </x-slot>

        <div class="mb-4 text-muted">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('manage.password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>

            <div class="d-flex justify-content-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
