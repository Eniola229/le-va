@extends('layouts.student')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@push('styles')
<style>
.profile-grid {
  display: grid;
  grid-template-columns: 1fr 280px;
  gap: 24px;
  align-items: start;
}

/* ── Card ── */
.p-card {
  background: #fff;
  border: 1px solid #ede8e0;
  border-radius: 10px;
  margin-bottom: 20px;
  overflow: hidden;
}
.p-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 22px;
  border-bottom: 1px solid #ede8e0;
}
.p-card-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px;
  font-weight: 500;
  color: #3a2e26;
  letter-spacing: 0.01em;
}
.p-card-body {
  padding: 24px 22px;
}

/* ── Form elements ── */
.p-form-group {
  margin-bottom: 18px;
}
.p-form-group:last-of-type {
  margin-bottom: 0;
}
.p-form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.p-label {
  display: block;
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 0.07em;
  text-transform: uppercase;
  color: #8a7d72;
  margin-bottom: 7px;
}
.p-input {
  width: 100%;
  box-sizing: border-box;
  height: 40px;
  padding: 0 13px;
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  color: #3a2e26;
  background: #faf8f5;
  border: 1px solid #ddd6cc;
  border-radius: 6px;
  outline: none;
  transition: border-color .15s, box-shadow .15s;
}
.p-input:focus {
  border-color: #b89b6a;
  box-shadow: 0 0 0 3px rgba(184,155,106,.12);
  background: #fff;
}
.p-input::placeholder { color: #bbb3aa; }
.p-error {
  font-size: 12px;
  color: #c0392b;
  margin-top: 5px;
}

/* ── Buttons ── */
.p-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  height: 38px;
  padding: 0 20px;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 0.04em;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  transition: opacity .15s, background .15s;
}
.p-btn-primary {
  background: #3a2e26;
  color: #fff;
}
.p-btn-primary:hover { opacity: .85; }
.p-btn-secondary {
  background: transparent;
  color: #3a2e26;
  border: 1px solid #ddd6cc;
}
.p-btn-secondary:hover { border-color: #b89b6a; }

/* ── Sidebar avatar card ── */
.p-avatar-wrap {
  text-align: center;
  padding: 28px 22px 20px;
  border-bottom: 1px solid #ede8e0;
}
.p-avatar-img {
  width: 76px;
  height: 76px;
  border-radius: 50%;
  object-fit: cover;
  margin: 0 auto 14px;
  display: block;
}
.p-avatar-initials {
  width: 76px;
  height: 76px;
  border-radius: 50%;
  background: #f3ede4;
  border: 1px solid #ddd6cc;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 14px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 26px;
  font-weight: 500;
  color: #8a7d72;
}
.p-avatar-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 400;
  color: #3a2e26;
  margin-bottom: 3px;
}
.p-avatar-meta {
  font-size: 12px;
  color: #9e9080;
  margin-bottom: 2px;
}
.p-badge {
  display: inline-block;
  margin-top: 10px;
  padding: 3px 12px;
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  background: #f3ede4;
  color: #8a7d72;
  border-radius: 20px;
}

/* ── Upload zone (sidebar) ── */
.p-upload-zone {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  padding: 18px;
  margin: 18px 22px 0;
  border: 1.5px dashed #ddd6cc;
  border-radius: 8px;
  cursor: pointer;
  transition: border-color .2s, background .2s;
  text-align: center;
}
.p-upload-zone:hover {
  border-color: #b89b6a;
  background: #faf8f5;
}
.p-upload-zone svg {
  width: 26px;
  height: 26px;
  color: #b89b6a;
}
.p-upload-zone p {
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  color: #3a2e26;
  margin: 0;
  line-height: 1.5;
}
.p-upload-zone span {
  font-size: 11px;
  color: #9e9080;
}

/* Uploading state styles */
.p-upload-zone.uploading {
  cursor: wait;
  opacity: 0.7;
  pointer-events: none;
}
.p-upload-status {
  margin: 12px 22px 0;
  padding: 10px;
  border-radius: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  text-align: center;
  display: none;
}
.p-upload-status.show {
  display: block;
}
.p-upload-status.uploading-status {
  background: #e3f2fd;
  color: #1976d2;
}
.p-upload-status.success-status {
  background: #e8f5e9;
  color: #2e7d32;
}
.p-upload-status.error-status {
  background: #ffebee;
  color: #c62828;
}
.spinner {
  display: inline-block;
  width: 12px;
  height: 12px;
  border: 2px solid #1976d2;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
  margin-right: 6px;
  vertical-align: middle;
}
@keyframes spin {
  to { transform: rotate(360deg); }
}

/* ── Stats table (sidebar) ── */
.p-stats {
  padding: 16px 22px;
}
.p-stats table {
  width: 100%;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  border-collapse: collapse;
}
.p-stats td {
  padding: 7px 0;
  border-bottom: 1px solid #f5f0ea;
}
.p-stats tr:last-child td { border-bottom: none; }
.p-stats .s-label { color: #9e9080; }
.p-stats .s-value { text-align: right; color: #3a2e26; font-weight: 500; }
</style>
@endpush

@section('content')

<div class="profile-grid">

  {{-- ── Left: forms ── --}}
  <div>

    {{-- Profile Details --}}
    <div class="p-card">
      <div class="p-card-header">
        <span class="p-card-title">Profile Details</span>
      </div>
      <div class="p-card-body">
        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" id="profileForm">
          @csrf

          <div class="p-form-group">
            <label class="p-label">Full Name</label>
            <input type="text" name="name" class="p-input"
                   value="{{ old('name', $user->name) }}" required
                   placeholder="Your full name">
            @error('name')<div class="p-error">{{ $message }}</div>@enderror
          </div>

          <div class="p-form-group">
            <label class="p-label">Email Address</label>
            <input type="email" name="email" class="p-input"
                   value="{{ old('email', $user->email) }}" required
                   placeholder="your@email.com">
            @error('email')<div class="p-error">{{ $message }}</div>@enderror
          </div>

          <div class="p-form-row">
            <div class="p-form-group">
              <label class="p-label">Phone</label>
              <input type="text" name="phone" class="p-input"
                     value="{{ old('phone', $user->phone ?? '') }}"
                     placeholder="+234 800 000 0000">
              @error('phone')<div class="p-error">{{ $message }}</div>@enderror
            </div>
            <div class="p-form-group">
              <label class="p-label">Country</label>
              <input type="text" name="country" class="p-input"
                     value="{{ old('country', $user->country ?? '') }}"
                     placeholder="e.g. Nigeria">
              @error('country')<div class="p-error">{{ $message }}</div>@enderror
            </div>
          </div>

          <div style="margin-top:22px;">
            <button type="submit" class="p-btn p-btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    {{-- Change Password --}}
    <div class="p-card">
      <div class="p-card-header">
        <span class="p-card-title">Change Password</span>
      </div>
      <div class="p-card-body">
        <form method="POST" action="{{ route('student.profile.password') }}">
          @csrf

          <div class="p-form-group">
            <label class="p-label">Current Password</label>
            <input type="password" name="current_password" class="p-input"
                   placeholder="Enter current password" required>
            @error('current_password')<div class="p-error">{{ $message }}</div>@enderror
          </div>

          <div class="p-form-row">
            <div class="p-form-group">
              <label class="p-label">New Password</label>
              <input type="password" name="password" class="p-input"
                     placeholder="At least 8 characters" required>
              @error('password')<div class="p-error">{{ $message }}</div>@enderror
            </div>
            <div class="p-form-group">
              <label class="p-label">Confirm New Password</label>
              <input type="password" name="password_confirmation" class="p-input"
                     placeholder="Repeat new password" required>
            </div>
          </div>

          <div style="margin-top:22px;">
            <button type="submit" class="p-btn p-btn-secondary">Update Password</button>
          </div>
        </form>
      </div>
    </div>

  </div>

  {{-- ── Sidebar ── --}}
  <div>

    {{-- Avatar + photo upload --}}
    <div class="p-card" style="margin-bottom:20px;">
      <div class="p-avatar-wrap">
        @if($user->profile_photo)
          <img src="{{ $user->profile_photo }}" alt="{{ $user->name }}" class="p-avatar-img" id="avatarImage">
        @else
          <div class="p-avatar-initials" id="avatarInitials">{{ strtoupper(substr($user->name,0,2)) }}</div>
        @endif
        <div class="p-avatar-name">{{ $user->name }}</div>
        <div class="p-avatar-meta">{{ $user->email }}</div>
        @if($user->country)
          <div class="p-avatar-meta">{{ $user->country }}</div>
        @endif
        <span class="p-badge">Student</span>
      </div>

      <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" id="photoUploadForm">
        @csrf
        <input type="hidden" name="name"    value="{{ $user->name }}">
        <input type="hidden" name="email"   value="{{ $user->email }}">
        <input type="hidden" name="phone"   value="{{ $user->phone }}">
        <input type="hidden" name="country" value="{{ $user->country }}">

        <label class="p-upload-zone" id="uploadZone" for="profile_photo_side">
          <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
            <polyline points="17 8 12 3 7 8"/>
            <line x1="12" y1="3" x2="12" y2="15"/>
          </svg>
          <p>Click to upload photo<br><span>JPG, PNG — max 3MB</span></p>
          <input type="file" name="profile_photo" id="profile_photo_side"
                 accept="image/*" style="display:none;">
        </label>
        
        <div id="uploadStatus" class="p-upload-status"></div>
        
        @error('profile_photo')<div style="padding:0 22px 12px;font-size:12px;color:#c0392b;">{{ $message }}</div>@enderror
      </form>

      <div style="padding:16px 22px 18px;">
      </div>
    </div>

    {{-- Stats --}}
    <div class="p-card">
      <div class="p-stats">
        <table>
          <tr>
            <td class="s-label">Member since</td>
            <td class="s-value">{{ $user->created_at->format('d M Y') }}</td>
          </tr>
          <tr>
            <td class="s-label">Courses enrolled</td>
            <td class="s-value">{{ $user->enrollments->count() }}</td>
          </tr>
          <tr>
            <td class="s-label">Lessons completed</td>
            <td class="s-value">{{ $completions }}</td>
          </tr>
        </table>
      </div>
    </div>

  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('profile_photo_side');
    const uploadForm = document.getElementById('photoUploadForm');
    const uploadZone = document.getElementById('uploadZone');
    const uploadStatus = document.getElementById('uploadStatus');
    
    // Check for session status messages (from server-side redirect)
    @if(session('upload_status') && session('upload_status') === 'success')
        showStatusMessage('Profile photo updated successfully!', 'success');
    @elseif(session('upload_status') && session('upload_status') === 'error')
        showStatusMessage('{{ session('upload_error') ?? 'Upload failed. Please try again.' }}', 'error');
    @endif
    
    photoInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const maxSize = 3 * 1024 * 1024; // 3MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            
            // Validate file type
            if (!allowedTypes.includes(file.type)) {
                showStatusMessage('Please upload JPG or PNG images only.', 'error');
                this.value = ''; // Clear the input
                return;
            }
            
            // Validate file size
            if (file.size > maxSize) {
                showStatusMessage('File is too large. Maximum size is 3MB.', 'error');
                this.value = ''; // Clear the input
                return;
            }
            
            // Show uploading indicator
            showStatusMessage('Uploading profile photo...', 'uploading');
            uploadZone.classList.add('uploading');
            
            // Create FormData and submit via AJAX for better UX
            const formData = new FormData(uploadForm);
            
            fetch(uploadForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showStatusMessage('Profile photo updated successfully!', 'success');
                    
                    // Update the avatar image if returned
                    if (data.photo_url) {
                        const avatarImg = document.getElementById('avatarImage');
                        const avatarInitials = document.getElementById('avatarInitials');
                        
                        if (avatarImg) {
                            avatarImg.src = data.photo_url + '?t=' + new Date().getTime();
                            avatarImg.style.display = 'block';
                            if (avatarInitials) avatarInitials.style.display = 'none';
                        } else if (avatarInitials) {
                            // If there was no image element, create one
                            const avatarWrap = document.querySelector('.p-avatar-wrap');
                            const newImg = document.createElement('img');
                            newImg.id = 'avatarImage';
                            newImg.src = data.photo_url + '?t=' + new Date().getTime();
                            newImg.alt = '{{ $user->name }}';
                            newImg.className = 'p-avatar-img';
                            avatarInitials.style.display = 'none';
                            avatarWrap.insertBefore(newImg, avatarInitials);
                        }
                    }
                    
                    // Clear the file input
                    photoInput.value = '';
                } else {
                    showStatusMessage(data.message || 'Upload failed. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showStatusMessage('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                uploadZone.classList.remove('uploading');
                
                // Auto-hide success message after 3 seconds
                setTimeout(() => {
                    if (uploadStatus.classList.contains('show') && 
                        uploadStatus.classList.contains('success-status')) {
                        uploadStatus.classList.remove('show');
                    }
                }, 3000);
            });
        }
    });
    
    function showStatusMessage(message, type) {
        uploadStatus.textContent = message;
        uploadStatus.className = 'p-upload-status show';
        
        if (type === 'uploading') {
            uploadStatus.classList.add('uploading-status');
            // Add spinner for uploading state
            uploadStatus.innerHTML = '<span class="spinner"></span> ' + message;
        } else if (type === 'success') {
            uploadStatus.classList.add('success-status');
        } else if (type === 'error') {
            uploadStatus.classList.add('error-status');
        }
    }
    
    // Allow clicking on the upload zone to trigger file input
    uploadZone.addEventListener('click', function(e) {
        if (!uploadZone.classList.contains('uploading')) {
            photoInput.click();
        }
    });
});
</script>

@endsection