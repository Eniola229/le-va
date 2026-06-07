{{-- resources/views/public/contact.blade.php --}}
@extends('layouts.app')
@section('title', 'Contact')
@section('meta-desc', 'Get in touch with the Lev Av team. We would love to hear from you.')

@section('content')

<div style="padding-top:var(--nav-h);">

  {{-- Page Hero --}}
  <section style="padding:80px 0 56px;background:var(--warm-white);border-bottom:1px solid var(--beige);">
    <div class="container" style="max-width:680px;margin:0 auto;text-align:center;">
      <div class="section-label" style="justify-content:center;">Reach Out</div>
      <h1 class="section-title">Get in Touch</h1>
      <p class="section-sub" style="text-align:center;">
        We'd love to hear from you. Whether you have questions, want to apply, or simply want to connect — reach out.
      </p>
    </div>
  </section>

  {{-- Contact body --}}
  <section class="section">
    <div class="container">
      <div class="contact-grid">

        {{-- Form --}}
        <div class="contact-form">

          @if(session('success'))
            <div style="padding:14px 18px;background:#f0f7f1;color:#5a8a5e;border:1px solid #c3dbc5;border-radius:6px;margin-bottom:24px;font-size:14px;display:flex;align-items:center;gap:10px;">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              {{ session('success') }}
            </div>
          @endif

          <h3 style="font-family:var(--font-serif);font-size:22px;font-weight:400;margin-bottom:6px;">Send a Message</h3>
          <div style="width:32px;height:1px;background:var(--gold);margin:10px 0 24px;"></div>

          <form method="POST" action="{{ route('contact.send') }}">
            @csrf

            <div class="form-group">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control"
                     value="{{ old('name') }}" required placeholder="Your full name">
              @error('name')<div style="font-size:12px;color:#c0392b;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label class="form-label">Email Address</label>
              <input type="email" name="email" class="form-control"
                     value="{{ old('email') }}" required placeholder="your@email.com">
              @error('email')<div style="font-size:12px;color:#c0392b;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control"
                     value="{{ old('subject') }}" placeholder="What is this about?">
            </div>

            <div class="form-group">
              <label class="form-label">Message</label>
              <textarea name="message" class="form-control" required
                        placeholder="Write your message here…">{{ old('message') }}</textarea>
              @error('message')<div style="font-size:12px;color:#c0392b;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
              Send Message
            </button>
          </form>
        </div>

        {{-- Info side --}}
        <div class="contact-info">
          <div class="section-label">Contact Info</div>
          <h2 class="section-title" style="font-size:30px;">We're here for you.</h2>
          <p style="color:var(--text-muted);line-height:1.9;margin-bottom:36px;">
            Whether you have questions about our courses, need help with your account, or simply want to
            know more about Lev Av — don't hesitate to reach out. We read every message personally.
          </p>

          <div class="contact-detail">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="color:var(--gold);flex-shrink:0;">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
            <p>hello@levav.com</p>
          </div>

          <div class="contact-detail">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="color:var(--gold);flex-shrink:0;">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <p>We typically respond within 1–2 business days.</p>
          </div>

          {{-- Divider --}}
          <div style="width:100%;height:1px;background:var(--beige);margin:32px 0;"></div>

          <div style="font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-hint);margin-bottom:14px;">
            Follow Us
          </div>
          <div class="social-links">
            <a href="#" class="social-link" title="Instagram">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5"/>
                <circle cx="12" cy="12" r="4"/>
                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
              </svg>
            </a>
            <a href="#" class="social-link" title="YouTube">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/>
                <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="none"/>
              </svg>
            </a>
            <a href="#" class="social-link" title="Facebook">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
              </svg>
            </a>
          </div>

          {{-- Quick links --}}
          <div style="margin-top:40px;">
            <div style="font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-hint);margin-bottom:14px;">
              Quick Links
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
              <a href="{{ route('register') }}" style="font-size:14px;color:var(--brown);display:flex;align-items:center;gap:6px;">
                <span style="color:var(--gold);">→</span> Apply to join Lev Av
              </a>
              <a href="{{ route('courses') }}" style="font-size:14px;color:var(--brown);display:flex;align-items:center;gap:6px;">
                <span style="color:var(--gold);">→</span> Browse our courses
              </a>
              <a href="{{ route('about') }}" style="font-size:14px;color:var(--brown);display:flex;align-items:center;gap:6px;">
                <span style="color:var(--gold);">→</span> Learn about Lev Av
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

</div>

@endsection