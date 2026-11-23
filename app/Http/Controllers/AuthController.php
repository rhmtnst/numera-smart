<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials + ['is_active' => true], $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
            'grade_level' => [
                'required',
                'integer',
                'between:4,6',
            ],
            'school_code' => ['required', 'string', 'exists:school_registration_codes,code'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $registrationCode = \App\Models\SchoolRegistrationCode::where('code', strtoupper(trim($validated['school_code'])))
                ->lockForUpdate()->firstOrFail();
            abort_unless($registrationCode->isUsable() && $registrationCode->school?->status === 'active', 422, 'Kode sekolah tidak aktif, kedaluwarsa, atau kuotanya habis.');

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'student',
                'school_id' => $registrationCode->school_id,
                'is_active' => true,
            ]);
            $user->studentProfile()->create([
                'grade_level' => $validated['grade_level'],
            ]);
            $registrationCode->increment('uses');
            return $user;
        });

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('student.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectByRole()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'student' => redirect()->route('student.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => abort(403, 'Role akun tidak dikenali.'),
        };
    }
}
