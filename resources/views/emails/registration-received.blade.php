<!DOCTYPE html>
<html>
<head>
<style>
  body { font-family: Georgia, serif; background: #faf8f5; color: #3d2b1f; }
  .wrap { max-width: 560px; margin: 40px auto; background: #fff; padding: 48px; border-radius: 4px; }
  h1 { font-size: 24px; font-weight: normal; margin-bottom: 8px; }
  .divider { width: 40px; height: 1px; background: #c9a96e; margin: 20px 0; }
  p { line-height: 1.8; color: #5a4030; }
  .footer { margin-top: 40px; font-size: 13px; color: #a89080; }
</style>
</head>
<body>
<div class="wrap">
  <h1>Welcome, {{ $user->name }}</h1>
  <div class="divider"></div>
  <p>Thank you for applying to Lev Av. We have received your registration and our team will review your application.</p>
  <p>You will receive an email once your account has been reviewed — usually within 1–2 business days.</p>
  <p>We look forward to welcoming you.</p>
  <div class="footer">— The Lev Av Team</div>
</div>
</body>
</html>