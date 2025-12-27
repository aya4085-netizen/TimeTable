<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authControlller extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->with('error', 'بيانات الدخول غير صحيحة')
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('redirect');
    }

    public function redirectByRole(Request $request)
    {
        $role = $request->user()->role;

        return match ($role) {
            'supervisor' => redirect()->route('supervisor.dashboard'),
            'registrar'  => redirect()->route('registrar.dashboard'),
            'teacher'    => redirect()->route('teacher.timetable'), // عدليها لاحقًا
            'student'    => redirect()->route('student.dashboard'), // عدليها لاحقًا
            default      => redirect()->route('dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'تم تسجيل الخروج');
    }
}