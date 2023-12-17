<x-guest-layout>
    <link href="{{ asset('manocss/loginreg.css') }}" rel="stylesheet">

    <div class="login-form">

        <div class="mb-4 text-xl text-black-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="field">
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="email"
                    placeholder="Enter your email here">
            </div>
            <button>
                Email Password Reset Link
            </button>
    </form>
    <div class="text-center link">
    <a href="/"
        class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Home</a>
    </div>
    </div>
</x-guest-layout>
