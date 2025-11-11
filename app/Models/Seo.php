<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_title',
        'page_title',
        'meta_keywords',
        'meta_author',
        'meta_description',
        'google_verification',
        'bing_verification',
        'google_analytics',
        'alexa_analytics',
        'facebook_pixel'
    ];
}
