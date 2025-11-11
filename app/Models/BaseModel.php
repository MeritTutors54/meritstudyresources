<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public static function findActiveBySlug(?string $slug, ?array $relations = []): ?self
    {
        return static::query()
            ->with($relations)
            ->where('slug', $slug)
            ->where('status', \App\Enums\Status::ACTIVE->value)
            ->first();
    }
}
