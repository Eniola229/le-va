@extends('layouts.student')
@section('title', $course->title)
@section('page-title', $course->title)

@section('topbar-actions')
  <a href="{{ route('student.courses') }}" style="font-size:13px;color:var(--text-muted);">← My Courses</a>
@endsection

@section('content')

<div class="player-layout">

  {{-- Left: current lesson --}}
  <div>
    @if($currentLesson)
      {{-- Video --}}
      <div class="video-wrap">
        @if($currentLesson->video_url)
          <video controls controlsList="nodownload" preload="metadata"
                 poster="{{ $course->cover_image ?? '' }}">
            <source src="{{ $currentLesson->video_url }}" type="video/mp4">
          </video>
        @else
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#1a1008;">
            <span style="font-family:var(--font-serif);font-size:22px;color:rgba(255,255,255,0.2);letter-spacing:4px;">LEV AV</span>
          </div>
        @endif
      </div>

      {{-- Lesson info --}}
      <div class="lesson-info">
        <h2>{{ $currentLesson->title }}</h2>
        @if($currentLesson->description)
          <p>{{ $currentLesson->description }}</p>
        @endif

        {{-- Mark complete --}}
        @php $isDone = in_array($currentLesson->id, $completedIds); @endphp
        <form method="POST" action="{{ route('student.lessons.complete', [$course, $currentLesson]) }}">
          @csrf
          <button type="submit" class="complete-btn {{ $isDone ? 'done' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ $isDone ? 'Completed' : 'Mark as Complete' }}
          </button>
        </form>

        {{-- Resources --}}
        @if($currentLesson->resources->count())
        <div style="margin-top:28px;">
          <div style="font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:var(--text-hint);margin-bottom:12px;">Downloads</div>
          <ul class="resources-list">
            @foreach($currentLesson->resources as $res)
            <li class="resource-item">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="file-icon"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <span class="file-name">{{ $res->title }}</span>
              <span class="file-type">{{ strtoupper($res->file_type) }}</span>
              <a href="{{ $res->file_url }}" target="_blank" download class="dl-btn">Download</a>
            </li>
            @endforeach
          </ul>
        </div>
        @endif
      </div>
    @else
      <div style="text-align:center;padding:60px 24px;background:var(--warm-white);border:1px solid var(--beige);border-radius:var(--radius-lg);">
        <div style="font-family:var(--font-serif);font-size:22px;color:var(--text-muted);margin-bottom:8px;">No lessons yet</div>
        <p style="font-size:14px;color:var(--text-hint);">Check back soon — content is being added.</p>
      </div>
    @endif
  </div>

  {{-- Right: lesson list --}}
  <div class="lesson-list-card">
    <div class="lesson-list-header">
      Course Content
      <div style="font-size:12px;color:var(--text-hint);margin-top:2px;font-family:var(--font-sans);">
        {{ count($completedIds) }} / {{ $lessons->count() }} completed
      </div>
    </div>
    <ul class="lesson-list">
      @foreach($lessons as $lesson)
        @php
          $isDone   = in_array($lesson->id, $completedIds);
          $isCurrent= $currentLesson && $currentLesson->id === $lesson->id;
        @endphp
        <li class="lesson-item {{ $isCurrent ? 'active' : '' }} {{ $isDone ? 'done' : '' }}">
          <a href="{{ route('student.lessons.show', [$course, $lesson]) }}"
             style="display:contents;color:inherit;">
            <div class="num">
              @if($isDone)
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              @else
                {{ $lesson->order }}
              @endif
            </div>
            <div class="lesson-title">{{ $lesson->title }}</div>
            @if($lesson->duration_minutes)
              <span class="duration">{{ $lesson->duration_minutes }}m</span>
            @endif
          </a>
        </li>
      @endforeach
    </ul>
  </div>

</div>

@endsection