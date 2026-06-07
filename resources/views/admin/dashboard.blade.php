@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-1a7 7 0 0114 0v1"/></svg>
    </div>
    <div class="stat-value">{{ $totalStudents }}</div>
    <div class="stat-label">Total Students</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div class="stat-value">{{ $pendingApprovals }}</div>
    <div class="stat-label">Pending Approvals</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19V6a2 2 0 012-2h13a1 1 0 011 1v13"/><path d="M8 10h8M8 14h5"/></svg>
    </div>
    <div class="stat-value">{{ $totalCourses }}</div>
    <div class="stat-label">Courses</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon">
      <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
    </div>
    <div class="stat-value">{{ $totalEnrollments }}</div>
    <div class="stat-label">Enrollments</div>
  </div>
</div>

<div class="dashboard-grid">

  {{-- Pending Approvals --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title">Pending Approvals</span>
      <a href="{{ route('admin.students.index', ['status'=>'pending']) }}" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <div class="card-body table-wrap">
      @if($recentPending->count())
      <table>
        <thead>
          <tr>
            <th>Student</th>
            <th>Applied</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentPending as $student)
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
            <td>
              <div>{{ $student->created_at->format('d M Y') }}</div>
              <div class="cell-muted">{{ $student->created_at->diffForHumans() }}</div>
            </td>
            <td>
              <div style="display:flex;gap:8px;">
                <form method="POST" action="{{ route('admin.students.approve', $student) }}">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm">Approve</button>
                </form>
                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-secondary btn-sm">View</a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <div class="empty-state">
          <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <h3>All caught up</h3>
          <p>No pending approvals at the moment.</p>
        </div>
      @endif
    </div>
  </div>

  {{-- Recent Courses --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title">Recent Courses</span>
      <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">+ New Course</a>
    </div>
    <div class="card-body table-wrap">
      @if($recentCourses->count())
      <table>
        <thead>
          <tr><th>Course</th><th>Students</th><th>Status</th></tr>
        </thead>
        <tbody>
          @foreach($recentCourses as $course)
          <tr>
            <td>
              <div>{{ $course->title }}</div>
              <div class="cell-muted">{{ $course->lesson_count }} lessons</div>
            </td>
            <td>{{ $course->enrollments_count }}</td>
            <td><span class="badge badge-{{ $course->status }}">{{ ucfirst($course->status) }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <div class="empty-state">
          <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 19V6a2 2 0 012-2h13a1 1 0 011 1v13"/></svg>
          <h3>No courses yet</h3>
          <p><a href="{{ route('admin.courses.create') }}">Create your first course</a></p>
        </div>
      @endif
    </div>
  </div>

</div>

@endsection