<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoardResourceFile extends Model
{
    protected $fillable = ['type', 'board_resource_id', 'title', 'difficulty', 'is_pro', 'file_path'];

}
