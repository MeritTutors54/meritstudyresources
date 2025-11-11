<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Enums\BlogImageType;
use App\Enums\CommentStatus;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBlogRequest;
use App\Http\Requests\Backend\UpdateBlogRequest;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogImage;
use App\Models\Blogs;
use App\Models\BlogTag;
use App\Models\Tag;
use App\Operations\Backend\AdminActivity;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BlogsController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $this->authorize('viewBlog', Auth::user());

        $blogs = Blogs::all();

        return view('backend.blogs.index')
            ->with([
                'blogs' => $blogs,
            ]);
    }

    public function create(): View
    {

        $this->authorize('createBlog', Auth::user());

        $blogCategories = BlogCategory::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $statuses = Status::cases();

        $tags = Tag::query()
            ->get();

        return view('backend.blogs.form')
            ->with([
                'statuses' => $statuses,
                'blogCategories' => $blogCategories,
                'tags' => $tags,
            ]);
    }


    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $this->authorize('createBlog', Auth::user());

        $this->log = [
            'action' => 'created',
            'model_type' => 'App\Models\Blogs',
        ];

        DB::beginTransaction();
        try {
            $blog = Blogs::query()->create($request->all());

            $tags = Tag::query()->get()->pluck('name', 'id')->toArray();

            if (!empty($request->blog_tags)) {
                // if tag table has at least one value
                if (!empty($tags)) {
                    foreach ($request->blog_tags as $inputTag) {
                        // if the input of tag can be found on the table
                        if (in_array($inputTag, $tags)) {
                            $tagID = array_search($inputTag, $tags);

                            BlogTag::query()->create([
                                'blog_id' => $blog->id,
                                'tag_id' => $tagID,
                            ]);
                        } else {
                            // if the input of tag cannot  be found on the table
                            $tagModel = Tag::query()->create([
                                'name' => trim($inputTag),
                                'slug' => SlugService::generateSlug($inputTag)
                            ]);

                            BlogTag::query()->create([
                                'blog_id' => $blog->id,
                                'tag_id' => $tagModel->id,
                            ]);
                        }
                    }
                } else {
                    // if tag table does not have any value
                    foreach ($request->blog_tags as $tag) {
                        $tagModel = Tag::query()->create([
                            'name' => trim($tag),
                            'slug' => SlugService::generateSlug($tag)
                        ]);

                        BlogTag::query()->create([
                            'blog_id' => $blog->id,
                            'tag_id' => $tagModel->id,
                        ]);
                    }
                }
            }


            BlogImage::query()->create([
                'blog_id' => $blog->id,
                'image' => $request->image,
                'type' => BlogImageType::COVER->value
            ]);

            AdminActivity::track($this->log, $blog);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Blog created successfully';

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }


        return to_route('admin.blogs.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function edit(Blogs $blog): View
    {
        $this->authorize('updateBlog', Auth::user());

        $blogCategories = BlogCategory::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        $statuses = Status::cases();

        $tags = Tag::query()
            ->get();

        $comments = $blog->load('blogComments');

        return view('backend.blogs.form')
            ->with([
                'blog' => $blog,
                'statuses' => $statuses,
                'blogCategories' => $blogCategories,
                'tags' => $tags,
            ]);
    }

    public function update(UpdateBlogRequest $request, Blogs $blog): RedirectResponse
    {
        $this->authorize('updateBlog', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Blogs',
            'old_data' => json_encode($blog->toArray()),
        ];

        $tags = Tag::query()->get()->pluck('name', 'id')->toArray();

        DB::beginTransaction();
        try {
            $blog->update($request->all());

            if (!empty($request->blog_tags)) {
                // if tag table has at least one value
                if (!empty($tags)) {
                    foreach ($request->blog_tags as $inputTag) {
                        // if the input of tag can be found on the table
                        if (in_array($inputTag, $tags)) {
                            $tagID = array_search($inputTag, $tags);

                            BlogTag::query()->create([
                                'blog_id' => $blog->id,
                                'tag_id' => $tagID,
                            ]);
                        } else {
                            // if the input of tag cannot  be found on the table
                            $tagModel = Tag::query()->create([
                                'name' => trim($inputTag),
                                'slug' => SlugService::generateSlug($inputTag)
                            ]);

                            BlogTag::query()->create([
                                'blog_id' => $blog->id,
                                'tag_id' => $tagModel->id,
                            ]);
                        }
                    }
                } else {
                    // if tag table does not have any value
                    foreach ($request->blog_tags as $tag) {
                        $tagModel = Tag::query()->create([
                            'name' => trim($tag),
                            'slug' => SlugService::generateSlug($tag)
                        ]);

                        BlogTag::query()->create([
                            'blog_id' => $blog->id,
                            'tag_id' => $tagModel->id,
                        ]);
                    }
                }
            }

            BlogImage::query()->create([
                'blog_id' => $blog->id,
                'image' => $request->image,
                'type' => BlogImageType::COVER->value
            ]);

            AdminActivity::track($this->log, $blog);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Blog created successfully';


            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }


        return to_route('admin.blogs.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function destroy(Blogs $blog): RedirectResponse
    {
        $this->authorize('deleteBlog', Auth::user());

        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Blogs',
            'old_data' => json_encode($blog->toArray()),
        ];

        DB::beginTransaction();
        try {
            $blog->delete();
            AdminActivity::track($this->log, $blog);
            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Blog deleted successfully';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }

        return to_route('admin.blogs.index')
            ->with($this->notification['status'], $this->notification['message']);
    }

    public function approved(Blogs $blog, BlogComment $comment): RedirectResponse
    {
        if ($comment->status != CommentStatus::PENDING->value) {
            return to_route('admin.blogs.edit', [$blog])
                ->with('error', 'The decision has already been made regarding this comment.');
        }

        $log = [
            'action' => 'approved',
            'model_type' => 'App\Models\BlogComment',
            'old_data' => json_encode($comment->toArray()),
        ];

        $adminID = Auth::guard('admin')->id();

        $comment->update([
            'approved_by' => $adminID,
            'status' => CommentStatus::APPROVED->value,
        ]);

        AdminActivity::track($log, $comment);

        return to_route('admin.blogs.edit', [$blog])
            ->with('success', 'Blog comment has been approved successfully.');
    }

    public function rejected(Blogs $blog, BlogComment $comment): RedirectResponse
    {
        if ($comment->status != CommentStatus::PENDING->value) {
            return to_route('admin.blogs.edit', [$blog])
                ->with('error', 'The decision has already been made regarding this comment.');
        }

        $log = [
            'action' => 'rejected',
            'model_type' => 'App\Models\BlogComment',
            'old_data' => json_encode($comment->toArray()),
        ];

        $adminID = Auth::guard('admin')->id();

        $comment->update([
            'approved_by' => $adminID,
            'status' => CommentStatus::REJECTED->value,
        ]);

        AdminActivity::track($log, $comment);

        return to_route('admin.blogs.edit', [$blog])
            ->with('success', 'Blog comment has been rejected successfully.');
    }

    public function reply(Request $request, Blogs $blog, BlogComment $comment): RedirectResponse
    {
        $request->validate([
            'reply_comment' => 'required|string|max:2000',
        ]);

        $log = [
            'action' => 'reply-a-comment',
            'model_type' => 'App\Models\BlogComment',
            'old_data' => json_encode($comment->toArray()),
        ];

        $adminID = Auth::guard('admin')->id();

        $comment->update([
            'replied_by' => $adminID,
            'reply_comment' => $request->reply_comment,
            'reply_at' => Carbon::now(),
        ]);

        return to_route('admin.blogs.edit', [$blog])
            ->with('success', 'Reply added successfully.');
    }

}
