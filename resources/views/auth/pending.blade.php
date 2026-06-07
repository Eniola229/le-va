{{-- resources/views/auth/pending.blade.php --}}
@extends('layouts.app')
@section('title', 'Application Received')

@section('content')

<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:32px;background:var(--cream);">
  <div style="background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius);padding:60px 48px;text-align:center;max-width:500px;width:100%;">

    {{-- Icon --}}
    <div style="width:68px;height:68px;border-radius:50%;background:var(--gold-light);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
      <svg width="30" height="30" fill="none" stroke="var(--brown-dark)" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
        <polyline points="22 4 12 14.01 9 11.01"/>
      </svg>
    </div>

    {{-- Brand --}}
    <div style="font-family:var(--font-serif);font-size:14px;letter-spacing:4px;color:var(--gold);margin-bottom:20px;">
      LEV AV
    </div>

    <h1 style="font-family:var(--font-serif);font-size:28px;font-weight:400;color:var(--brown-deep);margin-bottom:8px;">
      Application Received
    </h1>

    <div style="width:36px;height:1px;background:var(--gold);margin:16px auto 24px;"></div>

    <p style="font-size:15px;color:var(--text-muted);line-height:1.8;margin-bottom:12px;">
      Thank you, <strong style="color:var(--text);">{{ session('name', 'friend') }}</strong>.
      We've received your application and will review it personally.
    </p>

    <p style="font-size:15px;color:var(--text-muted);line-height:1.8;margin-bottom:36px;">
      You'll receive an email once your account has been approved — usually within 1–2 business days.
      We look forward to welcoming you.
    </p>

    <div style="display:flex;flex-direction:column;gap:10px;align-items:center;">
      <a href="{{ route('home') }}" class="btn-primary" style="display:inline-block;min-width:180px;text-align:center;">
        Back to Home
      </a>
      <a href="{{ route('contact') }}" style="font-size:13px;color:var(--text-hint);margin-top:4px;">
        Have a question? Contact us
      </a>
    </div>

  </div>
</div>

@endsection