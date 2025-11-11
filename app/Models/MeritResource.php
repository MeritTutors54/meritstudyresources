<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeritResource extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'slug',
        'topic_id',
        'status',
        'is_paid',
        'description',
        'thumbnail_image',
        'main_pdf',
        'search_text'
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function allPage(): HasMany
    {
        return $this->hasMany(ResourceImage::class, 'resource_id', 'id');
    }

    public function getAllPageAsBase64()
    {
        return $this->allPage->map(function ($image) {

            $path = storage_path('app/public/' . $image->image_path); // Adjust this based on where your images are stored

            if (file_exists($path)) {
                $mime = mime_content_type($path);
                $base64 = base64_encode(file_get_contents($path));
                $image->base64 = "data:$mime;base64,$base64";
            }

            return $image;
        });
    }

    public function getRelatedResourcesAttribute(): Collection
    {
        $r = $this;

        return self::query()
            ->with([
                'topic.topicGroup',
                'topic.educationLevel',
                'topic.subject',
                'allPage'
            ])
            ->where('status', Status::ACTIVE->value)
            ->where('id', '!=', $this->id)
            ->whereHas('topic', function ($query) use ($r) {
                $query->where('slug', $r->topic?->slug)
                    ->whereHas('topicGroup', fn($q) => $q->where('slug', $r->topic?->topicGroup?->slug))
                    ->whereHas('educationLevel', fn($q) => $q->where('slug', $r->topic?->educationLevel?->slug))
                    ->whereHas('subject', fn($q) => $q->where('slug', $r->topic?->subject?->slug));
            })
            ->get();
    }
}
