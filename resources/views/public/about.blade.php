{{-- resources/views/public/about.blade.php --}}
@extends('layouts.app')
@section('title', 'About')
@section('meta-desc', 'Learn about what Lev Av means, our vision, mission, and the transformation we believe is possible.')

@section('content')

<div style="padding-top:var(--nav-h);">

  {{-- Page Hero --}}
  <section style="padding:80px 0 64px;background:var(--warm-white);border-bottom:1px solid var(--beige);">
    <div class="container" style="max-width:680px;margin:0 auto;text-align:center;">
      <div class="section-label" style="justify-content:center;">Our Story</div>
      <h1 class="section-title">The Heart of the Father</h1>
      <p class="section-sub" style="max-width:100%;text-align:center;">
        Lev Av (לֵב אָב) means "Heart of the Father" in Hebrew — and that is the very place we are inviting you into.
      </p>
    </div>
  </section>

  {{-- What is Lev Av --}}
  <section class="section">
    <div class="container">
      <div class="about-grid">
        <div class="about-content">
          <div class="section-label">The Name</div>
          <h2 class="section-title">What Lev Av Means</h2>
          <p class="section-sub">
            In Hebrew, <em>Lev</em> (לֵב) means heart, and <em>Av</em> (אָב) means father. Together — the heart of the father.
            Our name carries the entire vision: to bring people into a deep, experiential encounter with the fatherly love of God.
          </p>
          <p class="section-sub" style="margin-top:16px;">
            We believe that true transformation doesn't come from information alone — it comes from encounter.
            From sitting in the presence of God and allowing His love to reach places in us that nothing else can touch.
          </p>
        </div>
        <div class="about-image">
          <img
            src="https://i.pinimg.com/736x/46/ed/5e/46ed5e6ec96e7511fe9e8e0d43dd00ae.jpg"
            alt="Lev Av"
            style="width:100%;height:100%;object-fit:cover;object-position:center top;">
        </div>
      </div>
    </div>
  </section>

  {{-- Vision & Mission --}}
  <section class="section" style="background:var(--warm-white);">
    <div class="container">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;">
        <div style="padding:40px;background:var(--cream);border-radius:var(--radius);border:1px solid var(--beige);">
          <div class="section-label">Our Vision</div>
          <h3 class="section-title" style="font-size:26px;">A generation living from the heart of God.</h3>
          <p style="color:var(--text-muted);line-height:1.9;">
            We envision a generation of men and women who don't just know about God, but who live deeply connected to Him —
            whose decisions, relationships, and sense of identity are shaped by His love and His word.
          </p>
        </div>
        <div style="padding:40px;background:var(--cream);border-radius:var(--radius);border:1px solid var(--beige);">
          <div class="section-label">Our Mission</div>
          <h3 class="section-title" style="font-size:26px;">To create space for depth, encounter, and growth.</h3>
          <p style="color:var(--text-muted);line-height:1.9;">
            Through teaching, courses, and community, we create intentional spaces where people can slow down, go deep,
            and experience genuine spiritual transformation — not just spiritual information.
          </p>
        </div>
      </div>
    </div>
  </section>

  {{-- Why Lev Av exists --}}
  <section class="section">
    <div class="container" style="max-width:760px;margin:0 auto;text-align:center;">
      <div class="section-label" style="justify-content:center;">Why We Exist</div>
      <h2 class="section-title">We exist because hunger deserves a home.</h2>
      <p class="section-sub" style="max-width:100%;text-align:center;margin:0 auto 20px;">
        There are people all over the world who are hungry for more of God — more depth, more encounter, more truth.
        Lev Av exists to be a home for that hunger. A place that honours the longing in your heart and says:
        <em>come, there is more.</em>
      </p>
      <p class="section-sub" style="max-width:100%;text-align:center;margin:0 auto;">
        We are not a church. We are not a ministry in the traditional sense. We are a learning community —
        built around the Word, saturated in prayer, and committed to real, lasting transformation.
      </p>
    </div>
  </section>

  {{-- Transformation section --}}
  <section class="section" style="background:var(--warm-white);">
    <div class="container">
      <div style="text-align:center;margin-bottom:48px;">
        <div class="section-label" style="justify-content:center;">The Journey</div>
        <h2 class="section-title">The transformation we believe is possible</h2>
      </div>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:24px;">
        @php $transforms = [
          ['from'=>'Head knowledge','to'=>'Heart encounter'],
          ['from'=>'Religious routine','to'=>'Intimate relationship'],
          ['from'=>'Striving','to'=>'Rest in His love'],
          ['from'=>'Isolation','to'=>'Rooted community'],
        ]; @endphp
        @foreach($transforms as $t)
        <div style="padding:28px 24px;background:var(--cream);border:1px solid var(--beige);border-radius:var(--radius);text-align:center;">
          <div style="font-size:13px;color:var(--text-hint);margin-bottom:10px;text-decoration:line-through;">{{ $t['from'] }}</div>
          <div style="width:1px;height:28px;background:var(--gold);margin:0 auto 10px;"></div>
          <div style="font-family:var(--font-serif);font-size:18px;color:var(--brown-dark);">{{ $t['to'] }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- CTA --}}
  <section class="section-sm" style="background:var(--brown-deep);">
    <div class="container" style="text-align:center;">
      <h2 style="font-family:var(--font-serif);font-size:clamp(24px,3vw,38px);font-weight:300;color:var(--gold-light);margin-bottom:12px;">
        Ready to begin?
      </h2>
      <p style="color:rgba(255,255,255,0.5);font-size:15px;margin-bottom:32px;">
        Your journey into the heart of God starts with one step.
      </p>
      <a href="{{ route('register') }}" class="btn-gold">Apply to Join Lev Av</a>
    </div>
  </section>

</div>

@endsection