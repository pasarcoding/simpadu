<?php

namespace Modules\Authentication\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Authentication\App\Http\Requests\AuthenticationRequest;

class AuthenticationController extends Controller
{

    public function login()
    {
        return view('authentication::admin.login');
    }

    public function do_login(AuthenticationRequest $request)
    {
        $credentials = $request->validated();
        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        } catch (Exception $e) {
            Log::error("Gagal Login:", ['error' => $e->getMessage()]);

            return back()
                ->onlyInput('email')
                ->with('error', 'Terjadi kesalahan sistem yang tidak terduga saat mencoba login. Silakan coba lagi.');
        }

        return back()
            ->onlyInput('email')
            ->with('error', 'Kombinasi email dan password tidak valid.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.auth.login.index');
    }
}
