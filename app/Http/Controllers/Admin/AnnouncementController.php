<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use App\Services\BrevoMailService;
use App\Services\EmailTemplates;
use Illuminate\Http\Request;
 
class AnnouncementController extends Controller
{
    public function __construct(private BrevoMailService $brevo) {}
 
    public function index()
    {
        $announcements = Announcement::with('sender')->latest()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }
 
    public function create()
    {
        return view('admin.announcements.create');
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:200',
            'body'     => 'required|string',
            'audience' => 'required|in:all,enrolled',
        ]);
 
        $validated['sent_by'] = auth()->id();
        $validated['sent_at'] = now();
 
        $announcement = Announcement::create($validated);
 
        // Build recipient list
        $query = User::where('role', 'student')->where('status', 'approved');
        if ($request->audience === 'enrolled') {
            $query->whereHas('enrollments');
        }
 
        $recipients = $query->get()->map(fn($u) => [
            'email' => $u->email,
            'name'  => $u->name,
        ])->toArray();
 
        // Build email body — convert plain text line breaks to <p> tags
        $bodyHtml = implode('', array_map(
            fn($line) => $line ? "<p>{$line}</p>" : '',
            explode("\n", nl2br($announcement->body))
        ));
 
        // Send in batches of 50 (Brevo limit per call)
        $this->brevo->sendBatch(
            $recipients,
            $announcement->title,
            EmailTemplates::announcement('there', $announcement->title, $bodyHtml)
        );
 
        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement sent to ' . count($recipients) . ' students.');
    }
}