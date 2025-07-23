<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Cek admin
        $user = Admin::where('email', $email)->first();
        if ($user && \Hash::check($password, $user->password)) {
            session(['admin_id' => $user->id, 'user_role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        // Cek staff
        $user = Staff::where('email', $email)->first();
        if ($user && \Hash::check($password, $user->password)) {
            \Auth::guard('staff')->login($user);
            return redirect()->route('staff.dashboard');
        }

        // Cek pelanggan
        $user = Pelanggan::where('email', $email)->first();
        if ($user && \Hash::check($password, $user->password)) {
            session(['pelanggan_id' => $user->id, 'user_role' => 'pelanggan']);
            return redirect()->route('pelanggan.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
} 