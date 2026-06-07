@extends('layouts.admin')
@section('title', 'Add Admin')
@section('page-title', 'Add Admin')

@section('topbar-actions')
  <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary btn-sm">← Back</a>
@endsection

@section('content')

<div style="max-width:560px;">
  <div class="card">
    <div class="card-header">
      <span class="card-title">New Admin Account</span>
    </div>
    <div style="padding:24px;">
      <form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf

        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-control"
                 value="{{ old('name') }}" required
                 placeholder="e.g. Sarah Johnson">
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control"
                 value="{{ old('email') }}" required
                 placeholder="sarah@example.com">
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
          <div class="form-hint">An invitation email will be sent to this address.</div>
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control"
                 placeholder="At least 8 characters" required>
          @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control"
                 placeholder="Repeat password" required>
        </div>

        <div style="display:flex;gap:10px;margin-top:24px;">
          <button type="submit" class="btn btn-primary">Add Admin</button>
          <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection