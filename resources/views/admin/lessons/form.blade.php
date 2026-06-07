@extends('layouts.admin')
@section('title', isset($lesson) ? 'Edit Lesson' : 'New Lesson')
@section('page-title', isset($lesson) ? 'Edit Lesson' : 'New Lesson')

@section('topbar-actions')
  <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-secondary btn-sm">← Back to Course</a>
@endsection

@section('content')

<form id="lessonForm" method="POST"
      action="{{ isset($lesson) ? route('admin.lessons.update', $lesson) : route('admin.courses.lessons.store', $course) }}"
      enctype="multipart/form-data">
  @csrf

  <div style="display:grid;grid-template-columns:1fr 320px;gap:24px;">

    <div>
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Lesson Details</span></div>
        <div style="padding:24px;">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Lesson Title</label>
              <input type="text" name="title" class="form-control"
                     value="{{ old('title', $lesson->title ?? '') }}" required>
              @error('title')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">Order</label>
              <input type="number" name="order" class="form-control" min="1"
                     value="{{ old('order', $lesson->order ?? ($course->lessons->count() + 1)) }}">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"
                      placeholder="Brief overview of this lesson">{{ old('description', $lesson->description ?? '') }}</textarea>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Duration (minutes)</label>
              <input type="number" name="duration_minutes" class="form-control" min="1"
                     value="{{ old('duration_minutes', $lesson->duration_minutes ?? '') }}">
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:22px;">
              <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                <input type="checkbox" name="is_preview" value="1"
                       {{ old('is_preview', $lesson->is_preview ?? false) ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:var(--brown);">
                <span style="font-size:14px;">Free preview lesson</span>
              </label>
            </div>
          </div>
        </div>
      </div>

      {{-- Video Upload --}}
      <div class="card" style="margin-bottom:20px;">
        <div class="card-header"><span class="card-title">Video</span></div>
        <div id="videoCardBody" style="padding:24px;">

          @if(isset($lesson) && $lesson->video_url)
          <div style="margin-bottom:16px;padding:14px;background:var(--cream);border-radius:var(--radius-sm);display:flex;align-items:center;gap:12px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--gold);flex-shrink:0;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            <span style="font-size:13px;color:var(--text-muted);">Video uploaded </span>
            <a href="{{ $lesson->video_url }}" target="_blank" class="btn btn-secondary btn-sm" style="margin-left:auto;">Preview</a>
          </div>
          <p style="font-size:13px;color:var(--text-hint);margin-bottom:12px;">Upload a new video to replace the existing one:</p>
          @endif

          {{-- Upload zone label — properly closed --}}
          <label class="upload-zone" for="video" id="videoUploadZone">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:var(--beige-mid);"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            <p>Click to upload video<br><span>MP4, MOV, WebM — max 100MB</span></p>
            <input type="file" name="video" id="video" accept="video/*" style="display:none;">
          </label>

          {{-- Preview info shown after file selected --}}
          <div id="videoPreviewInfo" style="display:none;margin-top:12px;padding:12px 14px;background:#f3ede4;border-radius:8px;align-items:center;gap:10px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#b89b6a;flex-shrink:0;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            <div style="flex:1;min-width:0;">
              <div id="videoFileName" style="font-size:13px;color:#3a2e26;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></div>
              <div id="videoFileSize" style="font-size:12px;color:#9e9080;margin-top:2px;"></div>
            </div>
            <button type="button" onclick="clearVideoSelection()"
                    style="background:none;border:none;cursor:pointer;color:#9e9080;font-size:20px;line-height:1;flex-shrink:0;">×</button>
          </div>

        </div>
      </div>

      {{-- Resources --}}
      @isset($lesson)
      <div class="card">
        <div class="card-header">
          <span class="card-title">Downloadable Resources</span>
          <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('resourceInput').click()">+ Attach File</button>
        </div>
        <div style="padding:20px;">
          <input type="file" id="resourceInput" name="resource_files[]" multiple
       accept=".pdf,.docx,.xlsx,.pptx,.zip" style="display:none;">

          @if($lesson->resources->count())
            @foreach($lesson->resources as $res)
            <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--ivory);">
              <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--brown-light);flex-shrink:0;"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <div style="flex:1;">
                <div style="font-size:14px;">{{ $res->title }}</div>
                <div style="font-size:12px;color:var(--text-hint);">{{ strtoupper($res->file_type) }}</div>
              </div>
              <a href="{{ $res->file_url }}" target="_blank" class="btn-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              </a>
              <form method="POST" action="{{ route('admin.resources.destroy', $res) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon" style="color:var(--danger);"
                  onclick="return confirm('Remove this resource?')">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                </button>
              </form>
            </div>
            @endforeach
          @else
            <p style="font-size:14px;color:var(--text-hint);">No resources attached yet.</p>
          @endif
        </div>
      </div>
      @endisset
    </div>

    {{-- Sidebar --}}
    <div>
      <div class="card">
        <div style="padding:20px;">
          <div style="font-size:13px;color:var(--text-hint);margin-bottom:16px;">Part of course:</div>
          <div style="font-family:var(--font-serif);font-size:16px;color:var(--text-primary);margin-bottom:20px;">
            {{ $course->title }}
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
            {{ isset($lesson) ? 'Update Lesson' : 'Save Lesson' }}
          </button>
        </div>
      </div>
    </div>

  </div>
</form>

@push('scripts')
<script>
(function () {

  const form         = document.getElementById('lessonForm');
  const videoInput   = document.getElementById('video');
  const previewBox   = document.getElementById('videoPreviewInfo');
  const fileNameEl   = document.getElementById('videoFileName');
  const fileSizeEl   = document.getElementById('videoFileSize');

  // ── Video file selected preview ──
  videoInput.addEventListener('change', function () {
    if (!this.files || !this.files[0]) return;
    const file   = this.files[0];
    const sizeMB = (file.size / 1024 / 1024).toFixed(1);
    fileNameEl.textContent   = file.name;
    fileSizeEl.textContent   = sizeMB + ' MB selected — will upload on save';
    previewBox.style.display = 'flex';
  });

  window.clearVideoSelection = function () {
    videoInput.value         = '';
    previewBox.style.display = 'none';
    fileNameEl.textContent   = '';
    fileSizeEl.textContent   = '';
  };

  // ── Build modal ──
  document.body.insertAdjacentHTML('beforeend', `
    <div id="lessonModal" style="
        display:none;position:fixed;inset:0;z-index:9999;
        background:rgba(30,22,16,.55);backdrop-filter:blur(3px);
        align-items:center;justify-content:center;">
      <div style="
          background:#fff;border-radius:14px;padding:36px 40px;
          width:100%;max-width:400px;margin:0 16px;
          box-shadow:0 24px 60px rgba(0,0,0,.18);text-align:center;">
        <div style="margin-bottom:20px;">
          <svg id="lIconSpinner" width="48" height="48" viewBox="0 0 48 48" fill="none"
               style="animation:lspin 1s linear infinite;color:#b89b6a;">
            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4"
                    stroke-dasharray="100 28" stroke-linecap="round"/>
          </svg>
          <svg id="lIconCheck" width="48" height="48" viewBox="0 0 24 24" fill="none"
               stroke="#4caf80" stroke-width="2" style="display:none;">
            <circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/>
          </svg>
          <svg id="lIconError" width="48" height="48" viewBox="0 0 24 24" fill="none"
               stroke="#e05252" stroke-width="2" style="display:none;">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
        </div>
        <div id="lModalTitle" style="font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:500;color:#3a2e26;margin-bottom:6px;">Uploading…</div>
        <div id="lModalSub" style="font-size:13px;color:#9e9080;margin-bottom:22px;">Please wait while we save your lesson.</div>
        <div id="lProgressWrap" style="background:#f3ede4;border-radius:100px;height:8px;overflow:hidden;margin-bottom:10px;">
          <div id="lProgressBar" style="height:100%;width:0%;background:#b89b6a;border-radius:100px;transition:width .2s ease;"></div>
        </div>
        <div id="lProgressPct" style="font-size:13px;font-weight:600;color:#b89b6a;margin-bottom:20px;">0%</div>
        <ul id="lErrorList" style="display:none;list-style:none;padding:14px 16px;margin:0 0 20px;text-align:left;background:#fff5f5;border:1px solid #f5c6c6;border-radius:8px;"></ul>
        <button id="lModalClose" onclick="closeLessonModal()"
                style="display:none;width:100%;height:38px;font-family:'Jost',sans-serif;font-size:13px;font-weight:500;border:none;border-radius:6px;cursor:pointer;background:#3a2e26;color:#fff;">Close</button>
      </div>
    </div>
    <style>@keyframes lspin { to { transform:rotate(360deg); } }</style>
  `);

  const modal        = document.getElementById('lessonModal');
  const bar          = document.getElementById('lProgressBar');
  const pct          = document.getElementById('lProgressPct');
  const title        = document.getElementById('lModalTitle');
  const sub          = document.getElementById('lModalSub');
  const errorList    = document.getElementById('lErrorList');
  const closeBtn     = document.getElementById('lModalClose');
  const spinner      = document.getElementById('lIconSpinner');
  const iconCheck    = document.getElementById('lIconCheck');
  const iconError    = document.getElementById('lIconError');
  const progressWrap = document.getElementById('lProgressWrap');

  // ── Form submit ──
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    openModal();

    const formAction = form.getAttribute('action');
    const data       = new FormData(form);
    const hasVideo   = videoInput.files && videoInput.files.length > 0;
    const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content
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
          sub.textContent   = hasVideo
            ? 'Video is being processed, please wait.'
            : 'Saving your lesson, almost done.';
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
        showSuccess('Lesson saved!', 'Redirecting you now…');
        setTimeout(() => { window.location.href = xhr.responseURL || window.location.href; }, 1200);
        return;
      }
      showError('Something went wrong', 'Server returned status ' + xhr.status + '. Please try again.');
    });

    xhr.addEventListener('error', function () {
      showError('Network error', 'Check your connection and try again.');
    });

    xhr.send(data);
  });

  // ── Helpers ──

  function openModal () {
    bar.style.width            = '0%';
    pct.textContent            = '0%';
    title.textContent          = 'Uploading…';
    sub.textContent            = 'Please wait while we save your lesson.';
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

  window.closeLessonModal = function () { modal.style.display = 'none'; };

  // ── Resource upload (inside closure so it can access openModal etc.) ──
  @isset($lesson)
  const resourceInput = document.getElementById('resourceInput');
  if (resourceInput) {
    resourceInput.addEventListener('change', function () {
      if (!this.files || !this.files.length) return;

      const files     = Array.from(this.files);
      const formData  = new FormData();
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                     || document.querySelector('input[name="_token"]')?.value || '';

      files.forEach(f => formData.append('resource_files[]', f));
      formData.append('_token', csrfToken);

      openModal();
      title.textContent = 'Uploading Resource' + (files.length > 1 ? 's' : '') + '…';
      sub.textContent   = files.map(f => f.name).join(', ');

      const xhr = new XMLHttpRequest();
      xhr.open('POST', '{{ route("admin.resources.store", $lesson) }}');
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
            sub.textContent   = 'Saving your file, almost done.';
          }
        }
      });

      xhr.addEventListener('load', function () {
        resourceInput.value = '';
        if (xhr.status === 422) {
          showError('Upload failed', 'File type or size not allowed.');
          return;
        }
        if (xhr.status >= 200 && xhr.status < 400) {
          showSuccess('Resource uploaded!', 'Reloading page…');
          setTimeout(() => { window.location.reload(); }, 1200);
          return;
        }
        showError('Something went wrong', 'Server returned status ' + xhr.status + '.');
      });

      xhr.addEventListener('error', function () {
        showError('Network error', 'Check your connection and try again.');
      });

      xhr.send(formData);
    });
  }
  @endisset

})();
</script>
@endpush

@endsection