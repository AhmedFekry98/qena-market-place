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
                'name' => 'Apartment',
                'description' => 'شقة سكنية - وحدة سكنية في مبنى متعدد الطوابق'
            ],
            [
                'name' => 'Land',
                'description' => 'أرض - قطعة أرض للبيع أو الاستثمار'
            ],
            [
                'name' => 'Warehouse',
                'description' => 'مخزن - مساحة تخزين تجارية أو صناعية'
            ],
            [
                'name' => 'StudentHousing',
                'description' => 'سكن طلاب - وحدة سكنية مخصصة للطلاب'
            ],
            [
                'name' => 'Villa',
                'description' => 'فيلا - منزل منفصل مع حديقة'
            ],
            [
                'name' => 'Office',
                'description' => 'مكتب - مساحة عمل تجارية أو إدارية'
            ],
            [
                'name' => 'Shop',
                'description' => 'محل تجاري - مساحة تجارية للبيع بالتجزئة'
            ],
            [
                'name' => 'Farm',
                'description' => 'مزرعة - أرض زراعية مع مرافق'
            ],
            [
                'name' => 'Chalet',
                'description' => 'شاليه - منزل صيفي أو للعطلات'
            ],
            [
                'name' => 'Building',
                'description' => 'مبنى - مبنى كامل للبيع أو الاستثمار'
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
