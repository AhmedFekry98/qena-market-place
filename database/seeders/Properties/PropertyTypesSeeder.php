<?php

namespace Database\Seeders\Properties;

use App\Features\Properties\Models\PropertyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyTypes = [
            [
                'name' => 'شقة',
                'description' => 'شقة سكنية - وحدة سكنية في مبنى متعدد الطوابق',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'أرض',
                'description' => 'أرض - قطعة أرض للبيع أو الاستثمار',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'مخزن',
                'description' => 'مخزن - مساحة تخزين تجارية أو صناعية',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'سكن طلاب',
                'description' => 'سكن طلاب - وحدة سكنية مخصصة للطلاب',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'فيلا',
                'description' => 'فيلا - منزل منفصل مع حديقة',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'مكتب',
                'description' => 'مكتب - مساحة عمل تجارية أو إدارية',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'محل تجاري',
                'description' => 'محل تجاري - مساحة تجارية للبيع بالتجزئة',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'مزرعة',
                'description' => 'مزرعة - أرض زراعية مع مرافق',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'شالية',
                'description' => 'شاليه - منزل صيفي أو للعطلات',
                'is_active' => fake()->boolean(),
            ],
            [
                'name' => 'مبني',
                'description' => 'مبنى - مبنى كامل للبيع أو الاستثمار',
                'is_active' => fake()->boolean(),
            ]
        ];

        foreach ($propertyTypes as $type) {
            PropertyType::firstOrCreate(
                ['name' => $type['name']],
                ['description' => $type['description']]
            );
        }
    }
}
