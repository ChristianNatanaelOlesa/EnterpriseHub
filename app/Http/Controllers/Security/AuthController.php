<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('security.auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = [
            'Username' => $request->Username,
            'Password' => $request->Password,
        ];

        if (!Auth::attempt([
            'Username' => $credentials['Username'],
            'password' => $credentials['Password'],
        ])) {

            return back()
                ->withInput()
                ->withErrors([
                    'Username' => 'Username atau Password salah.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
