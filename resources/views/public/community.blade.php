{{-- resources/views/public/community.blade.php --}}
@extends('layouts.app')
@section('title', 'Community')
@section('meta-desc', 'Join the Lev Av community — a place of prayer, accountability, spiritual growth, and live sessions.')

@section('content')

<div style="padding-top:var(--nav-h);">

  {{-- Page Hero --}}
  <section style="padding:80px 0 56px;background:var(--warm-white);border-bottom:1px solid var(--beige);">
    <div class="container" style="max-width:680px;margin:0 auto;text-align:center;">
      <div class="section-label" style="justify-content:center;">Together</div>
      <h1 class="section-title">The Lev Av Community</h1>
      <p class="section-sub" style="text-align:center;">
        You were not meant to journey alone. This is a place to grow, be known, and go deeper — together.
      </p>
    </div>
  </section>

  {{-- Community pillars --}}
  <section class="section">
    <div class="container">
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;margin-bottom:64px;">

        <div style="padding:36px 28px;background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius);">
          <div style="width:44px;height:44px;border-radius:10px;background:var(--gold-light);display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
            <svg width="22" height="22" fill="none" stroke="var(--brown)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
          </div>
          <h3 style="font-family:var(--font-serif);font-size:20px;font-weight:400;margin-bottom:10px;">Prayer Culture</h3>
          <p style="font-size:14px;color:var(--text-muted);line-height:1.8;">
            We are a community built on prayer. Regular prayer sessions, shared prayer requests,
            and a culture of seeking God together — not just learning about Him.
          </p>
        </div>

        <div style="padding:36px 28px;background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius);">
          <div style="width:44px;height:44px;border-radius:10px;background:var(--gold-light);display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
            <svg width="22" height="22" fill="none" stroke="var(--brown)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
          </div>
          <h3 style="font-family:var(--font-serif);font-size:20px;font-weight:400;margin-bottom:10px;">Accountability</h3>
          <p style="font-size:14px;color:var(--text-muted);line-height:1.8;">
            Grow alongside others who will encourage you, challenge you, and walk with you in your faith journey.
            Real community means real accountability.
          </p>
        </div>

        <div style="padding:36px 28px;background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius);">
          <div style="width:44px;height:44px;border-radius:10px;background:var(--gold-light);display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
            <svg width="22" height="22" fill="none" stroke="var(--brown)" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
          </div>
          <h3 style="font-family:var(--font-serif);font-size:20px;font-weight:400;margin-bottom:10px;">Live Sessions</h3>
          <p style="font-size:14px;color:var(--text-muted);line-height:1.8;">
            Join live teaching sessions, Q&As, and community gatherings that bring us together in real time —
            regardless of where you are in the world.
          </p>
        </div>

        <div style="padding:36px 28px;background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius);">
          <div style="width:44px;height:44px;border-radius:10px;background:var(--gold-light);display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
            <svg width="22" height="22" fill="none" stroke="var(--brown)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3 style="font-family:var(--font-serif);font-size:20px;font-weight:400;margin-bottom:10px;">Spiritual Growth</h3>
          <p style="font-size:14px;color:var(--text-muted);line-height:1.8;">
            Resources, teachings, and community intentionally designed to help you grow deeper in God —
            in every season of life.
          </p>
        </div>

      </div>

      {{-- What community looks like --}}
      <div style="background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius);padding:56px 48px;text-align:center;margin-bottom:48px;">
        <div class="section-label" style="justify-content:center;">What to expect</div>
        <h2 class="section-title">Community that goes beyond a platform</h2>
        <p class="section-sub" style="text-align:center;margin:0 auto 40px;">
          Lev Av community is not just a membership or a comment section.
          It is a living, breathing group of people intentionally pursuing God together.
        </p>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;max-width:800px;margin:0 auto;">
          @php $expects = [
            'Weekly live teachings',
            'Prayer groups',
            'Course discussions',
            'Announcements & updates',
            'Seasonal events',
            'One-on-one accountability',
          ]; @endphp
          @foreach($expects as $item)
          <div style="padding:14px 16px;background:var(--cream);border-radius:8px;font-size:14px;color:var(--text-muted);display:flex;align-items:center;gap:8px;">
            <span style="color:var(--gold);flex-shrink:0;">✦</span>
            {{ $item }}
          </div>
          @endforeach
        </div>
      </div>

      {{-- CTA banner --}}
      <div class="community-banner">
        <div>
          <h2>Ready to be part of something real?</h2>
          <p>
            Apply to join Lev Av and become part of a community that is genuinely pursuing God together —
            with depth, intention, and love.
          </p>
        </div>
        <div class="cta-stack">
          <a href="{{ route('register') }}" class="btn-gold">Apply Now</a>
          <a href="{{ route('contact') }}" class="btn-ghost">Ask a Question</a>
        </div>
      </div>

    </div>
  </section>

</div>

@endsection