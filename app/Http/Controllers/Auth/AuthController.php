<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // return $request->all();
        $remember = $request->get('remember');
        $user = $request->only('email', 'password');
        if (Auth::attempt($user, $remember)) {
            return redirect()->intended('admin/dashboard');
        }
        return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'Sai tài khoản hoặc mật khẩu!']);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('admin.auth.login');
    }
}
