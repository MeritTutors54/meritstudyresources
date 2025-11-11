<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends BaseModel
{
    use HasFactory, softDeletes;

    protected $fillable = ['name', 'slug', 'description', 'status', 'education_level_id'];

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function allLevel()
    {
        return $this->hasMany(EducationLevel::class, 'id','education_level_id');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
