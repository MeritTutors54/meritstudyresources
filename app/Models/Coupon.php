<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'base_currency',
        'usages_limit',
        'valid_from',
        'valid_to',
        'status'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];
}
