<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::query()->updateOrCreate([
            'name' => 'Team-Admin',
        ]);

        Team::query()->updateOrCreate([
            'name' => 'General-Team',
        ], [
            'guard_name' => 'web',
        ]);
    }
}
