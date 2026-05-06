<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class MahasiswaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.mahasiswa.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function showRegisterForm()
    {
        return view('auth.mahasiswa.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:45',
            'nim' => 'required|integer|unique:mahasiswa',
            'email' => 'required|email|unique:mahasiswa',
            'username' => 'required|unique:mahasiswa',
            'password' => 'required|min:6|confirmed',
        ]);

        Mahasiswa::create([
            'id_mahasiswa' => 'MHS' . str_pad(Mahasiswa::count() + 1, 4, '0', STR_PAD_LEFT),
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('mahasiswa.login')
                         ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('mahasiswa.login');
    }
}