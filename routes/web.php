<?php

use App\Http\Controllers\Supervisor\ChangeRequestController;
use App\Http\Controllers\Teacher\ChangeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\authControlller;

use App\Http\Controllers\Supervisor\DashboardController;
use App\Http\Controllers\Supervisor\UserController;

use App\Http\Controllers\Supervisor\gradeController;
use App\Http\Controllers\Supervisor\sectionController;
use App\Http\Controllers\Supervisor\subjectController;
use App\Http\Controllers\Supervisor\teacherController;
use App\Http\Controllers\Supervisor\timeTableController;
use App\Http\Controllers\Supervisor\time_sessionCo;

use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Teacher\TeacherTimeController;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::get('/login', [authControlller::class, 'show'])->name('login');
Route::post('/login', [authControlller::class, 'login'])->name('login.submit');
Route::post('/logout', [authControlller::class, 'logout'])->name('logout');

Route::get('/redirect', [authControlller::class, 'redirectByRole'])
    ->middleware('auth')
    ->name('redirect');


/*
|--------------------------------------------------------------------------
| Supervisor (كل شي خاص بالمشرف)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('supervisor')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('supervisor.dashboard');

        // Users management (accounts)
        Route::get('/users', [UserController::class,'index'])->name('supervisor.users.index');
        Route::get('/users/create', [UserController::class,'create'])->name('supervisor.users.create');
        Route::post('/users', [UserController::class,'store'])->name('supervisor.users.store');
        Route::delete('/users/{user}', [UserController::class,'destroy'])->name('supervisor.users.destroy');

        // ===== Searches (Supervisor) =====
        Route::get('grade/search',   [gradeController::class,   'search'])->name('grade.search');
        Route::get('section/search', [sectionController::class, 'search'])->name('section.search');
        Route::get('subject/search', [subjectController::class, 'search'])->name('subject.search');
        Route::get('teacher/search', [teacherController::class, 'search'])->name('teacher.search');
        Route::get('timetable/search',[timeTableController::class,'search'])->name('timetable.search');

        // ===== Resources (Supervisor) =====
        Route::resource('grade', gradeController::class)->names([
            'index'   => 'grade.index',
            'create'  => 'grade.create',
            'show'    => 'grade.show',
            'edit'    => 'grade.edit',
            'store'   => 'grade.store',
            'update'  => 'grade.update',
            'destroy' => 'grade.destroy',
        ]);

        Route::resource('section', sectionController::class)->names([
            'index'   => 'section.index',
            'create'  => 'section.create',
            'show'    => 'section.show',
            'edit'    => 'section.edit',
            'store'   => 'section.store',
            'update'  => 'section.update',
            'destroy' => 'section.destroy',
        ]);

        Route::resource('subject', subjectController::class)->names([
            'index'   => 'subject.index',
            'create'  => 'subject.create',
            'show'    => 'subject.show',
            'edit'    => 'subject.edit',
            'store'   => 'subject.store',
            'update'  => 'subject.update',
            'destroy' => 'subject.destroy',
        ]);

        Route::resource('teacher', teacherController::class)->names([
            'index'   => 'teacher.index',
            'create'  => 'teacher.create',
            'show'    => 'teacher.show',
            'edit'    => 'teacher.edit',
            'store'   => 'teacher.store',
            'update'  => 'teacher.update',
            'destroy' => 'teacher.destroy',
        ]);

        // Timetable (Supervisor)
        Route::resource('timetable', timeTableController::class)->names([
            'index'   => 'timetable.index',
            'create'  => 'timetable.create',
            'store'   => 'timetable.store',
            'show'    => 'timetable.show',
            'edit'    => 'timetable.edit',
            'update'  => 'timetable.update',
            'destroy' => 'timetable.destroy',
        ]);

        // Sessions داخل جدول
        Route::post('timetable/{timetable}/sessions', [time_sessionCo::class, 'store'])
            ->name('timetable.sessions.store');

        Route::put('timetable/{timetable}/sessions/{session}', [time_sessionCo::class, 'update'])
            ->name('timetable.sessions.update');

        Route::delete('timetable/{timetable}/sessions/{session}', [time_sessionCo::class, 'destroy'])
            ->name('timetable.sessions.destroy');

        // Publish/Unpublish (داخل supervisor أفضل)
        Route::put('timetable/{timetable}/publish', [timeTableController::class, 'publish'])
            ->name('timetable.publish');

        Route::put('timetable/{timetable}/unpublish', [timeTableController::class, 'unpublish'])
            ->name('timetable.unpublish');
        Route::get('/change-requests', [ChangeRequestController::class, 'index'])
        ->name('change_requests.index');

        Route::get('/change-requests/{changeRequest}', [ChangeRequestController::class, 'show'])
        ->name('change_requests.show');

        Route::post('/change-requests/{changeRequest}/approve', [ChangeRequestController::class, 'approve'])
        ->name('change_requests.approve');

        Route::post('/change-requests/{changeRequest}/reject', [ChangeRequestController::class, 'reject'])
        ->name('change_requests.reject');
    });


/*
|--------------------------------------------------------------------------
| Teacher
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('teacher')
    ->group(function () {
        Route::get('/timetable', [TeacherTimeController::class, 'index'])
            ->name('teacher.timetable');
          Route::get('/change-requests', [ChangeController::class, 'index'])
        ->name('teacher.change_requests.index');

        Route::get('/change-requests/{session}/create', [ChangeController::class, 'create'])
        ->name('teacher.change_requests.create');

        Route::post('/change-requests/{session}', [ChangeController::class, 'store'])
        ->name('teacher.change_requests.store');
    });


/*
|--------------------------------------------------------------------------
| Student
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('student')
    ->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('student.dashboard');
    });
