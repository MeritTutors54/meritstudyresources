<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Enums\ResourceType;
use App\Http\Controllers\Controller;
use App\Models\CourseDocument;
use App\Models\CurriculumCourse;
use App\Models\CurriculumLesson;
use App\Models\CurriculumPhase;
use App\Models\CurriculumSubject;
use App\Models\CurriculumUnit;
use App\Models\CurriculumYear;
use App\Models\DownloadHistory;
use App\Models\LessonResource;
use App\Models\LessonResourceType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class TeacherLibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        // $this->authorize('viewTeacherLibrary', Auth::user());

        $cards = [
            ['Phases', CurriculumPhase::count(), 'admin.teacher-library.phases.index', 'viewCurriculumPhase', 'Step 1'],
            ['Years', CurriculumYear::count(), 'admin.teacher-library.years.index', 'viewCurriculumYear', 'Step 2'],
            ['Subjects', CurriculumSubject::count(), 'admin.teacher-library.subjects.index', 'viewCurriculumSubject', 'Step 3'],
            ['File types', LessonResourceType::count(), 'admin.teacher-library.resource-types.index', 'viewLessonResourceType', 'Step 3'],
            ['Courses', CurriculumCourse::count(), 'admin.teacher-library.courses.index', 'viewCurriculumCourse', 'Step 4'],
            ['Course documents', CourseDocument::count(), null, 'viewCourseDocument', 'Step 4'],
            ['Units', CurriculumUnit::count(), null, 'viewCurriculumUnit', 'Step 5'],
            ['Lessons', CurriculumLesson::count(), null, 'viewCurriculumLesson', 'Step 6'],
            ['Lesson files', LessonResource::count(), null, 'viewLessonResource', 'Step 7'],
            [
                'Downloads (30 days)',
                DownloadHistory::query()
                    ->whereNotNull('lesson_resource_id')
                    ->where('type', ResourceType::LESSON->value)
                    ->where('created_at', '>=', now()->subDays(30))
                    ->count(),
                'admin.teacher-library.downloads.index',
                'viewLessonDownloads',
                'Step 8',
            ],
        ];

        $cards = collect($cards)->map(fn ($c) => [
            'label'   => $c[0],
            'count'   => $c[1],
            'url'     => $c[2] && Route::has($c[2]) ? route($c[2]) : null,
            'allowed' => Auth::user()->can($c[3], Auth::user()),
            'step'    => $c[4],
        ]);

        return view('backend.teacher-library.index', ['cards' => $cards]);
    }
}