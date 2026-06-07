@extends('layouts.admin')
@section('title', $student->name)
@section('page-title', $student->name)

@section('topbar-actions')
  <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm">← Back</a>
  @if($student->status === 'pending')
    <form method="POST" action="{{ route('admin.students.approve', $student) }}" style="display:inline;">
      @csrf
      <button type="submit" class="btn btn-success btn-sm">Approve Student</button>
    </form>
    <form method="POST" action="{{ route('admin.students.reject', $student) }}" style="display:inline;">
      @csrf
      <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('Reject this student?')">Reject</button>
    </form>
  @endif
@endsection

@section('content')

<div style="display:grid;grid-template-columns:340px 1fr;gap:24px;">

  {{-- Profile Card --}}
  <div>
    <div class="card" style="margin-bottom:20px;">
      <div style="padding:28px;text-align:center;border-bottom:1px solid var(--ivory);">
        <div class="student-avatar" style="width:64px;height:64px;font-size:22px;margin:0 auto 12px;">
          {{ strtoupper(substr($student->name,0,2)) }}
        </div>
        <h2 style="font-family:var(--font-serif);font-size:20px;font-weight:400;margin-bottom:4px;">{{ $student->name }}</h2>
        <p style="font-size:13px;color:var(--text-hint);">{{ $student->email }}</p>
        <div style="margin-top:12px;">
          <span class="badge badge-{{ $student->status }}">{{ ucfirst($student->status) }}</span>
        </div>
      </div>
      <div style="padding:20px;">
        <table style="width:100%;font-size:13px;">
          <tr>
            <td style="color:var(--text-hint);padding:6px 0;">Country</td>
            <td style="text-align:right;padding:6px 0;">{{ $student->country ?? '—' }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-hint);padding:6px 0;">Phone</td>
            <td style="text-align:right;padding:6px 0;">{{ $student->phone ?? '—' }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-hint);padding:6px 0;">Joined</td>
            <td style="text-align:right;padding:6px 0;">{{ $student->created_at->format('d M Y') }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-hint);padding:6px 0;">Courses</td>
            <td style="text-align:right;padding:6px 0;">{{ $student->enrollments->count() }}</td>
          </tr>
        </table>
      </div>
    </div>

    @if($student->why_join)
    <div class="card">
      <div class="card-header"><span class="card-title">Application Note</span></div>
      <div style="padding:20px;font-size:14px;line-height:1.7;color:var(--text-muted);">
        {{ $student->why_join }}
      </div>
    </div>
    @endif
  </div>

  {{-- Enrollments --}}
  <div class="card">
    <div class="card-header"><span class="card-title">Enrolled Courses</span></div>
    <div class="card-body table-wrap">
      @if($student->enrollments->count())
      <table>
        <thead><tr><th>Course</th><th>Enrolled</th><th>Progress</th></tr></thead>
        <tbody>
          @foreach($student->enrollments as $enrollment)
          <tr>
            <td>
              <div>{{ $enrollment->course->title }}</div>
              <div class="cell-muted">{{ $enrollment->course->lesson_count }} lessons</div>
            </td>
            <td>{{ $enrollment->enrolled_at->format('d M Y') }}</td>
            <td>
              <div style="display:flex;align-items:center;gap:10px;">
                <div style="flex:1;height:6px;background:var(--beige);border-radius:3px;overflow:hidden;">
                  <div style="height:100%;width:{{ $enrollment->progress }}%;background:var(--gold);border-radius:3px;"></div>
                </div>
                <span style="font-size:12px;color:var(--text-hint);min-width:32px;">{{ $enrollment->progress }}%</span>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <div class="empty-state" style="padding:40px;">
          <p>Not enrolled in any courses yet.</p>
        </div>
      @endif
    </div>
  </div>

</div>

@endsection

