<?php
// ============================================================
// routes/web.php  —  COMPLETE FINAL VERSION
// ============================================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Student;

// ── Public ────────────────────────────────────────────────────
Route::get('/',          [PublicController::class, 'home'])->name('home');
Route::get('/about',     [PublicController::class, 'about'])->name('about');
Route::get('/courses',   [PublicController::class, 'courses'])->name('courses');
Route::get('/community', [PublicController::class, 'community'])->name('community');
Route::get('/contact',   [PublicController::class, 'contact'])->name('contact');
Route::post('/contact',  [PublicController::class, 'sendContact'])->name('contact.send');

// ── Auth ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register',         [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register',        [RegisterController::class, 'store'])->name('register.store');
    Route::get('/register/pending', fn() => view('auth.pending'))->name('register.pending');
    Route::get('/login',            [LoginController::class, 'showForm'])->name('login');
    Route::post('/login',           [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

// ── Admin ─────────────────────────────────────────────────────
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth', 'role:admin'])
     ->group(function () {

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
         ->name('dashboard');

    // Students
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/',             [Admin\StudentController::class, 'index'])->name('index');
        Route::get('/{user}',       [Admin\StudentController::class, 'show'])->name('show');
        Route::post('/{user}/approve', [Admin\StudentController::class, 'approve'])->name('approve');
        Route::post('/{user}/reject',  [Admin\StudentController::class, 'reject'])->name('reject');
    });

    // Courses + nested Lessons (shallow)
    Route::resource('courses', Admin\CourseController::class);

    Route::resource('courses.lessons', Admin\LessonController::class)
         ->shallow()
         ->only(['index','create','store','edit','update','destroy']);

    // Resources (attached to lessons)
    Route::post('/lessons/{lesson}/resources',  [Admin\ResourceController::class, 'store'])
         ->name('resources.store');
    Route::delete('/resources/{resource}',      [Admin\ResourceController::class, 'destroy'])
         ->name('resources.destroy');

    // Announcements
    Route::get('/announcements',         [Admin\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create',  [Admin\AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements',        [Admin\AnnouncementController::class, 'store'])->name('announcements.store');
});

// ── Student ───────────────────────────────────────────────────
Route::prefix('dashboard')
     ->name('student.')
     ->middleware(['auth', 'role:student', 'approved'])
     ->group(function () {

    Route::get('/',        [Student\DashboardController::class, 'index'])->name('dashboard');

    // Courses
    Route::get('/courses', [Student\CourseController::class, 'index'])->name('courses');
    Route::get('/courses/{course}', [Student\CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/enroll', [Student\CourseController::class, 'enroll'])->name('courses.enroll');

    // Lessons
    Route::get('/courses/{course}/lessons/{lesson}',
        [Student\LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{course}/lessons/{lesson}/complete',
        [Student\LessonController::class, 'complete'])->name('lessons.complete');
});