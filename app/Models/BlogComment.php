<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'user_id',
        'comment',
        'approved_by',
        'reply_comment',
        'replied_by',
        'user_name',
        'user_email',
        'status',
        'reply_at'
    ];

    protected $casts = [
        'reply_at' => 'datetime',
    ];

    public function replied(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'replied_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
