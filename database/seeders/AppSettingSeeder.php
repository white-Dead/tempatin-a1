<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run(): void
    {
        AppSetting::query()->firstOrCreate(
            ['key' => 'subscription_price_monthly'],
            ['value' => '10000']
        );
    }
}
