<?php

namespace App\Operations\Backend;

use App\Enums\Status;
use App\Models\ResourceImage;

final class PDFActivity
{
    public static function insertPDFImagesIntoDB($resourceID, $pdfImages, $topicID): void
    {
        if (is_array($pdfImages) && count($pdfImages) > 0) {
            foreach ($pdfImages as $pdf_image) {
                ResourceImage::query()->create([
                    'resource_id' => $resourceID,
                    'topic_id' => $topicID,
                    'image_path' => $pdf_image,
                    'status' => Status::ACTIVE->value
                ]);
            }
        }
    }
}
