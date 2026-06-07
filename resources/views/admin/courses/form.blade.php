@extends('layouts.admin')
@section('title', isset($course) ? 'Edit Course' : 'New Course')
@section('page-title', isset($course) ? 'Edit Course' : 'New Course')

@section('topbar-actions')
  <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">← Back</a>
@endsection

@section('content')

<form id="courseForm" method="POST"
      action="{{ isset($course) ? route('admin.courses.update', $course) : route('admin.courses.store') }}"
      enctype="multipart/form-data">
  @csrf

  <div style="display:grid;grid-template-columns:1fr 360px;gap:24px;">

    {{-- Main --}}
    <div>
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Course Details</span></div>
        <div style="padding:24px;">
          <div class="form-group">
            <label class="form-label">Course Title</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $course->title ?? '') }}" required
                   placeholder="e.g. Walking with God: A 6-Week Journey">
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5"
                      placeholder="What is this course about?">{{ old('description', $course->description ?? '') }}</textarea>
            @error('description')<div class="form-error">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">What Students Will Learn</label>
            <textarea name="what_you_will_learn" class="form-control" rows="4"
                      placeholder="Key outcomes — one per line">{{ old('what_you_will_learn', $course->what_you_will_learn ?? '') }}</textarea>
            <div class="form-hint">One learning outcome per line.</div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Duration</label>
              <input type="text" name="duration" class="form-control"
                     value="{{ old('duration', $course->duration ?? '') }}"
                     placeholder="e.g. 8 Weeks">
            </div>
            <div class="form-group">
              <label class="form-label">Status</label>
              <select name="status" class="form-control">
                <option value="draft"     {{ old('status', $course->status ?? 'draft') == 'draft'     ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $course->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      {{-- Lessons list (only on edit) --}}
      @isset($course)
      <div class="card">
        <div class="card-header">
          <span class="card-title">Lessons ({{ $course->lessons->count() }})</span>
          <a href="{{ route('admin.courses.lessons.create', $course) }}" class="btn btn-primary btn-sm">+ Add Lesson</a>
        </div>
        <div class="card-body table-wrap">
          @if($course->lessons->count())
          <table>
            <thead><tr><th>#</th><th>Title</th><th>Duration</th><th>Preview</th><th></th></tr></thead>
            <tbody>
              @foreach($course->lessons->sortBy('order') as $lesson)
              <tr>
                <td style="color:var(--text-hint);">{{ $lesson->order }}</td>
                <td>{{ $lesson->title }}</td>
                <td>{{ $lesson->duration_minutes ? $lesson->duration_minutes.' min' : '—' }}</td>
                <td>
                  @if($lesson->is_preview)
                    <span class="badge badge-gold">Preview</span>
                  @else
                    <span style="color:var(--text-hint);font-size:12px;">—</span>
                  @endif
                </td>
                <td>
                  <div style="display:flex;gap:6px;">
                    <a href="{{ route('admin.lessons.edit', $lesson) }}" class="btn-icon" title="Edit">
                      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                    {{-- Delete button triggers hidden form outside #courseForm --}}
                    <button type="button" class="btn-icon" style="color:var(--danger);"
                        onclick="if(confirm('Delete this lesson?')) document.getElementById('del-{{ $lesson->id }}').submit();">
                      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
            <div class="empty-state" style="padding:40px;">
              <p>No lessons yet. <a href="{{ route('admin.courses.lessons.create', $course) }}">Add the first lesson.</a></p>
            </div>
          @endif
        </div>
      </div>
      @endisset
    </div>

    {{-- Sidebar --}}
    <div>
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Cover Image</span></div>
        <div style="padding:20px;">
          @if(isset($course) && $course->cover_image)
          <img src="{{ $course->cover_image }}" alt="Cover"
               id="coverPreviewImg"
               style="width:100%;border-radius:var(--radius-sm);margin-bottom:14px;aspect-ratio:16/9;object-fit:cover;">
          @endif
          <label class="upload-zone" for="cover_image">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <p>Click to upload<br><span>JPG, PNG — max 5MB</span></p>
            <input type="file" name="cover_image" id="cover_image" accept="image/*" style="display:none;"
                   onchange="updateCoverPreview(this)">
          </label>
        </div>
      </div>

      <div class="card">
        <div style="padding:20px;">
          <button type="submit" name="intent" value="save_draft"
                  class="btn btn-secondary" style="width:100%;margin-bottom:10px;justify-content:center;">
            Save Draft
          </button>
          <button type="submit" name="intent" value="publish"
                  class="btn btn-primary" style="width:100%;justify-content:center;">
            {{ isset($course) && $course->status === 'published' ? 'Update Course' : 'Publish Course' }}
          </button>
        </div>
      </div>
    </div>

  </div>
</form>

{{-- ── Lesson delete forms — outside #courseForm to prevent nesting ── --}}
@isset($course)
  @foreach($course->lessons as $lesson)
  <form id="del-{{ $lesson->id }}" method="POST"
        action="{{ route('admin.lessons.destroy', $lesson) }}" style="display:none;">
    @csrf
    @method('DELETE')
  </form>
  @endforeach
@endisset

{{-- ── Upload Progress Modal ── --}}
<div id="uploadModal" style="
  display:none;position:fixed;inset:0;z-index:9999;
  background:rgba(30,22,16,.55);backdrop-filter:blur(3px);
  align-items:center;justify-content:center;">

  <div style="
    background:#fff;border-radius:14px;padding:36px 40px;
    width:100%;max-width:400px;margin:0 16px;
    box-shadow:0 24px 60px rgba(0,0,0,.18);text-align:center;">

    <div id="modalIcon" style="margin-bottom:20px;">
      <svg id="iconSpinner" width="48" height="48" viewBox="0 0 48 48" fill="none"
           style="animation:spin 1s linear infinite;color:#b89b6a;">
        <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" stroke-dasharray="100 28" stroke-linecap="round"/>
      </svg>
      <svg id="iconCheck" width="48" height="48" viewBox="0 0 24 24" fill="none"
           stroke="#4caf80" stroke-width="2" style="display:none;">
        <circle cx="12" cy="12" r="10"/>
        <polyline points="9 12 11 14 15 10"/>
      </svg>
      <svg id="iconError" width="48" height="48" viewBox="0 0 24 24" fill="none"
           stroke="#e05252" stroke-width="2" style="display:none;">
        <circle cx="12" cy="12" r="10"/>
        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
      </svg>
    </div>

    <div id="modalTitle" style="
      font-family:'Cormorant Garamond',serif;font-size:20px;
      font-weight:500;color:#3a2e26;margin-bottom:6px;">
      Uploading…
    </div>
    <div id="modalSub" style="font-size:13px;color:#9e9080;margin-bottom:22px;">
      Please wait while we save your course.
    </div>

    <div id="progressWrap" style="
      background:#f3ede4;border-radius:100px;height:8px;
      overflow:hidden;margin-bottom:10px;">
      <div id="progressBar" style="
        height:100%;width:0%;background:#b89b6a;
        border-radius:100px;transition:width .2s ease;"></div>
    </div>
    <div id="progressPct" style="font-size:13px;font-weight:600;color:#b89b6a;margin-bottom:20px;">0%</div>

    <ul id="errorList" style="
      display:none;list-style:none;padding:14px 16px;margin:0 0 20px;
      text-align:left;background:#fff5f5;border:1px solid #f5c6c6;
      border-radius:8px;">
    </ul>

    <button id="modalClose" onclick="closeModal()"
            style="display:none;width:100%;height:38px;
                   font-family:'Jost',sans-serif;font-size:13px;font-weight:500;
                   border:none;border-radius:6px;cursor:pointer;
                   background:#3a2e26;color:#fff;">
      Close
    </button>
  </div>
</div>

<style>
@keyframes spin { to { transform:rotate(360deg); } }
</style>

@push('scripts')
<script>
(function () {

  const form         = document.getElementById('courseForm');
  const modal        = document.getElementById('uploadModal');
  const bar          = document.getElementById('progressBar');
  const pct          = document.getElementById('progressPct');
  const title        = document.getElementById('modalTitle');
  const sub          = document.getElementById('modalSub');
  const errorList    = document.getElementById('errorList');
  const closeBtn     = document.getElementById('modalClose');
  const spinner      = document.getElementById('iconSpinner');
  const iconCheck    = document.getElementById('iconCheck');
  const iconError    = document.getElementById('iconError');
  const progressWrap = document.getElementById('progressWrap');

  let intentValue = '';

  form.querySelectorAll('button[name="intent"]').forEach(btn => {
    btn.addEventListener('click', () => { intentValue = btn.value; });
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    openModal();

    const formAction = form.getAttribute('action');
    const data       = new FormData(form);
    if (intentValue) data.set('intent', intentValue);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                   || document.querySelector('input[name="_token"]')?.value || '';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', formAction);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

    xhr.upload.addEventListener('progress', function (e) {
      if (e.lengthComputable) {
        const p = Math.round((e.loaded / e.total) * 100);
        bar.style.width = p + '%';
        pct.textContent = p + '%';
        if (p === 100) {
          title.textContent = 'Processing…';
          sub.textContent   = 'Saving your course, almost done.';
        }
      }
    });

    xhr.addEventListener('load', function () {
      if (xhr.status === 422) {
        showError('Validation failed', 'Please fix the errors below and try again.');
        try {
          const errors = JSON.parse(xhr.responseText).errors || {};
          errorList.innerHTML = '';
          Object.values(errors).flat().forEach(msg => {
            const li = document.createElement('li');
            li.style.cssText = 'font-size:13px;color:#c0392b;padding:3px 0;';
            li.textContent = '• ' + msg;
            errorList.appendChild(li);
          });
          errorList.style.display = 'block';
        } catch (_) {}
        return;
      }

      if (xhr.status >= 200 && xhr.status < 400) {
        showSuccess('Course saved!', 'Redirecting you now…');
        setTimeout(() => {
          window.location.href = xhr.responseURL
            || '{{ isset($course) ? route("admin.courses.edit", $course) : route("admin.courses.index") }}';
        }, 1200);
        return;
      }

      showError('Something went wrong', 'Server returned status ' + xhr.status + '. Please try again.');
    });

    xhr.addEventListener('error', function () {
      showError('Network error', 'Check your connection and try again.');
    });

    xhr.send(data);
  });

  function openModal () {
    bar.style.width            = '0%';
    pct.textContent            = '0%';
    title.textContent          = 'Uploading…';
    sub.textContent            = 'Please wait while we save your course.';
    errorList.style.display    = 'none';
    errorList.innerHTML        = '';
    closeBtn.style.display     = 'none';
    progressWrap.style.display = 'block';
    pct.style.display          = 'block';
    spinner.style.display      = '';
    iconCheck.style.display    = 'none';
    iconError.style.display    = 'none';
    modal.style.display        = 'flex';
  }

  function showSuccess (t, s) {
    title.textContent       = t;
    sub.textContent         = s;
    bar.style.width         = '100%';
    pct.textContent         = '100%';
    spinner.style.display   = 'none';
    iconCheck.style.display = '';
  }

  function showError (t, s) {
    title.textContent          = t;
    sub.textContent            = s;
    spinner.style.display      = 'none';
    iconError.style.display    = '';
    progressWrap.style.display = 'none';
    pct.style.display          = 'none';
    closeBtn.style.display     = 'block';
  }

  window.closeModal = function () {
    modal.style.display = 'none';
  };

  window.updateCoverPreview = function (input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
      let img = document.getElementById('coverPreviewImg');
      if (!img) {
        img = document.createElement('img');
        img.id = 'coverPreviewImg';
        img.style.cssText = 'width:100%;border-radius:var(--radius-sm);margin-bottom:14px;aspect-ratio:16/9;object-fit:cover;';
        input.closest('.card').querySelector('div').prepend(img);
      }
      img.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  };

})();
</script>
@endpush

@endsection