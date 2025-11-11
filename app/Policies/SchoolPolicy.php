<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class SchoolPolicy
{
    protected function checkPermission(User $user, string $permission): bool
    {
        // Admin of "web" guard can do everything
        if ($user->hasRole('admin', 'web')) {
            return true;
        }

        return $user->hasPermissionTo($permission, 'web');
    }
    public function viewBlogsSection(?User $user): bool
    {
        return $this->checkPermission($user, 'view blogs section');
    }

    public function viewProductsSection(User $user): bool
    {
        return $this->checkPermission($user, 'view products section');
    }

    public function viewResourcesSection(User $user): bool
    {
        return $this->checkPermission($user,'view resources section');
    }

    public function viewPastPaperSection(User $user): bool
    {
        return $this->checkPermission($user, 'view past paper section');
    }

}
