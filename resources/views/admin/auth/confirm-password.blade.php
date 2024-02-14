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
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('manage.password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="d-flex justify-content-end mt-4">
                <x-button>
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
