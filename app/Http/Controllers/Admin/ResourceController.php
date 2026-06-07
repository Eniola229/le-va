<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Resource;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary) {}

    public function store(Request $request, Lesson $lesson)
    {
        $request->validate([
            'resource_files.*' => 'required|file|max:20480', // 20MB
        ]);

        foreach ($request->file('resource_files', []) as $file) {
            $upload = $this->cloudinary->uploadDocument($file, 'lev-av/resources');
            
            Resource::create([
                'lesson_id'   => $lesson->id,
                'course_id'   => $lesson->course_id,
                'title'       => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_url'    => $upload['url'],
                'file_public_id' => $upload['public_id'],
                'file_type'   => $file->getClientOriginalExtension(),
                'file_size'   => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Resources uploaded.');
    }

    public function destroy(Resource $resource)
    {
        $this->cloudinary->delete($resource->file_public_id, 'raw');
        $resource->delete();
        return back()->with('success', 'Resource removed.');
    }
}