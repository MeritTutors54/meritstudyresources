<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\text;

final class InvoiceService
{
    public static function createInvoiceNumber(): string
    {
        return DB::transaction(function () {
            $latest = Order::query()
                ->lockForUpdate()
                ->latest()->first();

            if (empty($latest)) {
                $text = 'Merit-' . str_pad(1001, 8, '0', STR_PAD_LEFT);
            } else {
                $number = 1000 + $latest->id + 1;
                $text = 'Merit-' . str_pad($number, 8, '0', STR_PAD_LEFT);
            }

            return $text;
        });
    }


}
