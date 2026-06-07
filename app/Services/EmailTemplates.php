<?php

namespace App\Services;

class EmailTemplates
{
    // Shared wrapper: warm cream brand shell
    private static function wrap(string $body): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  body{margin:0;padding:0;background:#faf8f5;font-family:'Georgia',serif;}
  .shell{max-width:560px;margin:40px auto;background:#fffcf8;border-radius:8px;overflow:hidden;border:1px solid #e8e0d5;}
  .header{background:#3d2b1f;padding:28px 40px;text-align:center;}
  .brand{font-size:22px;letter-spacing:5px;color:#e8d5b0;font-weight:400;}
  .body{padding:40px;}
  h2{font-size:22px;font-weight:400;color:#3d2b1f;margin:0 0 10px;}
  .divider{width:36px;height:1px;background:#c9a96e;margin:12px 0 24px;}
  p{font-size:15px;line-height:1.8;color:#5a4030;margin:0 0 16px;}
  .btn{display:inline-block;padding:13px 28px;background:#5c3d22;color:#e8d5b0;text-decoration:none;border-radius:6px;font-size:14px;letter-spacing:.5px;margin:8px 0;}
  .footer{padding:20px 40px;border-top:1px solid #f4f0eb;font-size:12px;color:#b5a090;text-align:center;line-height:1.7;}
</style>
</head>
<body>
<div class="shell">
  <div class="header"><div class="brand">LEV AV</div></div>
  <div class="body">{$body}</div>
  <div class="footer">Lev Av &nbsp;·&nbsp; Come to the Heart of God<br>You are receiving this because you registered at levav.com</div>
</div>
</body>
</html>
HTML;
    }

    public static function registrationReceived(string $name): string
    {
        $body = <<<HTML
<h2>Welcome, {$name}</h2>
<div class="divider"></div>
<p>Thank you for applying to Lev Av. We've received your registration and our team will review your application personally.</p>
<p>You'll receive an email once your account has been approved — usually within 1–2 business days.</p>
<p>We look forward to welcoming you into this community.</p>
<p style="color:#b5a090;font-size:13px;font-style:italic;">— The Lev Av Team</p>
HTML;
        return self::wrap($body);
    }

    public static function registrationApproved(string $name, string $loginUrl): string
    {
        $body = <<<HTML
<h2>You're approved, {$name}</h2>
<div class="divider"></div>
<p>We're delighted to welcome you to Lev Av. Your account has been approved and you can now sign in to access your courses and community.</p>
<a href="{$loginUrl}" class="btn">Sign In to Lev Av</a>
<p style="margin-top:24px;color:#b5a090;font-size:13px;font-style:italic;">— The Lev Av Team</p>
HTML;
        return self::wrap($body);
    }

    public static function registrationRejected(string $name): string
    {
        $body = <<<HTML
<h2>Hello, {$name}</h2>
<div class="divider"></div>
<p>Thank you for your interest in Lev Av. After reviewing your application, we are unable to approve your registration at this time.</p>
<p>If you believe this is an error or would like to learn more, please don't hesitate to reach out to us directly.</p>
<p style="color:#b5a090;font-size:13px;font-style:italic;">— The Lev Av Team</p>
HTML;
        return self::wrap($body);
    }

    public static function adminNewStudent(string $studentName, string $studentEmail, string $reviewUrl): string
    {
        $body = <<<HTML
<h2>New Application</h2>
<div class="divider"></div>
<p>A new student has applied to join Lev Av and is awaiting your review.</p>
<p><strong>Name:</strong> {$studentName}<br><strong>Email:</strong> {$studentEmail}</p>
<a href="{$reviewUrl}" class="btn">Review Application</a>
HTML;
        return self::wrap($body);
    }

    public static function announcement(string $name, string $title, string $messageBody): string
    {
        $body = <<<HTML
<h2>{$title}</h2>
<div class="divider"></div>
<p>Hello {$name},</p>
{$messageBody}
<p style="margin-top:24px;color:#b5a090;font-size:13px;font-style:italic;">— The Lev Av Team</p>
HTML;
        return self::wrap($body);
    }

    public static function newCourseEnrolled(string $name, string $courseTitle, string $courseUrl): string
    {
        $body = <<<HTML
<h2>You're enrolled, {$name}</h2>
<div class="divider"></div>
<p>You've been successfully enrolled in <strong>{$courseTitle}</strong>. Your learning journey begins now.</p>
<a href="{$courseUrl}" class="btn">Start Learning</a>
<p style="margin-top:24px;color:#b5a090;font-size:13px;font-style:italic;">— The Lev Av Team</p>
HTML;
        return self::wrap($body);
    }
}