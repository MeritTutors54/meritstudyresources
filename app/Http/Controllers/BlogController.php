<?php

namespace App\Http\Controllers;

use App\Enums\CommentStatus;
use App\Enums\SEOPage;
use App\Enums\Status;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Blogs;
use App\Models\BlogView;
use App\Models\Category;
use App\Models\Seo;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Spatie\Permission\PermissionRegistrar;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        if (Auth::check()) {
            $this->authorize('viewBlogsSection', Auth::user());
        }

        $p = $request->query('p');
        $q = $request->query('q');

        $blogs = Blogs::query()
            ->with('category');

        if (!empty($q)) {
            $blogs->whereHas('category', function ($query) use ($q) {
                $query->where('slug', $q);
            });
        }

        if (!empty($p)) {
            $blogs->whereHas('tags', function ($query) use ($p) {
                $query->where('slug', $p);
            });
        }

        $blogs = $blogs->where('status', Status::ACTIVE->value)
            ->paginate(10);

        $latestBlogs = Blogs::query()
            ->where('status', Status::ACTIVE->value)
            ->latest()
            ->take(5)
            ->get();

        $popularBlogs = Blogs::query()
            ->withCount('views')
            ->where('status', Status::ACTIVE->value)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $tags = Tag::query()
            ->get()
            ->take(2);

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::BLOGS->value)
            ->first();

        return view('frontend.blogs.index')
            ->with([
                'defaultSEO' => $defaultSEO,
                'blogs' => $blogs ?? '',
                'latestBlogs' => $latestBlogs,
                'tags' => $tags,
                'popularBlogs' => $popularBlogs,
            ]);
    }

    public function details(Request $request, $slug): View
    {
        if (Auth::check()) {
            $this->authorize('viewBlogsSection', Auth::user());
        }

        // for the latest blogs in the bottom
        $latestBlogs = Blogs::query()
            ->where('status', Status::ACTIVE->value)
            ->latest()
            ->take(5)
            ->get();

        // finding the blog using slug
        $blog = Blogs::query()
            ->where('slug', $slug)
            ->where('status', Status::ACTIVE->value)
            ->first();

        // all categories
        $categories = BlogCategory::query()
            ->where('status', Status::ACTIVE->value)
            ->get();

        // Get client information
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $userID = auth()->id();

        $recentView = BlogView::query()->where('blog_id', $blog->id)
            ->where('ip_address', $ipAddress)
            ->where('created_at', '>', now()->subDay())
            ->exists();

        // count unique views to each blog
        if (!$recentView) {
            BlogView::query()->create([
                'blog_id' => $blog->id,
                'user_id' => $userID,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);
        }

        $defaultSEO = Seo::query()
            ->where('page_title', SEOPage::BLOGS->value)
            ->first();

        $builtIn = $blog->title . ', ' . $blog->category->title;

        $seo ['meta_keywords'] = !empty($defaultSEO) ? $defaultSEO->meta_keywords . ',' . $builtIn : $builtIn;
        $seo ['meta_author'] = $defaultSEO->meta_author ?? '';
        $seo ['meta_description'] = !empty($defaultSEO) ? $defaultSEO->meta_description . ',' . $builtIn : $builtIn;

        return view('frontend.blogs.details')
            ->with([
                'blog' => $blog,
                'latestBlogs' => $latestBlogs,
                'categories' => $categories,
//                'tags' => $tags,
            'seo' => $seo,
            ]);
    }

    public function comment(Request $request, Blogs $blog): RedirectResponse
    {
        $request->validate([
            'user_name' => 'nullable|string|max:255',
            'user_email' => 'nullable|string|email|max:255',
            'comment' => 'required|string|max:3000',
        ]);

        $userID = auth()->id();

        BlogComment::query()->create([
            'blog_id' => $blog->id,
            'user_id' => $userID,
            'user_email' => $request->user_email ?? null,
            'comment' => $request->comment ?? null,
            'user_name' => $request->user_name ?? null,
            'status' => CommentStatus::PENDING->value,
        ]);

        return to_route('blogs.details', [$blog->slug])
            ->with('success', 'Comment added successfully. Please wait for approval.');
    }
}
