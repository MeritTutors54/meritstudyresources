<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PastPaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'ques_paper',
        'ans_paper',
        'pdf_solution',
        'video_solution',
        // add any other fields you want to mass assign
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(PastPaperYear::class, 'exam_series', 'id')
            ->select(['id', 'name']);
    }

    public function category_model(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function subcategory_model(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'subcategory')
            ->select(['id', 'subcategory_name', 'slug']);
    }

    public function resubcategory_model(): BelongsTo
    {
        return $this->belongsTo(Resubcategory::class, 'resubcategory')
            ->select(['id', 'resubcategory_name', 'unit_code', 'slug']);
    }

    public function converting_base($param): ?string
    {
        $path = public_path('uploads/pastpaper/') . $param;

        if (file_exists($path)) {
            $mime = mime_content_type($path);
            $base64 = base64_encode(file_get_contents($path));
            return "data:$mime;base64,$base64";
        }

        return null;
    }

}
