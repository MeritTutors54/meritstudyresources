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

class BlogTagsController extends Controller
{
    protected array $log = [];
    protected array $notification = [];

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(): View
    {
        $tags = Tag::all();

        return view('backend.blogs.tags.index')
            ->with([
                'tags' => $tags,
            ]);
    }

    public function edit(Tag $blog_tag): View
    {
        return view('backend.blogs.tags.form')
            ->with([
                'blog_tag' => $blog_tag,
            ]);
    }

    public function update(Request $request, Tag $blog_tag): RedirectResponse
    {
        $this->log = [
            'action' => 'updated',
            'model_type' => 'App\Models\Tag',
            'old_data' => json_encode($blog_tag->toArray()),
        ];

        DB::beginTransaction();
        try {
            $request->merge([
                'slug' => SlugService::generateSlug($request->name),
            ]);

            $blog_tag->update($request->all());

            AdminActivity::track($this->log, $blog_tag);

            $this->notification['status'] = 'success';
            $this->notification['message'] = 'Blog tag updated successfully';

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->notification['status'] = 'error';
            $this->notification['message'] = $exception->getMessage();
        }


        return to_route('admin.blog-tags.index')
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
