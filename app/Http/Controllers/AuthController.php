<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\LogActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Tampilkan Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 2. Proses Registrasi User
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:staff,user',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        LogActivity::create([
            'user_id'    => Auth::check() ? Auth::id() : null,
            'subject'    => "User Baru Registrasi: {$request->name} - ({$request->email})",
            'url'        => RequestFacade::fullUrl(),
            'method'     => RequestFacade::method(),
            'ip_address' => RequestFacade::ip(),
            'agent'      => RequestFacade::header('user-agent'),
        ]);


        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // 3. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 4. Proses Otentikasi Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Coba Login dengan Auth::attempt
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate(); // Regenerasi session untuk keamanan

            // 1. CATAT LOG LOGIN BERHASIL
            LogHelper::record('User Berhasil Login Ke Sistem');

            // Redirect berdasarkan Role User
            if (Auth::user()->role === 'staff') {
                return redirect()->intended('/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        // 2. CATAT LOG LOGIN GAGAL
        LogHelper::record('Percobaan Login Gagal Email: ' . $request->email);

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 5. Proses Logout
    public function logout(Request $request)
    {
        // 3. CATAT LOG LOGOUT SEBELUM SESSION DI-DESTROY
        LogHelper::record('User Logout Dari Aplikasi');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

}
