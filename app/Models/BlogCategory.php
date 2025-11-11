<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];


    public function blogs()
    {
        return $this->hasMany(Blogs::class, 'blog_category_id');
    }

    public function getValidBlogCountAttribute()
    {
        return $this->blogs()->where('status', Status::ACTIVE->value)->count();
    }
}
