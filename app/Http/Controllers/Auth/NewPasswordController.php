<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\DB;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $email = $request->email;

        $tokenExists = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->exists();

        if ($tokenExists) {
            return view('auth.reset-password', ['request' => $request]);
        } else {
            return redirect()->route('password.request')->withErrors(['email' => __('Invalid or expired token.')]);
        }
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            $this->invalidateToken($request->email);
            return redirect()->route('login')->with('status', __($status));
        } else {
            return back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
        }
    }

    /**
     * Invalidate the given password reset token.
     *
     * @param string $email
     * @return void
     */
    protected function invalidateToken($email)
    {
        // Update the 'created_at' column to mark the token as used
        PasswordResetToken::where('email', $email)->update(['created_at' => now()]);
    }
}
