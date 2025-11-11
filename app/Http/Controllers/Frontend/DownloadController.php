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
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Laravel\Cashier\Subscription;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

//    public function downloadPDF(Request $request): JsonResponse | BinaryFileResponse
//    {
//        $resource = MeritResource::query()
//            ->where('slug', $request->_slug)
//            ->first();
//
//        $agent = new Agent();
//        $fingerprint = DeviceActivity::generateFingerprint($request, $agent);
//        $device = DeviceActivity::getDeviceInfo($request, $agent);
//
//        $user = Auth::user();
//
//        if (!$this->userHasAccess()) {
//            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to the file.');
//        }
//
//        if (!$user->subscribed('default') && $resource->is_paid === Statement::NO->value) {
//            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to the file.');
//        }
//
//        if (!Storage::disk('public')->exists($resource->main_pdf)) {
//            abort(Response::HTTP_NOT_FOUND, 'File not found.');
//        }
//
//        if ($user->remaining_downloads === 0) {
//            return response()->json(['message' => 'No downloads left'], 403);
//        }
//
//        DownloadHistoryActivity::track([
//            'request_id' => Str::uuid()->toString(),
//            'user_id' => $user->id,
//            'resource_id' => $resource->id,
//            'subscription_id' => $user->subscription()->first()->id,
//            'ip_address' => $device['ip'],
//            'fingerprint' => $fingerprint,
//            'type' => ResourceType::RESOURCE->value,
//        ]);
//
//        return response()->file(storage_path('app/public/' . $resource->main_pdf), [
//            'Content-Type' => 'application/pdf',
//            'Content-Disposition' => 'attachment; filename="' . $resource->name . '"',
//        ]);
//
////        return Storage::disk('public')->download($resource->main_pdf);
//    }

    public function downloadPDF(Request $request)
    {
        $resource =  MeritResource::query()
            ->where('slug', $request->_slug)
            ->first();


        $agent = new Agent();
        $fingerprint = DeviceActivity::generateFingerprint($request, $agent);
        $device = DeviceActivity::getDeviceInfo($request, $agent);

        $user = Auth::user();

        // 2. Check if file exists
        if (!Storage::disk('public')->exists($resource->main_pdf)) {
            return response()->json([
                'error' => 'File not found'
            ], 404);
        }

        if (!$this->userHasAccess()) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to the file.');
        }

        if (!$user->subscribed('default') && $resource->is_paid === Statement::NO->value) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized access to the file.');
        }

        if (!Storage::disk('public')->exists($resource->main_pdf)) {
            abort(Response::HTTP_NOT_FOUND, 'File not found.');
        }


        if ($user->remaining_downloads === 0) {
            return response()->json(['message' => 'No downloads left'], 403);
        }

        DownloadHistoryActivity::track([
            'request_id' => Str::uuid()->toString(),
            'user_id' => $user->id,
            'resource_id' => $resource->id,
            'subscription_id' => $user->hasActiveSubscription('all')->id,
            'ip_address' => $device['ip'],
            'fingerprint' => $fingerprint,
            'type' => ResourceType::RESOURCE->value,
            'status' => 1,
        ]);



        // 3. Return the file URL or download directly
        // Option A: Return URL for client-side download
        return response()->json([
            'fileUrl' => asset(Storage::url($resource->main_pdf)),
            'filename' => $resource->name
        ]);
    }

    private function userHasAccess(): bool
    {
        return Auth::check();
    }
}
