<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Subscription;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $type
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Billable;

    protected $guard = 'web';
    protected $fillable = [
        'name',
        'parent_id',
        'team_id',
        'email',
        'password',
        'type',
        'last_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getCurrentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    public function getActiveSubscriptionPlanAttribute()
    {
        // check the user associated with the school or individual or school itself
        if (!empty($this->school)) {
            $user = $this->school;
        } else {
            $user = $this;
        }

        return SubscriptionPlan::query()
            ->select('subscription_plans.*')
            ->join('subscriptions', 'subscriptions.plan_id', '=', 'subscription_plans.id')
            ->where('subscriptions.user_id', $user->id)
            ->where('subscriptions.stripe_status', 'active') // example raw condition
            ->latest('subscriptions.created_at') // if multiple, get the latest
            ->limit(1)
            ->first(); // if you want one record, otherwise return the builder
    }

    public function downloadHistories(): HasMany
    {
        return $this->hasMany(DownloadHistory::class);
    }

    public function getDownloadLimitAttribute()
    {
        $limit = 0;
        if ($this->subscriptions->count() === 0) {
            $limit = 5;
        }

        return $this->activeSubscriptionPlan?->download_limit ?? $limit;
    }

    public function getRemainingDownloadsAttribute()
    {
        $used = 0;

        if ($this->type === UserType::SCHOOL->value) {
            $userIDs = $this->teachers->pluck('id')->toArray();
            $userIDs[] = $this->id;

            $used = DownloadHistory::query()
                ->whereIn('user_id', $userIDs)
                ->count();
        } else if ($this->type === UserType::TEACHER->value) {
            $userIDs = $this->school->teachers->pluck('id')->toArray();
            $userIDs[] = $this->parent_id;

            $used = DownloadHistory::query()
                ->whereIn('user_id', $userIDs)
                ->count();
        } else {
            $used = $this->downloadHistories()
                ->where('status', 1)
                ->count();
        }


        return max(0, $this->download_limit - $used);
    }


    public function getUserLimitAttribute()
    {
        return $this->activeSubscriptionPlan?->user_limit ?? 0;
    }

    public function getRemainingUsersAttribute()
    {
        $used = $this->teachers()
            ->count();

        return max(0, $this->user_limit - $used);
    }

    public function hasActiveSubscription($value = null): bool|Subscription
    {
        // check the user associated with the school or individual or school itself
        if (!empty($this->school)) {
            $user = $this->school;
        } else {
            $user = $this;
        }

        if ($value === 'all') {
            return Subscription::query()
                ->where('user_id', $user->id) // Assuming subscriptions are tied to school_id
                ->where('stripe_status', 'active') // Check for active subscription
                ->first();
        }

        return Subscription::query()
            ->where('user_id', $user->id) // Assuming subscriptions are tied to school_id
            ->where('stripe_status', 'active') // Check for active subscription
            ->exists();
    }

    public function getSchoolDownloadHistory(): ?Collection
    {
        if ($this->type === UserType::SCHOOL->value) {
            $userIDs = $this->teachers
                ->pluck('id')->toArray();
            $userIDs[] = $this->id;

            return DownloadHistory::query()
                ->with('user', 'resource', 'subscription')
                ->whereIn('user_id', $userIDs)
                ->get();
        }

        return null;
    }

    protected function getPersonTypeNameAttribute(): string
    {
        return ucfirst(strtolower(UserType::from($this->type ?? '')->name));
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function getLastLogin()
    {

    }

}
