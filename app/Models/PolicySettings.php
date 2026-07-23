<?php

namespace App\Models;

use App\Enums\Policy;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicySettings extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'policy', 'status'];

    protected $casts = [
        'policy' => Policy::class,
        'status' => Status::class,
    ];
}
