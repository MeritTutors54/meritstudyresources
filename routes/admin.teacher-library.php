<?php

/*
|--------------------------------------------------------------------------
| Teacher Library — admin routes
|--------------------------------------------------------------------------
| Loaded from routes/admin.web.php INSIDE the ['auth:admin', 'team.permission']
| group, so every route here is already /admin/... and admin-only.
|
| URL prefix : /admin/teacher-library
| Name prefix: admin.teacher-library.
|
| Each step's block is commented out until its controller exists.
| Building a step = create the controller, then uncomment its block.
| The sidebar shows a link only when its route exists (Route::has),
| so links appear by themselves as steps are switched on.
*/

use App\Http\Controllers\Backend\TeacherLibrary\TeacherLibraryController;
use Illuminate\Support\Facades\Route;

Route::prefix('teacher-library')
    ->name('admin.teacher-library.')
    ->group(function () {

        // Step 0 — landing page: counts + links to every screen
        Route::get('/', [TeacherLibraryController::class, 'index'])->name('index');

        // Step 1 — Phases
        Route::resource('phases', \App\Http\Controllers\Backend\TeacherLibrary\CurriculumPhaseController::class)->except(['show']);

        // Step 2 — Years
        Route::resource('years', \App\Http\Controllers\Backend\TeacherLibrary\CurriculumYearController::class)->except(['show']);

        // Step 3 — Subjects and file types
        Route::resource('subjects', \App\Http\Controllers\Backend\TeacherLibrary\CurriculumSubjectController::class)->except(['show']);
        Route::resource('resource-types', \App\Http\Controllers\Backend\TeacherLibrary\LessonResourceTypeController::class)->except(['show']);

        // Step 4 — Courses (show = the course hub) and course documents
        Route::resource('courses', \App\Http\Controllers\Backend\TeacherLibrary\CurriculumCourseController::class);
        Route::resource('courses.documents', \App\Http\Controllers\Backend\TeacherLibrary\CourseDocumentController::class)->shallow()->except(['index', 'show']);
        Route::get('documents/{document}/file', [\App\Http\Controllers\Backend\TeacherLibrary\CourseDocumentController::class, 'file'])->name('documents.file');

        // Step 5 — Units (listed on the course hub) + reorder
        Route::patch('courses/{course}/units/reorder', [\App\Http\Controllers\Backend\TeacherLibrary\CurriculumUnitController::class, 'reorder'])->name('courses.units.reorder');
        Route::resource('courses.units', \App\Http\Controllers\Backend\TeacherLibrary\CurriculumUnitController::class)->shallow()->except(['index']);

        // Step 6 — Lessons (listed on the unit page) + reorder + renumber codes
        Route::patch('units/{unit}/lessons/reorder', [\App\Http\Controllers\Backend\TeacherLibrary\CurriculumLessonController::class, 'reorder'])->name('units.lessons.reorder');
        Route::post('courses/{course}/renumber', [\App\Http\Controllers\Backend\TeacherLibrary\CurriculumLessonController::class, 'renumber'])->name('courses.renumber');
        Route::resource('units.lessons', \App\Http\Controllers\Backend\TeacherLibrary\CurriculumLessonController::class)->shallow()->except(['index']);

        // Step 7 — Lesson files (listed on the lesson page) + reorder + admin preview
        Route::patch('lessons/{lesson}/resources/reorder', [\App\Http\Controllers\Backend\TeacherLibrary\LessonResourceController::class, 'reorder'])->name('lessons.resources.reorder');
        Route::get('resources/{resource}/file', [\App\Http\Controllers\Backend\TeacherLibrary\LessonResourceController::class, 'file'])->name('resources.file');
        Route::resource('lessons.resources', \App\Http\Controllers\Backend\TeacherLibrary\LessonResourceController::class)->shallow()->except(['index', 'show']);

        // Step 8 — Downloads report (read only) + CSV export
        Route::get('downloads', [\App\Http\Controllers\Backend\TeacherLibrary\LessonDownloadReportController::class, 'index'])->name('downloads.index');
        Route::get('downloads/export', [\App\Http\Controllers\Backend\TeacherLibrary\LessonDownloadReportController::class, 'export'])->name('downloads.export');
    });
