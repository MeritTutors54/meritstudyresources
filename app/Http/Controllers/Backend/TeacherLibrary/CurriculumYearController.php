<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\CurriculumYearRequest;
use App\Models\CurriculumPhase;
use App\Models\CurriculumYear;
use App\Services\UniqueSlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/** Step 2 — Years (Teacher Library admin). */
class CurriculumYearController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        // $this->authorize('viewCurriculumYear', Auth::user());

        $yearList = CurriculumYear::query()
            ->with('phase')
            ->withCount('courses')
            ->join('curriculum_phases', 'curriculum_phases.id', '=', 'curriculum_years.phase_id')
            ->orderBy('curriculum_phases.sort_order')
            ->orderBy('curriculum_years.sort_order')
            ->select('curriculum_years.*')
            ->get();

        return view('backend.teacher-library.years.index', ['items' => $yearList]);
    }

    public function create(): View
    {
        // $this->authorize('createCurriculumYear', Auth::user());

        return view('backend.teacher-library.years.form', [
            'phases' => CurriculumPhase::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(CurriculumYearRequest $request): RedirectResponse
    {
        // $this->authorize('createCurriculumYear', Auth::user());

        $data = $request->validated();

        return $this->save('created', CurriculumYear::class, null, function () use ($data) {
            $data['slug'] = UniqueSlugService::make(CurriculumYear::class, $data['name']);
            $data['sort_order'] ??= (int) CurriculumYear::query()->where('phase_id', $data['phase_id'])->max('sort_order') + 1;

            return CurriculumYear::query()->create($data);
        }, 'Year created successfully.', route('admin.teacher-library.years.index'));
    }

    public function edit(CurriculumYear $year): View
    {
        // $this->authorize('updateCurriculumYear', Auth::user());

        return view('backend.teacher-library.years.form', [
            'item' => $year,
            'phases' => CurriculumPhase::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function update(CurriculumYearRequest $request, CurriculumYear $year): RedirectResponse
    {
        // $this->authorize('updateCurriculumYear', Auth::user());

        $data = $request->validated();
        $before = clone $year;

        return $this->save('updated', CurriculumYear::class, $before, function () use ($data, $year) {
            if ($data['name'] !== $year->name) {
                $data['slug'] = UniqueSlugService::make(CurriculumYear::class, $data['name'], $year->id);
            }
            $data['sort_order'] ??= $year->sort_order;

            $year->update($data);

            return $year;
        }, 'Year updated successfully.', route('admin.teacher-library.years.index'));
    }

    public function destroy(CurriculumYear $year): RedirectResponse
    {
        // $this->authorize('deleteCurriculumYear', Auth::user());

        if ($year->courses()->exists()) {
            return $this->refuse(
                "\"{$year->name}\" still has courses. Move or delete its courses first.",
                route('admin.teacher-library.years.index')
            );
        }

        $before = clone $year;

        return $this->save('deleted', CurriculumYear::class, $before, function () use ($year) {
            $year->delete();

            return $year;
        }, 'Year deleted successfully.', route('admin.teacher-library.years.index'));
    }
}
