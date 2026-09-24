<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\LoginRequest;
use App\Models\Security\ScUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function create()
    {
        return view('security.auth.login');
    }

    public function store(LoginRequest $request)
    {
        if (!Auth::attempt([
            'Username' => $request->Username,
            'password' => $request->Password,
            'IsActive' => true,
        ], $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('Username'))
                ->withErrors([
                    'Username' => 'Username atau Password salah.'
                ]);
        }

        $request->session()->regenerate();

        /** @var ScUser $user */
        $user = Auth::user();
        $user->update(['LastLogin' => now()]);

        // Simpan EmpFormID user login ke session agar seluruh module
        // transaction dapat menggunakan Employee Form context yang sama.
        $request->session()->put('EmpFormID', $user->EmpFormID);

        return redirect()->intended(route('dashboard'));
    }

    public function register()
    {
        return view('security.auth.register');
    }

    public function storeRegistration(Request $request)
    {
        $validated = $request->validate([
            'FullName' => ['required', 'string', 'max:100'],
            'Username' => ['required', 'string', 'max:50', 'unique:sc_user,Username'],
            'Email' => ['required', 'email', 'max:100', 'unique:sc_user,Email'],
            'Password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ]);

        ScUser::create([
            'Username' => $validated['Username'],
            'FullName' => $validated['FullName'],
            'Password' => Hash::make($validated['Password']),
            'Email' => $validated['Email'],
            'IsActive' => true,
            'InputUser' => $validated['Username'],
            'InputDate' => now(),
            'ModifUser' => $validated['Username'],
            'ModifDate' => now(),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registration berhasil. Silakan login dengan akun yang baru dibuat.');
    }

    public function showForgotPassword()
    {
        return view('security.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'Email' => ['required', 'email'],
        ]);

        $status = Password::broker()->sendResetLink([
            'Email' => $request->Email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Password reset link has been sent to your email address.');
        }

        return back()->withErrors([
            'Email' => 'We could not find an account with that email address.',
        ]);
    }

    public function showResetPassword(Request $request, string $token)
    {
        return view('security.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required'],
            'Email' => ['required', 'email'],
            'Password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::broker()->reset(
            [
                'Email' => $validated['Email'],
                'password' => $validated['Password'],
                'password_confirmation' => $validated['Password_confirmation'],
                'token' => $validated['token'],
            ],
            function (ScUser $user, string $password) {
                $user->forceFill([
                    'Password' => Hash::make($password),
                    'ModifUser' => $user->Username,
                    'ModifDate' => now(),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('success', 'Password berhasil diubah. Silakan login kembali.');
        }

        return back()->withErrors([
            'Email' => 'The password reset link is invalid or has expired.',
        ]);
    }

    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
