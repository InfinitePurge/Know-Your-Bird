<x-guest-layout>
    <x-validation-errors class="mb-4" />
    <link href="{{ asset('manocss/loginreg.css') }}" rel="stylesheet">
    <!DOCTYPE html>
    <!-- Created By CodingNepal -->
    <html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <title>Glowing Inputs Login Form UI</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    </head>

    <body>
        <div class="login-form">
            <div class="text">
                LOGIN
            </div>
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <div class="fas fa-envelope"></div>
                    <input type="text" name="login" :value="old('login')" required autofocus
                        autocomplete="username" id="login" placeholder="Email or Username">
                </div>
                <div class="field">
                    <div class="fas fa-lock"></div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="Password">
                </div>
                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-black-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <button>{{ __('Log in') }}</button>
                <div class="link">
                    Not a member?
                    <a href="{{ route('register') }}">Signup now</a>
                </div>
                <div class="link">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                <div class="text-center link">
                <a href="/"
                    class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Home</a>
        </div>
        </div>
        </form>
    </body>

    </html>
</x-guest-layout>
