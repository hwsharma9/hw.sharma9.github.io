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
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-success">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 d-flex justify-content-between">
            <form method="POST" action="{{ route('manage.verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('manage.logout') }}">
                @csrf

                <button type="submit" class="btn btn-link">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
