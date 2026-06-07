<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput(['email' => $request->email])
                ->with('error', 'These credentials do not match our records.');
        }

        $user = Auth::user();

        // Block pending/rejected accounts
        if ($user->status === 'pending') {
            Auth::logout();
            return back()->with('error', 'Your account is pending approval. We will notify you by email.');
        }

        if ($user->status === 'rejected') {
            Auth::logout();
            return back()->with('error', 'Your application was not approved. Please contact us for more information.');
        }

        $request->session()->regenerate();

        // Redirect by role
        return redirect()->intended(
            $user->isAdmin()
                ? route('admin.dashboard')
                : route('student.dashboard')
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}