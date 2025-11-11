<?php

namespace Database\Seeders;

use App\Enums\SubscriptionDuration;
use App\Enums\SubscriptionType;
use App\Models\SubscriptionPlan;
use App\Services\SlugService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (SubscriptionPlan::query()->count() > 0) {
            return;
        }

        foreach ($this->schoolPacks() as $planName => $durations) {
            foreach ($durations as $type => $info) {
                SubscriptionPlan::query()->create([
                    'name' => $planName,
                    'slug' => $info['slug'],
                    'duration' => SubscriptionDuration::fromString($type)->value,
                    'type' => SubscriptionType::SCHOOL->value,
                    'stripe_price_id' => $info['price_id'], // assuming you renamed `price` to `price_id`
                    'price' => $info['price'],
                    'level' => $info['level'],
                ]);
            }
        }

        foreach ($this->studentPacks() as $planName => $durations) {
            foreach ($durations as $type => $info) {
                SubscriptionPlan::query()->create([
                    'name' => $planName,
                    'slug' => $info['slug'],
                    'duration' => SubscriptionDuration::fromString($type)->value,
                    'type' => SubscriptionType::STUDENT->value,
                    'stripe_price_id' => $info['price_id'], // assuming you renamed `price` to `price_id`
                    'price' => $info['price'],
                    'level' => $info['level'],
                ]);
            }
        }
    }

    public function studentPacks(): array
    {
        return [
            'basic' => [
                'yearly' => [
                    'price_id' => 'price_1RgocmFWmSjA6IuQQQ1ypsjh',
                    'price' => 100.00,
                    'slug' => 'student-basic-yearly',
                    'level' => 0,
                ],
                'monthly' => [
                    'price_id' => 'price_1RgocmFWmSjA6IuQWzi0tAz8',
                    'slug' => 'student-basic-monthly',
                    'price' => 10.00,
                    'level' => 0,
                ],
            ],
            'pro' => [
                'yearly' => [
                    'price_id' => 'price_1RgocmFWmSjA6IuQ2wo5iNmf',
                    'price' => 690.00,
                    'slug' => 'student-pro-yearly',
                    'level' => 1,
                ],
                'monthly' => [
                    'price_id' => 'price_1RgocmFWmSjA6IuQAZ0RJXPC',
                    'price' => 60.00,
                    'slug' => 'student-pro-monthly',
                    'level' => 1,
                ],
            ],
            'ultra' => [
                'yearly' => [
                    'price_id' => 'price_1RgocmFWmSjA6IuQTMU6AjzX',
                    'price' => 1730.00,
                    'slug' => 'student-ultra-yearly',
                    'level' => 2,
                ],
                'monthly' => [
                    'price_id' => 'price_1RgocmFWmSjA6IuQcTH3JgQ4',
                    'price' => 150.00,
                    'slug' => 'student-ultra-monthly',
                    'level' => 2,
                ],
            ]
        ];
    }
    public function schoolPacks(): array
    {
        return [
            'basic' => [
                'yearly' => [
                    'price_id' => 'price_1RgohfFWmSjA6IuQM6ELJZQr',
                    'price' => 13000.00,
                    'slug' => 'school-basic-yearly',
                    'level' => 0,
                ],
                'monthly' => [
                    'price_id' => 'price_1RgokpFWmSjA6IuQh5ROB25k',
                    'price' => 1200.00,
                    'slug' => 'school-basic-monthly',
                    'level' => 0,
                ],
            ],
            'pro' => [
                'yearly' => [
                    'price_id' => 'price_1RgoiZFWmSjA6IuQvHC3BFhR',
                    'price' => 35000.00,
                    'slug' => 'school-pro-yearly',
                    'level' => 1,
                ],
                'monthly' => [
                    'price_id' => 'price_1RgolgFWmSjA6IuQsbd4UiqV',
                    'price' => 2965.00,
                    'slug' => 'school-pro-monthly',
                    'level' => 1,
                ],
            ],
            'ultra' => [
                'yearly' => [
                    'price_id' => 'price_1Rgoj9FWmSjA6IuQ5Nxz6Z3Q',
                    'price' => 58500.00,
                    'slug' => 'school-ultra-yearly',
                    'level' => 2,
                ],
                'monthly' => [
                    'price_id' => 'price_1RgomOFWmSjA6IuQedzI40wQ',
                    'price' => 5000.00,
                    'slug' => 'school-ultra-monthly',
                    'level' => 2,
                ],
            ]
        ];
    }
}
