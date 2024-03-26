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

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('manage.login') }}" id="quickForm">
            @csrf
            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="" type="email" name="email" :value="old('email')" autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="" type="password" name="password"
                    autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="mt-3 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <x-label for="remember_me" class="form-check-label text-sm">
                    {{ __('Remember me') }}
                </x-label>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-admin.captcha />
            </div>

            <div class="d-flex justify-content-end mt-4">
                @if (Route::has('manage.password.request'))
                    <a class="text-muted" href="{{ route('manage.password.request') }}"
                        style="margin-right: 15px; margin-top: 15px;">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>

    @push('scripts')
        <script type="text/javascript" src="{{ asset('webroot/validation/dist/jquery.validate.js') }}"></script>
        <script type="text/javascript">
            jQuery(function() {
                var validator = jQuery("#quickForm").validate({
                    rules: {
                        email: {
                            required: true,
                        },
                        password: {
                            required: true,
                        },
                        captcha: {
                            required: false,
                        },
                    },
                    messages: {
                        email: {
                            required: 'Email is required.',
                        },
                        password: {
                            required: 'Password is required.',
                        },
                        captcha: {
                            required: 'Security Code is required.',
                        },
                    },
                    submitHandler: function(form) {
                        loader.show();
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
</x-guest-layout>
