<x-guest-layout>
    <link href="{{ asset('manocss/loginreg.css') }}" rel="stylesheet">
    <div class="login-form">
        <div class="mb-4 text-xl text-green-600">
            {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
            </div>
        @endif
        <div class="field">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <button>
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="text-center">
            <a href="{{ route('profile.show') }}"
                class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Edit Profile') }}
            </a>
        </div>
        <div class="text-center">
            <form method="POST" action="{{ route('logout') }}" class="inline" style="margin-right: 2%">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                    {{ __('Log Out') }}
                </a>
            </form>
        <div class="text-center">
        <a href="/"
            class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Home</a>
    </div>
    </div>
    </div>

</x-guest-layout>
