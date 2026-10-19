<?php

namespace App\Models;

use App\Enums\UserType;
use App\Services\StringService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DownloadHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_id',
        'resource_id',
        'lesson_resource_id',   // teacher library downloads (resource_id is NULL for these)
        'type',
        'subscription_id',
        'fingerprint',
        'ip_address',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resource(): HasOne
    {
        return $this->hasOne(MeritResource::class, 'id', 'resource_id');
    }

    /** Teacher library file (download_histories.lesson_resource_id) */
    public function lessonResource(): BelongsTo
    {
        return $this->belongsTo(LessonResource::class, 'lesson_resource_id');
    }

    /** Name for history tables: a merit resource or a teacher library lesson file */
    protected function getDisplayNameAttribute(): ?string
    {
        return $this->resource?->name ?? $this->lessonResource?->title;
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    protected function getResourceTypeNameAttribute(): string
    {
        return \App\Enums\ResourceType::from($this->type ?? '')->name;
    }

    protected function getShortFingerprintAttribute(): string
    {
        return StringService::shortenString($this->fingerprint ?? '');
    }

    protected function getStripeIDAttribute(): string
    {
        return StringService::shortenString($this->subscription?->stripe_id ?? '', 3,);
    }
}
