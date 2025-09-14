<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'employee' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'family_count' => 'required|integer|min:0|max:20',
            'birth_date' => 'required|date|before:today',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        $defaultUserType = UserType::where('name', 'Traveler')->first()
            ?? UserType::first();

        $user = User::create([
            'uuid' => Str::uuid(),
            'user_type_id' => $defaultUserType->id,
            'username' => $request->username,
            'email' => $request->username . '@seoulstay.com',
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'name' => $request->full_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'family_count' => $request->family_count,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}