<?php

namespace App\Http\Controllers\Backend\TeacherLibrary;

use App\Http\Controllers\Backend\TeacherLibrary\Concerns\TeacherLibraryWrites;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherLibrary\CurriculumPhaseRequest;
use App\Models\CurriculumPhase;
use App\Services\UniqueSlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/** Step 1 — Phases (Teacher Library admin). */
class CurriculumPhaseController extends Controller
{
    use TeacherLibraryWrites;

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        // $this->authorize('viewCurriculumPhase', Auth::user());

        $phaseList = CurriculumPhase::query()
            ->withCount('years')
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        return view('backend.teacher-library.phases.index', ['items' => $phaseList]);
    }

    public function create(): View
    {
        // $this->authorize('createCurriculumPhase', Auth::user());

        return view('backend.teacher-library.phases.form', [
        ]);
    }

    public function store(CurriculumPhaseRequest $request): RedirectResponse
    {
        // $this->authorize('createCurriculumPhase', Auth::user());

        $data = $request->validated();

        return $this->save('created', CurriculumPhase::class, null, function () use ($data) {
            $data['slug'] = UniqueSlugService::make(CurriculumPhase::class, $data['name']);
            $data['sort_order'] ??= (int) CurriculumPhase::query()->max('sort_order') + 1;

            return CurriculumPhase::query()->create($data);
        }, 'Phase created successfully.', route('admin.teacher-library.phases.index'));
    }

    public function edit(CurriculumPhase $phase): View
    {
        // $this->authorize('updateCurriculumPhase', Auth::user());

        return view('backend.teacher-library.phases.form', [
            'item' => $phase,
        ]);
    }

    public function update(CurriculumPhaseRequest $request, CurriculumPhase $phase): RedirectResponse
    {
        // $this->authorize('updateCurriculumPhase', Auth::user());

        $data = $request->validated();
        $before = clone $phase;

        return $this->save('updated', CurriculumPhase::class, $before, function () use ($data, $phase) {
            if ($data['name'] !== $phase->name) {
                $data['slug'] = UniqueSlugService::make(CurriculumPhase::class, $data['name'], $phase->id);
            }
            $data['sort_order'] ??= $phase->sort_order;

            $phase->update($data);

            return $phase;
        }, 'Phase updated successfully.', route('admin.teacher-library.phases.index'));
    }

    public function destroy(CurriculumPhase $phase): RedirectResponse
    {
        // $this->authorize('deleteCurriculumPhase', Auth::user());

        if ($phase->years()->exists()) {
            return $this->refuse(
                "\"{$phase->name}\" still has years. Move or delete its years first.",
                route('admin.teacher-library.phases.index')
            );
        }

        $before = clone $phase;

        return $this->save('deleted', CurriculumPhase::class, $before, function () use ($phase) {
            $phase->delete();

            return $phase;
        }, 'Phase deleted successfully.', route('admin.teacher-library.phases.index'));
    }
}
