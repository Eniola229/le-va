<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function show()
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => ['required','email', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => 'nullable|image|max:3072',
        ]);

        if ($request->hasFile('profile_photo')) {
            $upload = $this->cloudinary->uploadImage($request->file('profile_photo'), 'lev-av/avatars');
            $user->profile_photo = $upload['url'];
        }

        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'profile_photo' => $user->profile_photo,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}


