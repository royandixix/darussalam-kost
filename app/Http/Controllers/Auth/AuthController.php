<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('user.auth.login');
    }

    public function showRegister()
    {
        return view('user.auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput()
                ->withErrors([
                    'login' => 'Email atau kata sandi salah.',
                ]);
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== 'penghuni') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput()
                ->withErrors([
                    'login' => 'Akun ini tidak memiliki akses sebagai penghuni.',
                ]);
        }

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Login berhasil. Selamat datang di Darussalam Kost.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'address' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'address.required' => 'Alamat domisili wajib diisi.',
            'photo.image' => 'Foto profil harus berupa gambar.',
            'photo.mimes' => 'Format foto profil harus JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto profil maksimal 2MB.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
        }

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'photo' => $photoPath,
            'password' => Hash::make($request->password),
            'role' => 'penghuni',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login menggunakan akun kamu.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Kamu berhasil keluar dari akun.');
    }
}