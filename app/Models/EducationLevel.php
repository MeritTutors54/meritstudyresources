<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationLevel extends BaseModel
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
    ];

    public function allSubjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }


}
