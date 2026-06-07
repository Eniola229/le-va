{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin') — Lev Av</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  @stack('styles')
</head>
<body>

<div class="admin-wrap">

  {{-- Backdrop (mobile) --}}
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  {{-- Sidebar --}}
  <aside class="sidebar" id="sidebar">

    {{-- Close button — only visible on mobile --}}
    <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">
      <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6"  y1="6" x2="18" y2="18"/>
      </svg>
    </button>

    <div class="sidebar-logo">
      <span class="brand-name">LEV AV</span>
      <span class="brand-sub">Admin Panel</span>
    </div>

    <nav class="sidebar-nav">
      <span class="nav-section-label">Overview</span>

      <a href="{{ route('admin.dashboard') }}"
         class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        Dashboard
      </a>

      <span class="nav-section-label">People</span>

      <a href="{{ route('admin.students.index') }}"
         class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-1a7 7 0 0114 0v1"/><path d="M22 21v-1a5 5 0 00-4-4.9"/><circle cx="19" cy="7" r="3"/></svg>
        Students
        @php $pending = \App\Models\User::where('status','pending')->where('role','student')->count(); @endphp
        @if($pending > 0)
          <span class="badge">{{ $pending }}</span>
        @endif
      </a>

      <a href="{{ route('admin.admins.index') }}"
         class="nav-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20v-1a8 8 0 0116 0v1"/></svg>
        Admins
      </a>

      <span class="nav-section-label">Content</span>

      <a href="{{ route('admin.courses.index') }}"
         class="nav-item {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.lessons.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19V6a2 2 0 012-2h13a1 1 0 011 1v13"/><path d="M4 19a2 2 0 002 2h13a1 1 0 001-1v-1"/><path d="M8 10h8M8 14h5"/></svg>
        Courses
      </a>

      <span class="nav-section-label">Communication</span>

      <a href="{{ route('admin.announcements.index') }}"
         class="nav-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        Announcements
      </a>

      <a href="{{ route('admin.discussions.index') }}"
         class="nav-item {{ request()->routeIs('admin.discussions.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        Discussions
      </a>

      <span class="nav-section-label">Account</span>

      <a href="{{ route('admin.profile') }}"
         class="nav-item {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20v-1a8 8 0 0116 0v1"/></svg>
        My Profile
      </a>
    </nav>

    <div class="sidebar-footer">
      @if(auth()->user()->profile_photo)
        <img src="{{ auth()->user()->profile_photo }}" alt="{{ auth()->user()->name }}"
             style="width:34px;height:34px;border-radius:50%;object-fit:cover;flex-shrink:0;">
      @else
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
      @endif
      <div>
        <div class="user-name">{{ auth()->user()->name }}</div>
        <div class="user-role">Administrator</div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn" title="Sign out">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </button>
      </form>
    </div>
  </aside>

  {{-- Main --}}
  <div class="main">
    <header class="topbar">
      <button class="sidebar-toggle" id="sidebarOpen" aria-label="Open menu">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
      <div class="topbar-actions">@yield('topbar-actions')</div>
    </header>

    <div class="page-body">
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
  const sidebar  = document.getElementById('sidebar');
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