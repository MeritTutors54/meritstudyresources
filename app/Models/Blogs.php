<?php

namespace App\Models;

use App\Enums\BlogImageType;
use App\Enums\CommentStatus;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blogs extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'title',
        'slug',
        'details',
        'status',
        'author_id',
        'description',
        'blog_category_id',
        'is_feature',
    ];

    protected $with = ['author', 'images'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'blog_tags', 'blog_id', 'tag_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(BlogImage::class, 'blog_id', 'id');
    }

    public function getCoverImageAttribute(): string
    {
        return $this->images
            ->firstWhere('type', BlogImageType::COVER->value)
            ->image ?? '';
    }

    public function views(): HasMany
    {
        return $this->hasMany(BlogView::class, 'blog_id', 'id');
    }

    public function blogComments(): HasMany
    {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id');
    }

    public function getCommentsAttribute(): Collection
    {
        return $this->blogComments()->where('status', CommentStatus::APPROVED->value)->get();

    }

}
