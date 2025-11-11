<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ResourceType;
use App\Enums\Statement;
use App\Http\Controllers\Controller;
use App\Models\MeritResource;
use App\Operations\Frontend\DeviceActivity;
use App\Operations\Frontend\DownloadHistoryActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Laravel\Cashier\Subscription;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SitemapController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return in_array('GET', $route->methods()) // only GET
                && !str_contains($route->uri(), 'api') // exclude API
                && !str_contains($route->uri(), 'admin') // exclude Admin
                && !in_array('auth', $route->middleware()); // exclude auth routes
        });

        $urls = $routes->map(function ($route) {
            return url($route->uri());
        });

        return response()->view('frontend.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }


}
