<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'admin';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'address',
        'image',
        'team_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->name));

        if (count($words) === 1) {
            return strtoupper(mb_substr($words[0], 0, 2));
        }

        return strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class); // Or a many-to-many with roles/permissions on pivot if you're assigning roles to users for specific teams
    }

    public function currentRole(): HasOne
    {
        return $this->hasOne(Role::class);
    }

    public function currentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
