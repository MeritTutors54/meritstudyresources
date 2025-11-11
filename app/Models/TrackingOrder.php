<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'admin_id',
        'status',
        'remarks',
        'tracking_number',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
