{{-- resources/views/layouts/student.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — Lev Av</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/student.css') }}">
  @stack('styles')
</head>
<body>

<div class="student-wrap">

  {{-- Backdrop (mobile) --}}
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  {{-- Sidebar --}}
  <aside class="student-sidebar" id="studentSidebar">

    {{-- Close button — only visible on mobile --}}
    <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">
      <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6"  y1="6" x2="18" y2="18"/>
      </svg>
    </button>

    <div class="sidebar-logo">
      <span class="brand-name">LEV AV</span>
      <span class="brand-sub">My Learning</span>
    </div>

    <nav class="sidebar-nav">

      <a href="{{ route('student.dashboard') }}"
         class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>

      <a href="{{ route('student.courses') }}"
         class="nav-item {{ request()->routeIs('student.courses*') && !request()->routeIs('student.discussions*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19V6a2 2 0 012-2h13a1 1 0 011 1v13"/><path d="M4 19a2 2 0 002 2h13a1 1 0 001-1v-1"/><path d="M8 10h8M8 14h5"/></svg>
        My Courses
      </a>

      <a href="{{ route('courses') }}" class="nav-item">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Browse Courses
      </a>

      {{-- Discussions: link to first enrolled course or # if none --}}
      @php
        $firstCourseId = auth()->user()->enrollments->first()->course_id ?? null;
      @endphp
      @if($firstCourseId)
        <a href="{{ route('student.discussions.index', $firstCourseId) }}"
           class="nav-item {{ request()->routeIs('student.discussions*') ? 'active' : '' }}">
      @else
        <a href="{{ route('student.courses') }}"
           class="nav-item {{ request()->routeIs('student.discussions*') ? 'active' : '' }}">
      @endif
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        Discussions
      </a>

      <a href="{{ route('student.profile') }}"
         class="nav-item {{ request()->routeIs('student.profile*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20v-1a8 8 0 0116 0v1"/></svg>
        My Profile
      </a>

    </nav>

    <div class="sidebar-user-card">
      @if(auth()->user()->profile_photo)
        <img src="{{ auth()->user()->profile_photo }}" alt="{{ auth()->user()->name }}"
             style="width:34px;height:34px;border-radius:50%;object-fit:cover;flex-shrink:0;">
      @else
        <div class="ava">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
      @endif
      <div>
        <div class="uname">{{ auth()->user()->name }}</div>
        <div class="urole">Student</div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout" title="Sign out">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </form>
    </div>
  </aside>

  {{-- Main --}}
  <div class="student-main">
    <header class="student-topbar">
      <button class="topbar-toggle" id="sidebarOpen" aria-label="Open menu">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <span class="topbar-greeting">@yield('page-title', 'Dashboard')</span>
      @yield('topbar-actions')
    </header>

    <div class="student-page">
      @if(session('success'))
        <div class="alert alert-success">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          {{ session('error') }}
        </div>
      @endif

      @yield('content')
    </div>
  </div>

</div>

<script>
  const sidebar  = document.getElementById('studentSidebar');
  const backdrop = document.getElementById('sidebarBackdrop');

  function openSidebar() {
    sidebar.classList.add('open');
    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeSidebar() {
    sidebar.classList.remove('open');
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
  }

  document.getElementById('sidebarOpen').addEventListener('click', openSidebar);
  document.getElementById('sidebarClose').addEventListener('click', closeSidebar);
  backdrop.addEventListener('click', closeSidebar);
</script>

@stack('scripts')
</body>
</html>