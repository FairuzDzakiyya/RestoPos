<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin')->with('success', 'Login berhasil!');
            } elseif (Auth::user()->role == 'kasir') {
                return redirect()->route('kasir')->with('success', 'Login berhasil!');
            } elseif (Auth::user()->role == 'owner') {
                return redirect()->route('owner')->with('success', 'Login berhasil!');
            }
            $request->session()->regenerate();
            // return redirect()->route('')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}