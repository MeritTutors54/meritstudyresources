<?php

namespace App\Services;

use App\Models\PastPaper;
use Illuminate\Support\Facades\Crypt;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Spatie\PdfToImage\Pdf;

final class PDFService
{

    public static function pdfToImage($pdfPath, $outputPath): string|array
    {
        $path = [];

        $output = storage_path('app/public/' . $outputPath);

        if (!file_exists($output)) {
            mkdir($output, 0755, true);
        }

        $absolutePath = storage_path('app/public/' . $pdfPath);

        try {
            $time = time();
            $pdf = new Pdf($absolutePath);
            $pageCount = $pdf->pageCount();
            for ($page = 1; $page <= $pageCount; $page++) {
                $pdf->selectPage($page)
                    ->save("{$output}/pdf_{$time}_{$page}.jpg");

                $path[] = "{$outputPath}/pdf_{$time}_{$page}.jpg";
            }
        } catch (PdfDoesNotExist $e) {
            return $e->getMessage();
        }

       return $path;
    }

    public static  function makeSecret($id, $type): string
    {
        return Crypt::encryptString($id . '-' . $type);
    }

}
