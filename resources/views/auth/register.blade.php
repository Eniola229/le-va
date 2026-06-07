<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apply — Lev Av</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --cream:#faf8f5; --ivory:#f4f0eb; --warm-white:#fffcf8;
      --beige:#e8e0d5; --beige-mid:#d4c9bc; --brown-light:#c2a98a;
      --brown:#8b5e3c; --brown-dark:#5c3d22; --brown-deep:#3d2b1f;
      --gold:#c9a96e; --gold-light:#e8d5b0;
      --text-primary:#3d2b1f; --text-muted:#8a7060; --text-hint:#b5a090;
      --danger:#c0392b; --success:#5a8a5e;
      --font-serif:'Cormorant Garamond',Georgia,serif;
      --font-sans:'Jost','Segoe UI',sans-serif;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:var(--font-sans);background:var(--cream);color:var(--text-primary);min-height:100vh;display:flex;}
    .auth-split{display:grid;grid-template-columns:1fr 1fr;min-height:100vh;}
    .auth-visual{background:var(--brown-deep);position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:flex-end;padding:48px;}
    .auth-visual::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800') center/cover;opacity:0.15;}
    .auth-visual-content{position:relative;z-index:1;}
    .auth-visual .brand{font-family:var(--font-serif);font-size:28px;color:var(--gold-light);letter-spacing:4px;margin-bottom:32px;}
    .auth-visual h2{font-family:var(--font-serif);font-size:36px;font-weight:300;color:#fff;line-height:1.3;margin-bottom:16px;}
    .auth-visual p{font-size:15px;color:rgba(255,255,255,0.55);line-height:1.7;}
    .auth-form-side{display:flex;align-items:center;justify-content:center;padding:40px 32px;background:var(--warm-white);}
    .auth-form-wrap{width:100%;max-width:440px;}
    .auth-form-wrap h1{font-family:var(--font-serif);font-size:28px;font-weight:400;margin-bottom:6px;}
    .auth-form-wrap .sub{font-size:14px;color:var(--text-hint);margin-bottom:32px;}
    .divider{width:36px;height:1px;background:var(--gold);margin:10px 0 24px;}
    .form-group{margin-bottom:18px;}
    .form-label{display:block;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text-muted);margin-bottom:6px;font-weight:500;}
    .form-control{width:100%;padding:11px 14px;border:1px solid var(--beige);border-radius:6px;background:var(--warm-white);color:var(--text-primary);font-family:inherit;font-size:14px;outline:none;transition:.2s;}
    .form-control:focus{border-color:var(--brown-light);box-shadow:0 0 0 3px rgba(201,169,110,.15);}
    .form-control::placeholder{color:var(--text-hint);}
    textarea.form-control{resize:vertical;min-height:90px;line-height:1.6;}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .form-error{font-size:12px;color:var(--danger);margin-top:4px;}
    .btn-submit{width:100%;padding:13px;background:var(--brown-dark);color:var(--gold-light);border:none;border-radius:6px;font-family:inherit;font-size:14px;font-weight:500;letter-spacing:.5px;cursor:pointer;transition:.2s;margin-top:8px;}
    .btn-submit:hover{background:var(--brown-deep);}
    .auth-link{text-align:center;margin-top:20px;font-size:13px;color:var(--text-hint);}
    .auth-link a{color:var(--brown);font-weight:500;}
    .alert{padding:12px 16px;border-radius:6px;font-size:13px;margin-bottom:16px;}
    .alert-danger{background:#fdf0ef;color:var(--danger);border:1px solid #f5c6c3;}
    @media(max-width:768px){.auth-split{grid-template-columns:1fr;}.auth-visual{display:none;}.form-row{grid-template-columns:1fr;}}
  </style>
</head>
<body>
<div class="auth-split">

  <div class="auth-visual">
    <div class="auth-visual-content">
      <div class="brand">LEV AV</div>
      <h2>Come to the<br>Heart of God.</h2>
      <p>A place of spiritual growth, deep biblical learning, and intimate transformation. We're glad you're here.</p>
    </div>
  </div>

  <div class="auth-form-side">
    <div class="auth-form-wrap">
      <h1>Apply to Lev Av</h1>
      <div class="divider"></div>
      <p class="sub">Complete the form below. Our team reviews every application personally.</p>

      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Country</label>
            <input type="text" name="country" class="form-control" value="{{ old('country') }}">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Phone (optional)</label>
          <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Why do you want to join? (optional)</label>
          <textarea name="why_join" class="form-control" placeholder="Share a little about yourself and what draws you to Lev Av…">{{ old('why_join') }}</textarea>
        </div>

        <button type="submit" class="btn-submit">Submit Application</button>
      </form>

      <div class="auth-link">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
    </div>
  </div>

</div>
</body>
</html>
