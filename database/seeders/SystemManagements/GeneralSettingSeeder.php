<?php

namespace Database\Seeders\SystemManagements;

use App\Features\SystemManagements\Models\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'base_price',
                'value' => '100.00'
            ],
            [
                'key' => 'app_name',
                'value' => 'CompareThePro'
            ],
            [
                'key' => 'currency',
                'value' => 'USD'
            ],
            [
                'key' => 'tax_rate',
                'value' => '10.00'
            ],
            [
                'key' => 'service_fee',
                'value' => '5.00'
            ]
        ];

        foreach ($settings as $setting) {
            GeneralSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
