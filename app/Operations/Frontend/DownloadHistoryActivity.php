<?php

namespace App\Operations\Frontend;

use App\Models\DownloadHistory;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

final class DownloadHistoryActivity
{
    public static function track($array): void
    {
        DownloadHistory::query()->create($array);
    }
}
