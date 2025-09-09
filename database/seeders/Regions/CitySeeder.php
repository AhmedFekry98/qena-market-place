<?php

namespace Database\Seeders\Regions;

use App\Features\Regions\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Riyadh',
                'name_ar' => 'الرياض',
                'code' => 'RYD',
                'is_active' => true
            ],
            [
                'name' => 'Jeddah',
                'name_ar' => 'جدة',
                'code' => 'JED',
                'is_active' => true
            ],
            [
                'name' => 'Dammam',
                'name_ar' => 'الدمام',
                'code' => 'DMM',
                'is_active' => true
            ],
            [
                'name' => 'Mecca',
                'name_ar' => 'مكة المكرمة',
                'code' => 'MEC',
                'is_active' => true
            ],
            [
                'name' => 'Medina',
                'name_ar' => 'المدينة المنورة',
                'code' => 'MED',
                'is_active' => true
            ],
            [
                'name' => 'Khobar',
                'name_ar' => 'الخبر',
                'code' => 'KHB',
                'is_active' => true
            ],
            [
                'name' => 'Taif',
                'name_ar' => 'الطائف',
                'code' => 'TAF',
                'is_active' => true
            ],
            [
                'name' => 'Abha',
                'name_ar' => 'أبها',
                'code' => 'ABH',
                'is_active' => true
            ],
            [
                'name' => 'Tabuk',
                'name_ar' => 'تبوك',
                'code' => 'TBK',
                'is_active' => true
            ],
            [
                'name' => 'Qassim',
                'name_ar' => 'القصيم',
                'code' => 'QAS',
                'is_active' => true
            ]
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(
                ['code' => $city['code']],
                $city
            );
        }
    }
}
