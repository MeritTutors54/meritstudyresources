<?php

namespace App\Http\Controllers\Backend\PastPaper;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StorePastPaperRequest;
use App\Http\Requests\Backend\UpdatePastPaperRequest;
use App\Models\Category;
use App\Models\PastPaper;
use App\Models\PastPaperYear;
use App\Models\Resubcategory;
use App\Models\SubCategory;
use App\Operations\Backend\AdminActivity;
use App\Repositories\Interfaces\PastPaperRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PastPaperController extends Controller
{
    protected array $log;
    protected array $notification;

    public function __construct(
        protected PastPaperRepositoryInterface $pastPaperRepository,
    ) {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewPastPaper', Auth::user());

        return view('backend.past-paper.index');
    }

    public function create(): View
    {
        $this->authorize('createPastPaper', Auth::user());

        $examSeriesRaw = PastPaperYear::query()
            ->where(['is_active' => 1, 'is_deleted' => 0])
            ->orderBy('id', 'DESC') // fallback database order
            ->get();

        list($juneSeries, $novemberSeries) = $examSeriesRaw->partition(function ($item) {
            return str_contains(strtolower($item->name), 'june');
        });


        $sortedJune = $juneSeries->sortByDesc(function ($item) {
            return strtotime($item->name);
        });

        $sortedNovember = $novemberSeries->sortByDesc(function ($item) {
            return strtotime($item->name);
        });

        $examSeries = $sortedJune->merge($sortedNovember);

        $categories = Category::query()
            ->where(['is_active' => 1, 'is_deleted' => 0])
            ->orderBy('id', 'DESC')
            ->get();

        $old_cat = old('category');
        if (!empty($old_cat)) {
            $subcategories = SubCategory::query()
                ->where('category_id', $old_cat)
                ->where(['is_active' => 1, 'is_deleted' => 0])
                ->orderBy('id', 'DESC')
                ->get();
        }

        $old_sub = old('subcategory');
        if (!empty($old_sub)) {
            $resubcategories = Resubcategory::query()
                ->where('category_id', $old_cat)
                ->where('subcategory_id', $old_sub)
                ->where(['is_active' => 1, 'is_deleted' => 0])
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('backend.past-paper.form')
            ->with([
                'examSeries' => $examSeries,
                'categories' => $categories,
                'old_cat' => $subcategories ?? null,
                'old_sub' => $resubcategories ?? null,
            ]);
    }

    public function store(StorePastPaperRequest $request)
    {
        $this->authorize('createPastPaper', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\PastPaper',
        ];

        $category = Category::query()
            ->where('id', $request->category)
            ->select(['id', 'category_name', 'slug'])->first();
        $subcategory = SubCategory::query()
            ->where('id', $request->subcategory)
            ->select(['id', 'subcategory_name', 'slug'])->first();
        $resubcategory = Resubcategory::query()
            ->where('id', $request->resubcategory)
            ->select(['id', 'resubcategory_name', 'slug'])->first();


        DB::beginTransaction();
        try {
            $pastPaperID = PastPaper::insertGetId([
                'title' => $request->title,
                'exam_series' => $request->exam_series,
                'uploads_type' => 'PASTPAPER',
                'category' => $request->category,
                'subcategory' => $request->subcategory,
                'resubcategory' => $request->resubcategory,
                'is_paid' => $request->is_paid,
                'is_active' => $request->is_active,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);


            if ($request->have_solution == 1) {
                PastPaper::where('id', $pastPaperID)->update([
                    'have_solution' => $request->have_solution,
                    'have_video_solution' => $request->have_video_solution ?? 0,
                    'have_pdf_solution' => $request->have_pdf_solution ?? 0,
                    'video_procedure' => $request->video_procedure,
                    'video_links' => $request->video_links,
                    'video_solution' => $request->video_solution,
                ]);
                // Handle 'video_solution' upload
                if ($request->hasFile('video_solution')) {
                    $videoFile = $request->file('video_solution');
                    $videoName = $category->slug . '-' . $subcategory->slug . '-' . $resubcategory->slug . '-video-solution-' . $pastPaperID . '.' . $videoFile->getClientOriginalExtension();
                    $videoFile->move(public_path('uploads/pastpaper/'), $videoName);

                    PastPaper::where('id', $pastPaperID)->update([
                        'video_solution' => $videoName,
                    ]);
                }
                // Handle 'pdf_solution' upload
                if ($request->hasFile('pdf_solution')) {
                    $PDFSolution = $request->file('pdf_solution');
                    $PDFSolutionName = $category->slug . '-' . $subcategory->slug . '-' . $resubcategory->slug . '-pdf-solution-' . $pastPaperID . '.' . $PDFSolution->getClientOriginalExtension();
                    $PDFSolution->move(public_path('uploads/pastpaper/'), $PDFSolutionName);

                    PastPaper::query()->where('id', $pastPaperID)->update([
                        'pdf_solution' => $PDFSolutionName,
                    ]);
                }
            }

            // Handle 'ques_paper' file upload
            if ($request->hasFile('ques_paper')) {
                $imagef = $request->file('ques_paper');
                $imageName = $category->slug . '-' . $subcategory->slug . '-' . $resubcategory->slug . '-question-paper-' . $pastPaperID . '.' . $imagef->getClientOriginalExtension();
                $imagef->move(public_path('uploads/pastpaper/'), $imageName);

                PastPaper::where('id', $pastPaperID)->update([
                    'ques_paper' => $imageName,
                ]);
            }

            // Handle 'ans_paper' file upload
            if ($request->hasFile('ans_paper')) {
                $imagefs = $request->file('ans_paper');
                $imageName = $category->slug . '-' . $subcategory->slug . '-' . $resubcategory->slug . '-answer-paper-' . $pastPaperID . '.' . $imagefs->getClientOriginalExtension();
                $imagefs->move(public_path('uploads/pastpaper/'), $imageName);

                PastPaper::where('id', $pastPaperID)->update([
                    'ans_paper' => $imageName,
                ]);
            }

            AdminActivity::track($this->log);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'PastPaper has been created';

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'PastPaper has been created successfully.'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return response()->json([
            'status' => 'error',
            'message' => $exception->getMessage()
        ], 500);


        // return to_route('admin.past-papers.create')
        //     ->with($this->notification['status'], $this->notification['message']);
    }

    // video uploads
    private function uploadFile($file)
    {
        // Define file storage path
        $destinationPath = 'uploads/videos/';
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
        return $destinationPath . $fileName;
    }
    //
    // index

    // index
    public function alevel()
    {
        $allData = PastPaper::where('is_deleted', 0)->where('category', 10)->orderBy('id', 'DESC')->get();
        return view('backend.pastpaper.alevel', compact('allData'));
    }

    public function aslevel()
    {
        $allData = PastPaper::where('is_deleted', 0)->where('category', 11)->orderBy('id', 'DESC')->get();
        return view('backend.pastpaper.aslevel', compact('allData'));
    }

    public function gcse()
    {
        $allData = PastPaper::where('is_deleted', 0)->where('category', 12)->orderBy('id', 'DESC')->get();
        return view('backend.pastpaper.gcse', compact('allData'));
    }

    public function igcse()
    {
        $allData = PastPaper::where('is_deleted', 0)->where('category', 13)->orderBy('id', 'DESC')->get();
        return view('backend.pastpaper.igcse', compact('allData'));
    }

    // edit
    public function edit(PastPaper $past_paper)
    {
        $this->authorize('editPastPaper', Auth::user());

        $examSeriesRaw = PastPaperYear::query()
            ->where(['is_active' => 1, 'is_deleted' => 0])
            ->orderBy('id', 'DESC') // fallback database order
            ->get();

        list($juneSeries, $novemberSeries) = $examSeriesRaw->partition(function ($item) {
            return str_contains(strtolower($item->name), 'june');
        });


        $sortedJune = $juneSeries->sortByDesc(function ($item) {
            return strtotime($item->name);
        });

        $sortedNovember = $novemberSeries->sortByDesc(function ($item) {
            return strtotime($item->name);
        });

        $examSeries = $sortedJune->merge($sortedNovember);

        $categories = Category::query()
            ->where(['is_active' => 1, 'is_deleted' => 0])
            ->orderBy('id', 'DESC')
            ->get();

        $subcategories = SubCategory::query()
            ->where('category_id', $past_paper->category)
            ->where(['is_active' => 1, 'is_deleted' => 0])
            ->orderBy('id', 'DESC')
            ->get();

        $resubcategories = Resubcategory::query()
            ->where('subcategory_id', $past_paper->subcategory)
            ->where(['is_active' => 1, 'is_deleted' => 0])
            ->orderBy('id', 'DESC')
            ->get();

        return view('backend.past-paper.form')
            ->with([
                'past_paper' => $past_paper,
                'examSeries' => $examSeries,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'resubcategories' => $resubcategories,
            ]);
    }

    public function update(UpdatePastPaperRequest $request, PastPaper $past_paper)
    {
        $this->authorize('updatePastPaper', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Category',
            'old_data' => json_encode($past_paper->toArray()),
        ];

        $category = Category::query()
            ->where('id', $request->category)
            ->select(['id', 'category_name', 'slug'])->first();
        $subcategory = SubCategory::query()
            ->where('id', $request->subcategory)
            ->select(['id', 'subcategory_name', 'slug'])->first();
        $resubcategory = Resubcategory::query()
            ->where('id', $request->resubcategory)
            ->select(['id', 'resubcategory_name', 'slug'])->first();

        DB::beginTransaction();
        try {
            // Update main PastPaper record
            $update = PastPaper::where('id', $past_paper->id)->update([
                'title' => $request->title,
                'exam_series' => $request->exam_series,
                'category' => $request->category,
                'subcategory' => $request->subcategory,
                'resubcategory' => $request->resubcategory,
                'is_paid' => $request->is_paid,
                'is_active' => $request->is_active,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            if ($request->have_solution == 1) {
                PastPaper::where('id', $past_paper->id)->update([
                    'have_solution' => $request->have_solution,
                    'have_video_solution' => $request->have_video_solution ?? 0,
                    'have_pdf_solution' => $request->have_pdf_solution ?? 0,
                    'video_procedure' => $request->video_procedure,
                    'video_links' => $request->video_links,
                    'video_solution' => $request->video_solution,
                ]);

                if ($request->hasFile('video_solution')) {
                    PastPaper::where('id', $past_paper->id)->update([
                        'video_solution' => $this->uploadFile($request->file('video_solution')),
                    ]);
                }


                if ($request->hasFile('pdf_solution')) {
                    $existing = $past_paper;
                    if ($existing && $existing->pdf_solution && file_exists(public_path('uploads/pastpaper/' . $existing->pdf_solution))) {
                        unlink(public_path('uploads/pastpaper/' . $existing->pdf_solution));
                    }

                    $PDFSolution = $request->file('pdf_solution');
                    $PDFSolutionName = $category->slug . '-' . $subcategory->slug . '-' . $resubcategory->slug . '-pdf-solution-' . $past_paper->id . '.' . $PDFSolution->getClientOriginalExtension();
                    $PDFSolution->move(public_path('uploads/pastpaper/'), $PDFSolutionName);

                    $existing->update([
                        'pdf_solution' => $PDFSolutionName ?? '',
                    ]);
                }
            }
            if ($request->hasFile('ques_paper')) {
                $existing = $past_paper;
                if ($existing && $existing->ques_paper && file_exists(public_path('uploads/pastpaper/' . $existing->ques_paper))) {
                    unlink(public_path('uploads/pastpaper/' . $existing->ques_paper));
                }

                $imagef = $request->file('ques_paper');
                $imageName = $category->slug . '-' . $subcategory->slug . '-' . $resubcategory->slug . '-question-paper-' . $past_paper->id . '.' . $imagef->getClientOriginalExtension();
                $imagef->move(public_path('uploads/pastpaper/'), $imageName);

                $existing->update([
                    'ques_paper' => $imageName,
                ]);
            }
            if ($request->hasFile('ans_paper')) {
                $existing = $past_paper;
                if ($existing && $existing->ans_paper && file_exists(public_path('uploads/pastpaper/' . $existing->ans_paper))) {
                    unlink(public_path('uploads/pastpaper/' . $existing->ans_paper));
                }

                $imagefs = $request->file('ans_paper');
                $imageName = $category->slug . '-' . $subcategory->slug . '-' . $resubcategory->slug . '-answer-paper-' . $past_paper->id . '.' . $imagefs->getClientOriginalExtension();
                $imagefs->move(public_path('uploads/pastpaper/'), $imageName);

                $existing->update([
                    'ans_paper' => $imageName,
                ]);
            }

            AdminActivity::track($this->log, $past_paper);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'PastPaper has been updated';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return response()->json([
            'status' => $this->notification['status'],
            'message' => $this->notification['message']
        ], 200);

        // return back()
        //     ->with($this->notification['status'], $this->notification['message']);
    }

    public function destroy(PastPaper $past_paper)
    {
        $this->authorize('deletePastPaper', Auth::user());

        $this->log = [
            'action' => 'deleted',
            'model_type' => 'App\Models\Category', // Side note: make sure this shouldn't be 'App\Models\PastPaper'!
            'old_data' => json_encode($past_paper->toArray()),
        ];

        DB::beginTransaction();
        try {
            $past_paper->delete();
            AdminActivity::track($this->log, $past_paper);

            DB::commit();

            // Return a proper JSON response for your AJAX success block
            return response()->json([
                'success' => true,
                'message' => 'PastPaper has been deleted'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return response()->json([
            'success' => false,
            'message' => $exception->getMessage()
        ], 500);
    }

    // active
    public function active($id)
    {
        $active = PastPaper::where('id', $id)->update([
            'is_active' => 1,
        ]);
        if ($active) {
            $notification = array(
                'messege' => 'Update success',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        } else {
            $notification = array(
                'messege' => 'Update Faild',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    // DeActive
    public function deActive($id)
    {
        $active = PastPaper::where('id', $id)->update([
            'is_active' => 0,
        ]);
        if ($active) {
            $notification = array(
                'messege' => 'Update success',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        } else {
            $notification = array(
                'messege' => 'Update Faild',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($notification);
        }
    }

    public function missingPastPaper()
    {
        $wrongPdfFiles = PastPaper::with([
            'category_model',
            'subcategory_model',
            'resubcategory_model',
            'series'
        ])
            ->where('is_deleted', 0)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('ques_paper', 'LIKE', '%pdf')
                        ->where('ques_paper', 'NOT LIKE', '%.pdf');
                })
                    ->orWhere(function ($q) {
                        $q->where('ans_paper', 'LIKE', '%pdf')
                            ->where('ans_paper', 'NOT LIKE', '%.pdf');
                    });
            })
            ->orderBy('id', 'DESC')
            ->get();


        return view('backend.past-paper.missing-past-papers.index', compact('wrongPdfFiles'));
    }
}
