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

        <form method="POST" action="{{ route('manage.otp.verification', ['admin' => encrypt($admin->id)]) }}"
            id="quickForm">
            @csrf
            <input type="hidden" name="email" value="{{ $admin->email }}" />

            @if (config('app.env') == 'production')
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        {{ session()->get('success') }}
                    </div>
                @endif
            @else
                <div class="alert alert-success alert-dismissible">
                    Your OTP is <strong>{{ $admin->verificationCode->latest('id')->first()->otp }}</strong>
                </div>
            @endif

            <!-- OTP -->
            <div>
                <x-label for="otp" :value="__('OTP')" />

                <x-input id="otp" class="" type="text" name="otp" :value="old('otp')" autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4" @if (request()->has('check_otp')) style="display:none" @endif>
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="" type="password" name="password"
                    autocomplete="current-password" />
            </div>
            <div class="mt-4">
                <x-admin.captcha />
            </div>

            <!-- Remember Me -->
            <div class="mt-3 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <x-label for="remember_me" class="form-check-label text-sm">
                    {{ __('Remember me') }}
                </x-label>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <x-button class="ml-3">
                    {{ __('Verify') }}
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
                        otp: {
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
                            required: 'OTP is required.',
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
