<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
       foreach ($this->basicRoles() as $guard => $scope) {
           if (!empty($scope)) {
               foreach ($scope as $role) {
                   if (!$this->checkRoles($role, $guard)) {
                       Role::create([
                           'name' => $role,
                           'guard_name' => $guard
                       ]);
                   }
               }
           }
       }
    }

    public function basicRoles(): array
    {
        return [
            'web' => [
                'admin',
                'teacher',
            ],
            'admin' => [
                'super-admin',
                'admin',
                'editor'
            ]
        ];
    }

    public function checkRoles($name, $guard): bool
    {
        return Role::query()->where('name', $name)->where('guard_name', $guard)->exists();
    }
}
