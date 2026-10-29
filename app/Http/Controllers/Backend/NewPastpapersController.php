<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

class NewPastpapersController extends Controller
{
    public function create(){
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
            ->orderBy('category_name')
            ->get();

        $old_cat = old('category');
        if (!empty($old_cat)) {
            $subcategories = SubCategory::query()
                ->where('category_id', $old_cat)
                ->where(['is_active' => 1, 'is_deleted' => 0])
                ->orderBy('subcategory_name')
                ->get();
        }

        $old_sub = old('subcategory');
        if (!empty($old_sub)) {
            $resubcategories = Resubcategory::query()
                ->where('category_id', $old_cat)
                ->where('subcategory_id', $old_sub)
                ->where(['is_active' => 1, 'is_deleted' => 0])
                ->orderBy('resubcategory_name')
                ->get();
        }

         return view('backend.pastpaperupdate.maincreate')
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
            'status' => $this->notification['status'],
            'message' => $this->notification['message']
        ], 500);


        // return to_route('admin.past-papers.create')
        //     ->with($this->notification['status'], $this->notification['message']);
    }

    public function update(Request $request){

        return $request;

    }
}
