<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Come to the Heart of God') — Lev Av</title>
  <meta name="description" content="@yield('meta-desc', 'Lev Av is a place of spiritual growth, deep biblical learning, and intimate transformation.')">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/public.css') }}">
  @stack('styles')
</head>
<body>

{{-- Navigation --}}
<nav class="nav" id="mainNav">
  <div class="container">

    {{-- Logo always left --}}
    <a href="{{ route('home') }}" class="nav-logo">
      LEV AV
      <span>Come to the Heart of God</span>
    </a>

    {{-- Desktop links — centre/right, hidden on mobile --}}
    <div class="nav-links">
      <a href="{{ route('home') }}"      class="{{ request()->routeIs('home')      ? 'active' : '' }}">Home</a>
      <a href="{{ route('about') }}"     class="{{ request()->routeIs('about')     ? 'active' : '' }}">About</a>
      <a href="{{ route('courses') }}"   class="{{ request()->routeIs('courses')   ? 'active' : '' }}">Courses</a>
      <a href="{{ route('community') }}" class="{{ request()->routeIs('community') ? 'active' : '' }}">Community</a>
      <a href="{{ route('contact') }}"   class="{{ request()->routeIs('contact')   ? 'active' : '' }}">Contact</a>
      @auth
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('student.dashboard') }}"
           class="nav-cta">My Account</a>
      @else
        <a href="{{ route('login') }}">Sign In</a>
        <a href="{{ route('register') }}" class="nav-cta">Join Community</a>
      @endauth
    </div>

    {{-- Hamburger — pushed to far right via margin-left:auto --}}
    <button class="nav-toggle" id="navToggle" aria-label="Open menu">
      <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <line x1="3" y1="6"  x2="21" y2="6"/>
        <line x1="3" y1="12" x2="21" y2="12"/>
        <line x1="3" y1="18" x2="21" y2="18"/>
      </svg>
    </button>

  </div>
</nav>

{{-- Mobile Menu overlay --}}
<div class="mobile-menu" id="mobileMenu">

  {{-- Close button top-right --}}
  <button class="mobile-menu-close" id="menuClose" aria-label="Close menu">
    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <line x1="18" y1="6" x2="6" y2="18"/>
      <line x1="6"  y1="6" x2="18" y2="18"/>
    </svg>
  </button>

  <div class="mobile-menu-brand">LEV AV</div>

  <a href="{{ route('home') }}"      onclick="closeMobileMenu()">Home</a>
  <a href="{{ route('about') }}"     onclick="closeMobileMenu()">About</a>
  <a href="{{ route('courses') }}"   onclick="closeMobileMenu()">Courses</a>
  <a href="{{ route('community') }}" onclick="closeMobileMenu()">Community</a>
  <a href="{{ route('contact') }}"   onclick="closeMobileMenu()">Contact</a>

  @auth
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('student.dashboard') }}"
       onclick="closeMobileMenu()">My Account</a>
  @else
    <a href="{{ route('login') }}"    onclick="closeMobileMenu()">Sign In</a>
    <a href="{{ route('register') }}" onclick="closeMobileMenu()" class="mobile-cta">Join Community →</a>
  @endauth
</div>

{{-- Backdrop --}}
<div class="mobile-backdrop" id="mobileBackdrop"></div>

@yield('content')

{{-- Footer --}}
<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">LEV AV</div>
        <p class="footer-tagline">A place of spiritual growth, deep biblical learning, and intimate transformation.</p>
      </div>
      <div class="footer-col">
        <h4>Navigate</h4>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('about') }}">About</a>
        <a href="{{ route('courses') }}">Courses</a>
        <a href="{{ route('community') }}">Community</a>
      </div>
      <div class="footer-col">
        <h4>Learn</h4>
        <a href="{{ route('courses') }}">All Courses</a>
        <a href="{{ route('register') }}">Apply Now</a>
        <a href="{{ route('login') }}">Student Login</a>
      </div>
      <div class="footer-col">
        <h4>Connect</h4>
        <a href="{{ route('contact') }}">Contact Us</a>
        <a href="#">Instagram</a>
        <a href="#">YouTube</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© {{ date('Y') }} Lev Av. All rights reserved.</p>
      <a href="#">Privacy Policy</a>
    </div>
  </div>
</footer>

<script>
  // ── Sticky nav ──────────────────────────────────────────
  const nav = document.getElementById('mainNav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  });

  // ── Mobile menu ─────────────────────────────────────────
  const menu     = document.getElementById('mobileMenu');
  const backdrop = document.getElementById('mobileBackdrop');

  function openMobileMenu() {
    menu.classList.add('open');
    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileMenu() {
    menu.classList.remove('open');
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.getElementById('navToggle').addEventListener('click', openMobileMenu);
  document.getElementById('menuClose').addEventListener('click', closeMobileMenu);
  backdrop.addEventListener('click', closeMobileMenu);
</script>

@stack('scripts')
</body>
</html>