<?php

namespace App\Http\Controllers\Auth;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BrevoMailService;
use App\Services\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class RegisterController extends Controller
{
    public function __construct(private BrevoMailService $brevo) {}
 
    public function showForm()
    {
        return view('auth.register');
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|string|min:8|confirmed',
            'phone'                 => 'nullable|string|max:30',
            'country'               => 'nullable|string|max:100',
            'why_join'              => 'nullable|string|max:1000',
        ]);
 
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone'    => $validated['phone'] ?? null,
            'country'  => $validated['country'] ?? null,
            'why_join' => $validated['why_join'] ?? null,
            'role'     => 'student',
            'status'   => 'pending',
        ]);
 
        // Email student: application received
        $this->brevo->send(
            ['email' => $user->email, 'name' => $user->name],
            'Your Lev Av Application Has Been Received',
            EmailTemplates::registrationReceived($user->name)
        );
 
        // Email all admins: new application to review
        $reviewUrl = route('admin.students.show', $user);
        $admins    = User::where('role', 'admin')->where('status', 'approved')->get();
 
        foreach ($admins as $admin) {
            $this->brevo->send(
                ['email' => $admin->email, 'name' => $admin->name],
                "New Application — {$user->name}",
                EmailTemplates::adminNewStudent($user->name, $user->email, $reviewUrl)
            );
        }
 
        return redirect()->route('register.pending')->with('name', $user->name);
    }
}

