<?php

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

          
Route::post('/test-direct', function() {
    return response()->json(['hit' => true]);
})->name('test.direct');

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
     Route::prefix('courses')->name('courses.')->group(function () {
         Route::get('/',                 [Admin\CourseController::class, 'index'])->name('index');
         Route::get('/create',           [Admin\CourseController::class, 'create'])->name('create');
         Route::post('/store',           [Admin\CourseController::class, 'store'])->name('store');
         Route::get('/{course}',         [Admin\CourseController::class, 'show'])->name('show');
         Route::get('/{course}/edit',    [Admin\CourseController::class, 'edit'])->name('edit');
         Route::post('/{course}/update', [Admin\CourseController::class, 'update'])->name('update');
         Route::post('/{course}/delete', [Admin\CourseController::class, 'destroy'])->name('destroy');

         // Nested lessons
         Route::prefix('/{course}/lessons')->name('lessons.')->group(function () {
             Route::get('/create',           [Admin\LessonController::class, 'create'])->name('create');
             Route::post('/store',           [Admin\LessonController::class, 'store'])->name('store');
         });
     });



     // Shallow lesson routes (edit/update/delete by lesson ID only)
     Route::prefix('lessons')->name('lessons.')->group(function () {
         Route::get('/{lesson}/edit',    [Admin\LessonController::class, 'edit'])->name('edit');
         Route::post('/{lesson}/update', [Admin\LessonController::class, 'update'])->name('update');
         Route::post('/{lesson}/delete', [Admin\LessonController::class, 'destroy'])->name('destroy');
     });

    // Resources (attached to lessons)
    Route::post('/lessons/{lesson}/resources',  [Admin\ResourceController::class, 'store'])
         ->name('resources.store');
    Route::delete('/resources/{resource}',      [Admin\ResourceController::class, 'destroy'])
         ->name('resources.destroy');

    // Announcements
    Route::get('/announcements',         [Admin\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create',  [Admin\AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements',        [Admin\AnnouncementController::class, 'store'])->name('announcements.store');

    //discussions
    Route::get('/discussions',                        [Admin\DiscussionController::class, 'index'])->name('discussions.index');
     Route::get('/discussions/{discussion}',           [Admin\DiscussionController::class, 'show'])->name('discussions.show');
     Route::post('/discussions/{discussion}/reply',    [Admin\DiscussionController::class, 'reply'])->name('discussions.reply');
     Route::post('/discussions/{discussion}/pin',      [Admin\DiscussionController::class, 'togglePin'])->name('discussions.pin');
     Route::delete('/discussions/{discussion}',        [Admin\DiscussionController::class, 'destroy'])->name('discussions.destroy');
     Route::delete('/discussions/replies/{reply}',     [Admin\DiscussionController::class, 'destroyReply'])->name('discussions.reply.destroy');

     //profile
     Route::get('/profile',           [Admin\ProfileController::class, 'show'])->name('profile');
     Route::post('/profile',          [Admin\ProfileController::class, 'update'])->name('profile.update');
     Route::post('/profile/password', [Admin\ProfileController::class, 'updatePassword'])->name('profile.password');

     //admins
     Route::get('/admins',            [Admin\AdminUserController::class, 'index'])->name('admins.index');
     Route::get('/admins/create',     [Admin\AdminUserController::class, 'create'])->name('admins.create');
     Route::post('/admins',           [Admin\AdminUserController::class, 'store'])->name('admins.store');
     Route::delete('/admins/{user}',  [Admin\AdminUserController::class, 'destroy'])->name('admins.destroy');
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
    Route::get('/courses/{course}/discussions',                   [Student\DiscussionController::class, 'index'])->name('discussions.index');
     Route::post('/courses/{course}/discussions',                  [Student\DiscussionController::class, 'store'])->name('discussions.store');
     Route::get('/courses/{course}/discussions/{discussion}',      [Student\DiscussionController::class, 'show'])->name('discussions.show');
     Route::post('/courses/{course}/discussions/{discussion}/reply',   [Student\DiscussionController::class, 'reply'])->name('discussions.reply');
     Route::delete('/courses/{course}/discussions/{discussion}',       [Student\DiscussionController::class, 'destroy'])->name('discussions.destroy');
     Route::delete('/courses/{course}/discussions/{discussion}/replies/{reply}', [Student\DiscussionController::class, 'destroyReply'])->name('discussions.reply.destroy');


    // Lessons
    Route::get('/courses/{course}/lessons/{lesson}',
        [Student\LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{course}/lessons/{lesson}/complete',
        [Student\LessonController::class, 'complete'])->name('lessons.complete');

     //Profile
     Route::get('/profile',           [Student\ProfileController::class, 'show'])->name('profile');
     Route::post('/profile',          [Student\ProfileController::class, 'update'])->name('profile.update');
     Route::post('/profile/password', [Student\ProfileController::class, 'updatePassword'])->name('profile.password');
});