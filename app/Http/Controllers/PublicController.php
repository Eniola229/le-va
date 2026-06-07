<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\BrevoMailService;
use App\Services\EmailTemplates;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function __construct(private BrevoMailService $brevo) {}

    public function home()
    {
        $courses = Course::where('status', 'published')
                         ->orderBy('order')
                         ->limit(3)
                         ->get();

        return view('public.home', compact('courses'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function courses()
    {
        $courses = Course::where('status', 'published')
                         ->orderBy('order')
                         ->get();

        return view('public.courses', compact('courses'));
    }

    public function community()
    {
        return view('public.community');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:3000',
        ]);

        // Forward to admin inbox via Brevo
        $subject  = $validated['subject'] ?? "Website Contact from {$validated['name']}";
        $html     = "
            <p><strong>From:</strong> {$validated['name']} &lt;{$validated['email']}&gt;</p>
            <p><strong>Subject:</strong> {$subject}</p>
            <hr style='border:none;border-top:1px solid #e8e0d5;margin:16px 0;'>
            <p style='line-height:1.8;'>" . nl2br(e($validated['message'])) . "</p>
        ";

        $this->brevo->send(
            config('mail.from.address'),
            "Contact: {$subject}",
            app(\App\Services\EmailTemplates::class)::wrap ?? $html  // just send raw html
        );

        // Also send raw — wrap is private, so call send directly
        $this->brevo->send(
            config('mail.from.address'),
            "Contact Form: {$subject}",
            "<html><body style='font-family:Georgia,serif;padding:40px;color:#3d2b1f;'>{$html}</body></html>"
        );

        return back()->with('success', "Your message has been sent. We'll be in touch soon.");
    }
}