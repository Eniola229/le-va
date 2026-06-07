@extends('layouts.admin')
@section('title', 'Announcements')
@section('page-title', 'Announcements')

@section('topbar-actions')
  <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">+ New Announcement</a>
@endsection

@section('content')

<div class="card">
  <div class="card-body table-wrap">
    @if($announcements->count())
    <table>
      <thead>
        <tr><th>Subject</th><th>Audience</th><th>Sent By</th><th>Date</th></tr>
      </thead>
      <tbody>
        @foreach($announcements as $ann)
        <tr>
          <td>
            <div>{{ $ann->title }}</div>
            <div class="cell-muted">{{ Str::limit($ann->body, 80) }}</div>
          </td>
          <td>
            <span class="badge badge-gold">{{ ucfirst($ann->audience) }}</span>
          </td>
          <td>{{ $ann->sender->name ?? '—' }}</td>
          <td>{{ $ann->sent_at?->format('d M Y, g:ia') ?? '—' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
      {{ $announcements->links('components.pagination') }}
    </div>
    @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        <h3>No announcements yet</h3>
        <p><a href="{{ route('admin.announcements.create') }}">Send your first announcement</a></p>
      </div>
    @endif
  </div>
</div>

@endsection