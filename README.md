# LEV AV — Full Project README
## From zero to running in order

---

## 1. Install Laravel & packages

```bash
composer create-project laravel/laravel lev-av
cd lev-av

# UUID
composer require ramsey/uuid

# Cloudinary
composer require cloudinary-labs/cloudinary-laravel

# HTTP client (for Brevo API)
# cURL is used directly — no extra package needed
```

---

## 2. Publish Cloudinary config

```bash
php artisan vendor:publish \
  --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider"
```

---

## 3. Configure .env

```env
APP_NAME="Lev Av"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_DATABASE=lev_av
DB_USERNAME=root
DB_PASSWORD=

# Brevo API (no SMTP needed)
BREVO_API_KEY=xkeysib-your-key-here
MAIL_FROM_ADDRESS=hello@levav.com
MAIL_FROM_NAME="Lev Av"

# Cloudinary
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

---

## 4. Create the database

```bash
mysql -u root -p -e "CREATE DATABASE lev_av CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

## 5. File placement guide

Place each delivered file at the path shown:

| Delivered file | Place at |
|---|---|
| `Models.php` | Split into individual files in `app/Models/` |
| `Migrations.php` | Paste Schema blocks into `database/migrations/` |
| `web.php` | `routes/web.php` |
| `Wiring.php` | Split: `AppServiceProvider`, middleware files, seeder |
| `admin.css` | `public/css/admin.css` |
| `student.css` | `public/css/student.css` |
| `public.css` | `public/css/public.css` |
| `admin-layout.blade.php` | `resources/views/layouts/admin.blade.php` |
| `student-layout.blade.php` | `resources/views/layouts/student.blade.php` |
| `public-layout-home.blade.php` | Split: `layouts/app.blade.php` + `views/public/home.blade.php` |
| `admin-dashboard.blade.php` | `resources/views/admin/dashboard.blade.php` |
| `admin-courses-index.blade.php` | `resources/views/admin/courses/index.blade.php` |
| `admin-course-form.blade.php` | `resources/views/admin/courses/form.blade.php` |
| `admin-lessons-index.blade.php` | `resources/views/admin/lessons/index.blade.php` |
| `admin-lesson-form.blade.php` | `resources/views/admin/lessons/form.blade.php` |
| `admin-students-index.blade.php` | `resources/views/admin/students/index.blade.php` |
| `admin-student-show.blade.php` | `resources/views/admin/students/show.blade.php` |
| `admin-announcements.blade.php` | Split: `admin/announcements/index.blade.php` + `create.blade.php` |
| `auth-register.blade.php` | `resources/views/auth/register.blade.php` |
| `auth-login.blade.php` | `resources/views/auth/login.blade.php` |
| `student-views.blade.php` | Split: `student/dashboard.blade.php`, `student/courses/index.blade.php`, `student/courses/show.blade.php` |
| `public-pages.blade.php` | Split: `public/about.blade.php`, `public/courses.blade.php`, `public/community.blade.php`, `public/contact.blade.php`, `auth/pending.blade.php` |
| `AdminControllers.php` | Split into `app/Http/Controllers/Admin/` |
| `AuthAdmin-Brevo-Controllers.php` | Replaces `RegisterController`, `StudentController`, `AnnouncementController` |
| `StudentControllers.php` | Split into `app/Http/Controllers/Student/` |
| `PublicController.php` | `app/Http/Controllers/PublicController.php` |
| `BrevoMailService.php` | Split: `app/Services/BrevoMailService.php` + `app/Services/EmailTemplates.php` |

---

## 6. Create folder structure

```bash
mkdir -p app/Http/Controllers/{Admin,Student,Auth}
mkdir -p app/Http/Middleware
mkdir -p app/Models
mkdir -p app/Services
mkdir -p app/Traits
mkdir -p resources/views/{layouts,components,public,admin/{courses,lessons,students,announcements},student/courses,auth,emails}
mkdir -p public/css
```

---

## 7. Create middleware

```bash
php artisan make:middleware RoleMiddleware
php artisan make:middleware ApprovedMiddleware
```

Paste code from `Wiring.php`.

---

## 8. Register middleware in bootstrap/app.php

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role'     => \App\Http\Middleware\RoleMiddleware::class,
        'approved' => \App\Http\Middleware\ApprovedMiddleware::class,
    ]);
})
```

---

## 9. Run migrations

```bash
php artisan migrate
```

---

## 10. Seed admin account

```bash
php artisan make:seeder AdminSeeder
# Paste seeder code from Wiring.php
php artisan db:seed --class=AdminSeeder
```

Admin credentials:
- **Email:** admin@levav.com
- **Password:** ChangeMe123!

---

## 11. Add to config/services.php

```php
'brevo' => [
    'api_key' => env('BREVO_API_KEY'),
],
```

---

## 12. Run

```bash
php artisan key:generate
php artisan serve
```

Visit: http://localhost:8000

---

## Complete URL map

| URL | Who | What |
|---|---|---|
| `/` | Public | Home page |
| `/about` | Public | About Lev Av |
| `/courses` | Public | Browse courses |
| `/community` | Public | Community page |
| `/contact` | Public | Contact form |
| `/register` | Guest | Apply / register |
| `/login` | Guest | Sign in |
| `/admin/dashboard` | Admin | Stats overview |
| `/admin/students` | Admin | Student list + approvals |
| `/admin/students/{id}` | Admin | Student profile |
| `/admin/courses` | Admin | Courses index ✅ |
| `/admin/courses/create` | Admin | New course form |
| `/admin/courses/{id}/edit` | Admin | Edit course + lessons list |
| `/admin/courses/{id}/lessons` | Admin | Lessons index ✅ |
| `/admin/courses/{id}/lessons/create` | Admin | New lesson form |
| `/admin/lessons/{id}/edit` | Admin | Edit lesson + resources |
| `/admin/announcements` | Admin | Announcements list |
| `/admin/announcements/create` | Admin | Compose announcement |
| `/dashboard` | Student | Student dashboard |
| `/dashboard/courses` | Student | My enrolled courses |
| `/dashboard/courses/{id}` | Student | Course player |
| `/dashboard/courses/{id}/lessons/{id}` | Student | Lesson view |

---

## Flow summary

```
Student registers
    → status = pending
    → Email: "Application received" (student)
    → Email: "New application" (all admins)

Admin reviews at /admin/students
    → Approves → status = approved
    → Email: "You're approved" with login link (student)

Student logs in
    → Redirected to /dashboard
    → Browses courses at /courses
    → Enrolls → Email: "Enrolled in X"
    → Watches lessons, marks complete
    → Progress tracked per enrollment
```

---

## Brevo setup (2 minutes)

1. Sign up at brevo.com
2. Go to **SMTP & API → API Keys → Generate new key**
3. Copy key → paste as `BREVO_API_KEY` in `.env`
4. Go to **Senders & IP → Senders** → add & verify `hello@levav.com`
5. Done — no SMTP configuration needed

---

## Cloudinary setup (2 minutes)

1. Sign up at cloudinary.com
2. Dashboard → copy **Cloud Name, API Key, API Secret**
3. Paste into `.env`
4. Create an upload preset named `lev_av_preset` (Settings → Upload → Add upload preset → unsigned)
5. Done