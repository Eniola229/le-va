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
    <a href="{{ route('home') }}" class="nav-logo">
      LEV AV
      <span>Come to the Heart of God</span>
    </a>
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
    <button class="nav-toggle" id="navToggle">
      <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
  </div>
</nav>

{{-- Mobile Menu --}}
<div class="mobile-menu" id="mobileMenu">
  <button class="close" id="menuClose">✕</button>
  <a href="{{ route('home') }}">Home</a>
  <a href="{{ route('about') }}">About</a>
  <a href="{{ route('courses') }}">Courses</a>
  <a href="{{ route('community') }}">Community</a>
  <a href="{{ route('contact') }}">Contact</a>
  @auth
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('student.dashboard') }}">My Account</a>
  @else
    <a href="{{ route('login') }}">Sign In</a>
    <a href="{{ route('register') }}" style="color:var(--brown-dark);font-weight:500;">Join Community →</a>
  @endauth
</div>

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
  // Sticky nav
  const nav = document.getElementById('mainNav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  });
  // Mobile menu
  document.getElementById('navToggle').onclick  = () => document.getElementById('mobileMenu').classList.add('open');
  document.getElementById('menuClose').onclick  = () => document.getElementById('mobileMenu').classList.remove('open');
</script>
@stack('scripts')
</body>
</html>



