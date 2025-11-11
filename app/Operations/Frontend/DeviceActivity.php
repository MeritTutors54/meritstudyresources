<?php

namespace App\Operations\Frontend;

use App\Models\UserDevice;
use Jenssegers\Agent\Agent;

final class DeviceActivity
{
    public static function detectDevice($user, $request): array
    {
        $agent = new Agent();

        $fingerprint = self::generateFingerprint($request, $agent);
        $deviceInfo = self::getDeviceInfo($request, $agent);
        $userDevice = self::getUserDevice($user->id);

        if (!$userDevice) {
            self::storeDevice($user->id, $deviceInfo, $fingerprint);
        } elseif (self::isDeviceDifferent($userDevice, $deviceInfo['ip'], $fingerprint)) {
            return [
                'type' => 'error',
                'message' => 'Unrecognized device. Please login from a known device or contact support',
            ];
        }

        return ['type' => 'success', 'message' => 'Device recognized'];
    }

    public static function generateFingerprint($request, $agent): string
    {
        return sha1(
            $request->ip() .
            $agent->browser() .
            $agent->platform() .
            $request->header('User-Agent') .
            $request->header('Accept-Language')
        );
    }

    public static function getDeviceInfo($request, $agent): array
    {
        return [
            'device_name' => $agent->device(),
            'platform' => $agent->platform() . ' ' . $agent->version($agent->platform()),
            'browser' => $agent->browser() . ' ' . $agent->version($agent->browser()),
            'ip' => $request->ip(),
        ];
    }

    private static function getUserDevice($userId)
    {
        return UserDevice::query()->where('user_id', $userId)->first();
    }

    private static function storeDevice($userId, $deviceInfo, $fingerprint): void
    {
        UserDevice::query()->create([
            'user_id' => $userId,
            'device_name' => $deviceInfo['device_name'],
            'platform' => $deviceInfo['platform'],
            'browser' => $deviceInfo['browser'],
            'ip_address' => $deviceInfo['ip'],
            'fingerprint' => $fingerprint,
        ]);
    }

    private static function isDeviceDifferent($storedDevice, $currentIp, $currentFingerprint): bool
    {
        return $storedDevice->ip_address !== $currentIp;
    }


}
