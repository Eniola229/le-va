<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function show()
    {
        $user = auth()->user()->load('enrollments.course');
        $completions = \App\Models\LessonCompletion::where('user_id', $user->id)->count();
        return view('student.profile', compact('user', 'completions'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $isAjax = $request->ajax() || $request->wantsJson();

        try {
            if ($request->hasFile('profile_photo')) {
                // Validate the photo
                $request->validate([
                    'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:3072'
                ]);

                // Upload to Cloudinary
                $upload = $this->cloudinary->uploadImage(
                    $request->file('profile_photo'),
                    'lev-av/avatars'
                );
                
                // Update user's profile photo
                $user->profile_photo = $upload['url'];
                $user->save();
                
                if ($isAjax) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Profile photo updated successfully!',
                        'photo_url' => $user->profile_photo
                    ]);
                }
                
                return back()->with('success', 'Profile photo updated successfully!');
            }
            
            // Handle regular profile update
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'phone' => 'nullable|string|max:30',
                'country' => 'nullable|string|max:100',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
            ]);

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully!'
                ]);
            }

            return back()->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully!');
    }
}