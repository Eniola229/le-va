@extends('layouts.admin')
@section('title', 'Admins')
@section('page-title', 'Admins')

@section('topbar-actions')
  <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">+ Add Admin</a>
@endsection

@section('content')

@if(session('success'))
  <div class="alert alert-success" style="margin-bottom:20px;">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-error" style="margin-bottom:20px;">{{ session('error') }}</div>
@endif

<div class="card">
  <div class="card-body table-wrap">
    @if($admins->count())
    <table>
      <thead>
        <tr>
          <th>Admin</th>
          <th>Email</th>
          <th>Joined</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($admins as $admin)
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:12px;">
              @if($admin->profile_photo)
                <img src="{{ $admin->profile_photo }}" alt="{{ $admin->name }}"
                     style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;">
              @else
                <div style="width:36px;height:36px;border-radius:50%;background:var(--ivory);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:var(--beige-mid);">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                  </svg>
                </div>
              @endif
              <div>
                <div style="font-weight:500;">{{ $admin->name }}</div>
                @if($admin->id === auth()->id())
                  <div class="cell-muted">You</div>
                @endif
              </div>
            </div>
          </td>
          <td>{{ $admin->email }}</td>
          <td>{{ $admin->created_at->format('d M Y') }}</td>
          <td>
            @if($admin->id !== auth()->id())
            <form method="POST" action="{{ route('admin.admins.destroy', $admin) }}">
              @csrf @method('DELETE')
              <button type="submit" class="btn-icon" title="Remove Admin"
                      style="color:var(--danger);"
                      onclick="return confirm('Remove {{ addslashes($admin->name) }} as an admin?')">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <polyline points="3 6 5 6 21 6"/>
                  <path d="M19 6l-1 14H6L5 6"/>
                  <path d="M10 11v6M14 11v6"/>
                </svg>
              </button>
            </form>
            @else
              <span style="color:var(--text-hint);font-size:12px;">—</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
      <span class="page-info">{{ $admins->count() }} admin{{ $admins->count() !== 1 ? 's' : '' }} total</span>
    </div>
    @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 00-3-3.87"/>
          <path d="M16 3.13a4 4 0 010 7.75"/>
        </svg>
        <h3>No admins yet</h3>
        <p><a href="{{ route('admin.admins.create') }}">Add the first admin</a> to get started.</p>
      </div>
    @endif
  </div>
</div>

@endsection