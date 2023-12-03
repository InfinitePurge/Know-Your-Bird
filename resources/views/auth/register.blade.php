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
                REGISTER
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <div class="fas fa-user"></div>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus
                        autocomplete="name" placeholder="Username">
                </div>
                <div class="field">
                    <div class="fas fa-envelope"></div>
                    <input id="email" type="email" name="email" :value="old('email')" required
                        autocomplete="email" placeholder="Email">
                </div>
                <div class="field">
                    <div class="fas fa-lock"></div>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="Password">
                </div>
                <div class="field">
                    <div class="fas fa-lock"></div>
                    <input input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" placeholder="Confirm Password">
                </div>
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' =>
                                            '<a target="_blank" href="' .
                                            route('terms.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                            __('Terms of Service') .
                                            '</a>',
                                        'privacy_policy' =>
                                            '<a target="_blank" href="' .
                                            route('policy.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                            __('Privacy Policy') .
                                            '</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif
                <div class="link">
                    <a class="underline text-sm text-gray-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                </div>
                <div>
                    <button>Register</button>
                </div>
            </form>
            <div class="text-center link">
                <a href="/"
                    class="underline text-sm text-green-600 hover:text-green-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Home</a>
            </div>
        </div>
    </body>

    </html>
</x-guest-layout>
