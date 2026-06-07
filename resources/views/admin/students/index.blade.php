{{-- resources/views/admin/students/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Students')
@section('page-title', 'Students')

@section('topbar-actions')
  <div style="display:flex;gap:8px;align-items:center;">
    <form method="GET" style="display:flex;gap:8px;">
      <input type="text" name="search" class="form-control" placeholder="Search students…"
             value="{{ request('search') }}" style="width:220px;padding:8px 12px;">
      <select name="status" class="form-control" style="width:140px;padding:8px 12px;" onchange="this.form.submit()">
        <option value="">All Status</option>
        <option value="pending"  {{ request('status')=='pending'  ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </form>
  </div>
@endsection

@section('content')

<div class="card">
  <div class="card-body table-wrap">
    @if($students->count())
    <table>
      <thead>
        <tr>
          <th>Student</th>
          <th>Country</th>
          <th>Enrolled In</th>
          <th>Status</th>
          <th>Registered</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $student)
        <tr>
          <td>
            <div class="student-meta">
              <div class="student-avatar">{{ strtoupper(substr($student->name,0,2)) }}</div>
              <div>
                <div class="student-name">{{ $student->name }}</div>
                <div class="student-email">{{ $student->email }}</div>
              </div>
            </div>
          </td>
          <td>{{ $student->country ?? '—' }}</td>
          <td>{{ $student->enrollments_count }} course(s)</td>
          <td><span class="badge badge-{{ $student->status }}">{{ ucfirst($student->status) }}</span></td>
          <td>
            <div>{{ $student->created_at->format('d M Y') }}</div>
            <div class="cell-muted">{{ $student->created_at->diffForHumans() }}</div>
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.students.show', $student) }}" class="btn-icon" title="View">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>
              @if($student->status === 'pending')
              <form method="POST" action="{{ route('admin.students.approve', $student) }}">
                @csrf
                <button type="submit" class="btn-icon" title="Approve" style="color:var(--success);">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </button>
              </form>
              <form method="POST" action="{{ route('admin.students.reject', $student) }}">
                @csrf
                <button type="submit" class="btn-icon" title="Reject" style="color:var(--danger);"
                  onclick="return confirm('Reject this student?')">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
      {{ $students->withQueryString()->links('components.pagination') }}
      <span class="page-info">{{ $students->total() }} students total</span>
    </div>
    @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-1a7 7 0 0114 0v1"/></svg>
        <h3>No students found</h3>
        <p>Try adjusting your search or filter.</p>
      </div>
    @endif
  </div>
</div>

@endsection
