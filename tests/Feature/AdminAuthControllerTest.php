<?php

namespace Tests\Feature;

use App\Models\Admin;
use Database\Seeders\AdminSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthControllerTest extends TestCase
{
//    use RefreshDatabase;

    public function test_cannot_allow_unauthenticated_user_into_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_allow_authenticated_user_into_dashboard()
    {
        $this->seed(RoleSeeder::class);
        $this->seed(\Database\Seeders\TeamSeeder::class);
        $this->seed(AdminSeeder::class);
        $admin = Admin::query()->first();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk()->assertViewIs('backend.dashboard.index');
    }
}
