<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In — Lev Av</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root{--cream:#faf8f5;--ivory:#f4f0eb;--warm-white:#fffcf8;--beige:#e8e0d5;--beige-mid:#d4c9bc;--brown-light:#c2a98a;--brown:#8b5e3c;--brown-dark:#5c3d22;--brown-deep:#3d2b1f;--gold:#c9a96e;--gold-light:#e8d5b0;--text-primary:#3d2b1f;--text-muted:#8a7060;--text-hint:#b5a090;--danger:#c0392b;--font-serif:'Cormorant Garamond',Georgia,serif;--font-sans:'Jost','Segoe UI',sans-serif;}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:var(--font-sans);background:var(--cream);color:var(--text-primary);min-height:100vh;display:flex;align-items:center;justify-content:center;}
    .login-wrap{width:100%;max-width:420px;padding:0 20px;}
    .login-brand{font-family:var(--font-serif);font-size:26px;letter-spacing:4px;color:var(--brown-dark);text-align:center;margin-bottom:4px;}
    .login-brand-sub{text-align:center;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:var(--text-hint);margin-bottom:40px;}
    .login-card{background:var(--warm-white);border:1px solid var(--beige);border-radius:16px;padding:40px;}
    .login-card h1{font-family:var(--font-serif);font-size:26px;font-weight:400;margin-bottom:4px;}
    .divider{width:36px;height:1px;background:var(--gold);margin:8px 0 20px;}
    .login-card .sub{font-size:13px;color:var(--text-hint);margin-bottom:28px;}
    .form-group{margin-bottom:18px;}
    .form-label{display:block;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text-muted);margin-bottom:6px;font-weight:500;}
    .form-control{width:100%;padding:11px 14px;border:1px solid var(--beige);border-radius:6px;background:var(--warm-white);color:var(--text-primary);font-family:inherit;font-size:14px;outline:none;transition:.2s;}
    .form-control:focus{border-color:var(--brown-light);box-shadow:0 0 0 3px rgba(201,169,110,.15);}
    .form-control::placeholder{color:var(--text-hint);}
    .remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
    .remember-row label{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-muted);cursor:pointer;}
    .remember-row input{width:15px;height:15px;accent-color:var(--brown);}
    .btn-submit{width:100%;padding:13px;background:var(--brown-dark);color:var(--gold-light);border:none;border-radius:6px;font-family:inherit;font-size:14px;font-weight:500;letter-spacing:.5px;cursor:pointer;transition:.2s;}
    .btn-submit:hover{background:var(--brown-deep);}
    .auth-link{text-align:center;margin-top:20px;font-size:13px;color:var(--text-hint);}
    .auth-link a{color:var(--brown);font-weight:500;}
    .alert{padding:12px 16px;border-radius:6px;font-size:13px;margin-bottom:18px;}
    .alert-danger{background:#fdf0ef;color:var(--danger);border:1px solid #f5c6c3;}
    .alert-success{background:#f0f7f1;color:#5a8a5e;border:1px solid #c3dbc5;}
  </style>
</head>
<body>
<div class="login-wrap">
  <div class="login-brand">LEV AV</div>
  <div class="login-brand-sub">Come to the heart of God</div>

  <div class="login-card">
    <h1>Welcome back</h1>
    <div class="divider"></div>
    <p class="sub">Sign in to continue your journey.</p>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email') }}" required autofocus>
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="remember-row">
        <label>
          <input type="checkbox" name="remember">
          Remember me
        </label>
      </div>
      <button type="submit" class="btn-submit">Sign In</button>
    </form>

    <div class="auth-link">Don't have an account? <a href="{{ route('register') }}">Apply now</a></div>
  </div>
</div>
</body>
</html>

