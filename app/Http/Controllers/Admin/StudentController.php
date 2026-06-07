<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BrevoMailService;
use App\Services\EmailTemplates;
use Illuminate\Http\Request;
 
class StudentController extends Controller
{
    public function __construct(private BrevoMailService $brevo) {}
 
    public function index(Request $request)
    {
        $students = User::where('role', 'student')
            ->withCount('enrollments')
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);
 
        return view('admin.students.index', compact('students'));
    }
 
    public function show(User $user)
    {
        $user->load('enrollments.course');
        return view('admin.students.show', ['student' => $user]);
    }
 
    public function approve(User $user)
    {
        $user->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);
 
        $this->brevo->send(
            ['email' => $user->email, 'name' => $user->name],
            "You're Approved — Welcome to Lev Av",
            EmailTemplates::registrationApproved($user->name, route('login'))
        );
 
        return back()->with('success', "{$user->name} has been approved and notified.");
    }
 
    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);
 
        $this->brevo->send(
            ['email' => $user->email, 'name' => $user->name],
            'Your Lev Av Application',
            EmailTemplates::registrationRejected($user->name)
        );
 
        return back()->with('success', "{$user->name}'s application has been rejected.");
    }
}