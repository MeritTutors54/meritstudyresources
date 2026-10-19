<?php

namespace App\Services;

use App\Enums\ResourceType;
use App\Enums\SubscriptionLevel;
use App\Enums\UserType;
use App\Models\DownloadHistory;
use App\Models\LessonResource;
use App\Models\User;
use Laravel\Cashier\Subscription;

/**
 * Who may download what in the Teacher Library — every rule lives here.
 *
 *  - Free file (is_paid = 0)  → any logged-in user. Does not use a download.
 *  - Paid file                → needs an active subscription (the school's, for a teacher)
 *                               and at least one download left.
 *  - Pro file (is_pro = 1)    → also needs a Standard/Premium plan or a "full access" plan.
 *  - Downloading the same file again on the same subscription is not charged twice.
 */
final class TeacherLibraryAccess
{
    public const GUEST     = 'guest';      // not logged in
    public const SUBSCRIBE = 'subscribe';  // no active subscription
    public const UPGRADE   = 'upgrade';    // file needs a Pro plan
    public const LIMIT     = 'limit';      // no downloads left
    public const OK        = 'ok';         // may download

    /** Per-request cache, so a lesson with 6 files doesn't run 6x the same queries. */
    private array $cache = [];

    public function __construct(private ?User $user)
    {
    }

    public function user(): ?User
    {
        return $this->user;
    }

    /** One of the constants above. */
    public function stateFor(LessonResource $file): string
    {
        if (! $this->user) {
            return self::GUEST;
        }

        if (! $file->is_paid) {
            return self::OK;
        }

        if (! $this->subscription()) {
            return self::SUBSCRIBE;
        }

        if ($file->is_pro && ! $this->hasProPlan()) {
            return self::UPGRADE;
        }

        if ($this->alreadyDownloaded($file)) {
            return self::OK;   // re-download, no extra charge
        }

        return $this->remainingDownloads() > 0 ? self::OK : self::LIMIT;
    }

    /** True when this download should be written to download_histories (uses one download). */
    public function isCharged(LessonResource $file): bool
    {
        return $file->is_paid && ! $this->alreadyDownloaded($file);
    }

    /** Course documents (curriculum map, planning, assessments): any active subscription. */
    public function canOpenDocuments(): bool
    {
        return $this->user !== null && $this->subscription() !== null;
    }

    public function subscription(): ?Subscription
    {
        if (! $this->user) {
            return null;
        }

        if (! array_key_exists('subscription', $this->cache)) {
            // User::hasActiveSubscription('all') throws a TypeError when there is none,
            // so check with the plain (bool) call first.
            $this->cache['subscription'] = $this->user->hasActiveSubscription()
                ? $this->user->hasActiveSubscription('all')
                : null;
        }

        return $this->cache['subscription'];
    }

    public function hasProPlan(): bool
    {
        if (! $this->subscription()) {
            return false;
        }

        return $this->cache['pro'] ??= (function () {
            $plan = $this->user->activeSubscriptionPlan;

            return $plan && ($plan->has_full_access || (int) $plan->level >= SubscriptionLevel::Standard->value);
        })();
    }

    /** Same rule as User::remaining_downloads, but safe for a teacher whose school was removed. */
    public function remainingDownloads(): int
    {
        if (! $this->user) {
            return 0;
        }

        return $this->cache['remaining'] ??= (function () {
            if ($this->user->type === UserType::TEACHER->value && ! $this->user->school) {
                return 0;
            }

            return (int) $this->user->remaining_downloads;
        })();
    }

    public function alreadyDownloaded(LessonResource $file): bool
    {
        if (! $this->user || ! $this->subscription()) {
            return false;
        }

        $this->cache['downloaded'] ??= DownloadHistory::query()
            ->where('user_id', $this->user->id)
            ->where('subscription_id', $this->subscription()->id)
            ->where('type', ResourceType::LESSON->value)
            ->whereNotNull('lesson_resource_id')
            ->pluck('lesson_resource_id')
            ->flip()
            ->all();

        return isset($this->cache['downloaded'][$file->id]);
    }

    /** Message shown when a download is refused. */
    public function message(string $state): string
    {
        return match ($state) {
            self::GUEST     => 'Please log in to download this file.',
            self::SUBSCRIBE => $this->isTeacher()
                ? 'Your school does not have an active subscription. Please ask your school admin.'
                : 'This file is for subscribers. Choose a plan to download it.',
            self::UPGRADE   => 'This file is part of the Standard and Premium plans.',
            self::LIMIT     => 'You have used all the downloads in your plan.',
            default         => '',
        };
    }

    public function isTeacher(): bool
    {
        return $this->user?->type === UserType::TEACHER->value;
    }
}
