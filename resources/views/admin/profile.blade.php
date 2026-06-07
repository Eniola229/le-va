@extends('layouts.admin')
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
.p-card-body { padding: 24px 22px; }
.p-form-group { margin-bottom: 18px; }
.p-form-group:last-of-type { margin-bottom: 0; }
.p-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
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
.p-error { font-size: 12px; color: #c0392b; margin-top: 5px; }
.p-btn {
  display: inline-flex;
  align-items: center;
  height: 38px;
  padding: 0 20px;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 0.04em;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  transition: opacity .15s;
}
.p-btn-primary  { background: #3a2e26; color: #fff; }
.p-btn-primary:hover  { opacity: .85; }
.p-btn-secondary { background: transparent; color: #3a2e26; border: 1px solid #ddd6cc; }
.p-btn-secondary:hover { border-color: #b89b6a; }
.p-avatar-wrap {
  text-align: center;
  padding: 28px 22px 20px;
  border-bottom: 1px solid #ede8e0;
}
.p-avatar-img {
  width: 76px; height: 76px; border-radius: 50%; object-fit: cover;
  margin: 0 auto 14px; display: block;
}
.p-avatar-initials {
  width: 76px; height: 76px; border-radius: 50%;
  background: #f3ede4; border: 1px solid #ddd6cc;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 14px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 26px; font-weight: 500; color: #8a7d72;
}
.p-avatar-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px; font-weight: 400; color: #3a2e26; margin-bottom: 3px;
}
.p-avatar-meta { font-size: 12px; color: #9e9080; margin-bottom: 2px; }
.p-badge {
  display: inline-block; margin-top: 10px; padding: 3px 12px;
  font-family: 'Jost', sans-serif; font-size: 11px; font-weight: 500;
  letter-spacing: 0.06em; text-transform: uppercase;
  background: #f3ede4; color: #8a7d72; border-radius: 20px;
}
.p-upload-zone {
  display: flex; flex-direction: column; align-items: center; gap: 8px;
  padding: 18px; margin: 18px 22px 0;
  border: 1.5px dashed #ddd6cc; border-radius: 8px;
  cursor: pointer; transition: border-color .2s, background .2s; text-align: center;
}
.p-upload-zone:hover { border-color: #b89b6a; background: #faf8f5; }
.p-upload-zone svg { width: 26px; height: 26px; color: #b89b6a; }
.p-upload-zone p { font-family: 'Jost', sans-serif; font-size: 13px; color: #3a2e26; margin: 0; line-height: 1.5; }
.p-upload-zone span { font-size: 11px; color: #9e9080; }
.p-stats { padding: 16px 22px; }
.p-stats table { width: 100%; font-family: 'Jost', sans-serif; font-size: 13px; border-collapse: collapse; }
.p-stats td { padding: 7px 0; border-bottom: 1px solid #f5f0ea; }
.p-stats tr:last-child td { border-bottom: none; }
.p-stats .s-label { color: #9e9080; }
.p-stats .s-value { text-align: right; color: #3a2e26; font-weight: 500; }
</style>
@endpush

@section('content')

<div class="profile-grid">

  {{-- ── Left: forms ── --}}
  <div>

    <div class="p-card">
      <div class="p-card-header"><span class="p-card-title">Profile Details</span></div>
      <div class="p-card-body">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
          @csrf

          <div class="p-form-group">
            <label class="p-label">Full Name</label>
            <input type="text" name="name" class="p-input"
                   value="{{ old('name', $user->name) }}" required placeholder="Your name">
            @error('name')<div class="p-error">{{ $message }}</div>@enderror
          </div>

          <div class="p-form-group" style="margin-bottom:0;">
            <label class="p-label">Email Address</label>
            <input type="email" name="email" class="p-input"
                   value="{{ old('email', $user->email) }}" required placeholder="your@email.com">
            @error('email')<div class="p-error">{{ $message }}</div>@enderror
          </div>

          <div style="margin-top:22px;">
            <button type="submit" class="p-btn p-btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    <div class="p-card">
      <div class="p-card-header"><span class="p-card-title">Change Password</span></div>
      <div class="p-card-body">
        <form method="POST" action="{{ route('admin.profile.password') }}">
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

    <div class="p-card" style="margin-bottom:20px;">
      <div class="p-avatar-wrap">
        @if($user->profile_photo)
          <img src="{{ $user->profile_photo }}" alt="{{ $user->name }}" class="p-avatar-img">
        @else
          <div class="p-avatar-initials">{{ strtoupper(substr($user->name,0,2)) }}</div>
        @endif
        <div class="p-avatar-name">{{ $user->name }}</div>
        <div class="p-avatar-meta">{{ $user->email }}</div>
        <span class="p-badge">Admin</span>
      </div>

      <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="name"  value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <label class="p-upload-zone" for="profile_photo_side">
          <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
            <polyline points="17 8 12 3 7 8"/>
            <line x1="12" y1="3" x2="12" y2="15"/>
          </svg>
          <p>Click to upload photo<br><span>JPG, PNG — max 3MB</span></p>
          <input type="file" name="profile_photo" id="profile_photo_side"
                 accept="image/*" style="display:none;"
                 onchange="this.form.submit()">
        </label>
        @error('profile_photo')<div style="padding:0 22px 12px;font-size:12px;color:#c0392b;">{{ $message }}</div>@enderror
      </form>

      <div style="height:18px;"></div>
    </div>

    <div class="p-card">
      <div class="p-stats">
        <table>
          <tr>
            <td class="s-label">Role</td>
            <td class="s-value">Administrator</td>
          </tr>
          <tr>
            <td class="s-label">Member since</td>
            <td class="s-value">{{ $user->created_at->format('d M Y') }}</td>
          </tr>
          <tr>
            <td class="s-label">Last updated</td>
            <td class="s-value">{{ $user->updated_at->format('d M Y') }}</td>
          </tr>
        </table>
      </div>
    </div>

  </div>

</div>

@endsection