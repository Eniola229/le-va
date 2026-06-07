<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BrevoMailService;
use App\Services\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function __construct(private BrevoMailService $brevo) {}

    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $newAdmin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
            'status'   => 'approved',
        ]);

        // Notify new admin
        $this->brevo->send(
            ['email' => $newAdmin->email, 'name' => $newAdmin->name],
            'You have been added as a Lev Av Admin',
            EmailTemplates::registrationApproved($newAdmin->name, route('login'))
        );

        return redirect()->route('admin.admins.index')
                         ->with('success', "{$newAdmin->name} has been added as an admin.");
    }

    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot remove your own admin account.');
        }

        $user->delete();

        return back()->with('success', 'Admin account removed.');
    }
}



