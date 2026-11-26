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

    // public function index()
    // {
    //     $routes = collect(Route::getRoutes())->filter(function ($route) {
    //         return in_array('GET', $route->methods()) // only GET
    //             && !str_contains($route->uri(), 'api') // exclude API
    //             && !str_contains($route->uri(), 'admin') // exclude Admin
    //             && !in_array('auth', $route->middleware()); // exclude auth routes
    //     });

    //     $urls = $routes->map(function ($route) {
    //         return url($route->uri());
    //     });

    //     return response()->view('frontend.sitemap', ['urls' => $urls])
    //         ->header('Content-Type', 'application/xml');
    // }


        public function index()
    {
        $xml = Cache::remember('sitemap.xml', now()->addHours(6), function () {
            $urls = [];

            // 1. Static pages (shudhu je route ache shegula)
            foreach (['home', 'blogs', 'past-papers', 'subjects', 'shop', 'about', 'contact', 'faq',
                      'privacy-policy', 'terms', 'refund-policy'] as $name) {
                if (Route::has($name)) {
                    $urls[] = ['loc' => route($name), 'lastmod' => null];
                }
            }

            // 2. Blog posts (database theke)
            Blog::query()
                // ->where('status', 1)          // published filter thakle chalu korun
                ->select('slug', 'updated_at')
                ->orderByDesc('updated_at')
                ->each(function ($post) use (&$urls) {
                    $urls[] = [
                        'loc'     => route('blogs.details', $post->slug),
                        'lastmod' => $post->updated_at,
                    ];
                });

            // 3. Past paper pages (database theke)
            MeritResource::query()
                // ->where('status', 1)
                // ->where('type', \App\Enums\ResourceType::PAST_PAPER)   // shudhu past paper hole
                ->select('slug', 'updated_at')
                ->each(function ($r) use (&$urls) {
                    $urls[] = [
                        'loc'     => url('past-papers/' . $r->slug),   // ← apnar real past-paper URL pattern din
                        'lastmod' => $r->updated_at,
                    ];
                });

            // 4. XML banano
            $out  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            foreach ($urls as $u) {
                $out .= '  <url><loc>' . e($u['loc']) . '</loc>';
                if ($u['lastmod']) {
                    $out .= '<lastmod>' . $u['lastmod']->toAtomString() . '</lastmod>';
                }
                $out .= "</url>\n";
            }
            $out .= '</urlset>';

            return $out;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

}
