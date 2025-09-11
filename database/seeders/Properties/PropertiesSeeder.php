<?php

namespace Database\Seeders\Properties;

use App\Features\Properties\Models\Property;
use App\Features\Properties\Models\PropertyType;
use App\Features\Regions\Models\City;
use App\Features\Regions\Models\Area;
use App\Features\SystemManagements\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get property types and users for relationships
        $apartmentType = PropertyType::where('name', 'Apartment')->first();
        $villaType = PropertyType::where('name', 'Villa')->first();
        $landType = PropertyType::where('name', 'Land')->first();
        $officeType = PropertyType::where('name', 'Office')->first();
        $shopType = PropertyType::where('name', 'Shop')->first();
        $studentHousingType = PropertyType::where('name', 'StudentHousing')->first();
        $warehouseType = PropertyType::where('name', 'Warehouse')->first();
        $chaletType = PropertyType::where('name', 'Chalet')->first();

        // Get admin user for property creation
        $admin = User::where('role', 'admin')->first();

        // Get agent user for property management
        $agent = User::where('role', 'agent')->first();

        // Get cities and areas for relationships
        $riyadh = City::where('name', 'Riyadh')->first();
        $jeddah = City::where('name', 'Jeddah')->first();
        $dammam = City::where('name', 'Dammam')->first();
        $mecca = City::where('name', 'Mecca')->first();

        $olaya = Area::where('name', 'Olaya')->first();
        $malaz = Area::where('name', 'Malaz')->first();
        $alsalam = Area::where('name', 'Al Salam')->first();
        $corniche = Area::where('name', 'Corniche')->first();

        // Check if required data exists before creating properties
        if (!$admin || !$agent || !$apartmentType || !$riyadh) {
            $this->command->warn('Skipping PropertiesSeeder: Required data not found (admin, agent, apartment type, or Riyadh city)');
            return;
        }

        $properties = [
            [
                'property_type_id' => $apartmentType->id,
                'agent_id' => $agent->id,
                'title' => 'شقة 120م بجوار الجامعة',
                'description' => 'شقة مفروشة بالكامل، 3 غرف نوم، 2 حمام، صالة واسعة، مطبخ مجهز، بلكونة، موقف سيارة',
                'address' => 'شارع الجامعة، حي النور',
                'city_id' => $riyadh->id,
                'area_id' => $olaya?->id ?? $riyadh->areas()->first()?->id,
                'price' => 2500.00,
                'status' => 'available',
                'is_active' => fake()->boolean(),
                'created_by' => $admin->id,

                'features' => [
                    ['key' => 'غرف النوم', 'value' => '3'],
                    ['key' => 'الحمامات', 'value' => '2'],
                    ['key' => 'تكييف', 'value' => 'نعم'],
                    ['key' => 'مفروشة', 'value' => 'نعم'],
                    ['key' => 'موقف سيارة', 'value' => 'نعم']
                ]
            ],
            [
                'property_type_id' => $villaType->id,
                'agent_id' => $agent->id,
                'title' => 'فيلا فاخرة مع حديقة 400م',
                'description' => 'فيلا دورين، 5 غرف نوم، 4 حمامات، مجلس، صالة، حديقة واسعة، مسبح، مطبخ كبير',
                'address' => 'حي الملقا، شارع الأمير سلطان',
                'city_id' => $riyadh->id,
                'area_id' => $malaz?->id ?? $riyadh->areas()->first()?->id,
                'price' => 8500.00,
                'status' => 'available',
                'is_active' => fake()->boolean(),
                'created_by' => $admin->id,
                'features' => [
                    ['key' => 'غرف النوم', 'value' => '5'],
                    ['key' => 'الحمامات', 'value' => '4'],
                    ['key' => 'مسبح', 'value' => 'نعم'],
                    ['key' => 'حديقة', 'value' => 'نعم'],
                    ['key' => 'دورين', 'value' => 'نعم']
                ]
            ],
            [
                'property_type_id' => $landType->id,
                'agent_id' => $agent->id,
                'title' => 'أرض تجارية على شارع رئيسي',
                'description' => 'أرض تجارية في موقع استراتيجي، مناسبة للاستثمار التجاري أو السكني',
                'address' => 'طريق الملك فهد، تقاطع العليا',
                'city_id' => $riyadh->id,
                'area_id' => $malaz?->id ?? $riyadh->areas()->first()?->id,
                'price' => 1500000.00,
                'status' => 'available',
                'is_active' => fake()->boolean(),
                'created_by' => $admin->id,
                'features' => [
                    ['key' => 'نوع الأرض', 'value' => 'تجارية'],
                    ['key' => 'على شارع رئيسي', 'value' => 'نعم'],
                    ['key' => 'مخطط معتمد', 'value' => 'نعم']
                ]
            ],
            [
                'property_type_id' => $officeType->id,
                'agent_id' => $agent->id,
                'title' => 'مكتب إداري في برج تجاري',
                'description' => 'مكتب مجهز بالكامل، إطلالة رائعة، مصاعد، أمن 24 ساعة، موقف سيارات',
                'address' => 'برج الفيصلية، حي العليا',
                'city_id' => $riyadh->id,
                'area_id' => $malaz?->id ?? $riyadh->areas()->first()?->id,
                'price' => 4500.00,
                'is_active' => fake()->boolean(),
                'status' => 'available',
                'created_by' => $admin->id,
                'features' => [
                    ['key' => 'مجهز', 'value' => 'نعم'],
                    ['key' => 'أمن', 'value' => '24 ساعة'],
                    ['key' => 'مصاعد', 'value' => 'نعم'],
                    ['key' => 'إطلالة', 'value' => 'رائعة']
                ]
            ],
            [
                'property_type_id' => $shopType->id,
                'agent_id' => $agent->id,
                'title' => 'محل تجاري في مول شعبي',
                'description' => 'محل تجاري بموقع ممتاز، مناسب لجميع الأنشطة التجارية، حركة عالية',
                'address' => 'شارع التحلية، وسط البلد',
                'city_id' => $jeddah->id,
                'area_id' => $corniche?->id ?? $jeddah->areas()->first()?->id,
                'price' => 3200.00,
                'is_active' => fake()->boolean(),
                'status' => 'available',
                'created_by' => $admin->id,
                'features' => [
                    ['key' => 'موقع', 'value' => 'ممتاز'],
                    ['key' => 'حركة المرور', 'value' => 'عالية'],
                    ['key' => 'مناسب لـ', 'value' => 'جميع الأنشطة']
                ]
            ],
            [
                'property_type_id' => $studentHousingType->id,
                'agent_id' => $agent->id,
                'title' => 'سكن طلاب قريب من الجامعة',
                'description' => 'غرف مفردة ومزدوجة، مطبخ مشترك، إنترنت، أمن، قريب من الجامعة',
                'address' => 'حي الجامعة، بجوار جامعة الملك سعود',
                'city_id' => $riyadh->id,
                'area_id' => $malaz?->id ?? $riyadh->areas()->first()?->id,
                'price' => 800.00,
                'is_active' => fake()->boolean(),
                'status' => 'available',
                'created_by' => $admin->id,
                'features' => [
                    ['key' => 'نوع الغرفة', 'value' => 'مفردة'],
                    ['key' => 'إنترنت', 'value' => 'نعم'],
                    ['key' => 'أمن', 'value' => 'نعم'],
                    ['key' => 'مطبخ مشترك', 'value' => 'نعم']
                ]
            ],
            [
                'property_type_id' => $warehouseType->id,
                'agent_id' => $agent->id,
                'title' => 'مخزن صناعي بمساحة كبيرة',
                'description' => 'مخزن في المنطقة الصناعية، مناسب للتخزين والتوزيع، سهولة الوصول',
                'address' => 'المنطقة الصناعية الثانية',
                'city_id' => $dammam->id,
                'area_id' => $alsalam?->id ?? $dammam->areas()->first()?->id,
                'price' => 5500.00,
                'is_active' => fake()->boolean(),
                'status' => 'available',
                'created_by' => $admin->id,
                'features' => [
                    ['key' => 'ارتفاع السقف', 'value' => '8 متر'],
                    ['key' => 'رافعة شوكية', 'value' => 'متاحة'],
                    ['key' => 'سهولة الوصول', 'value' => 'نعم'],
                    ['key' => 'أمن', 'value' => 'نعم']
                ]
            ],
            [
                'property_type_id' => $chaletType->id,
                'agent_id' => $agent->id,
                'title' => 'شاليه على البحر مع مسبح',
                'description' => 'شاليه مطل على البحر، مسبح خاص، حديقة، مناسب للعائلات والعطلات',
                'address' => 'كورنيش جدة، حي الشاطئ',
                'city_id' => $jeddah->id,
                'area_id' => $corniche?->id ?? $jeddah->areas()->first()?->id,
                'price' => 1200.00,
                'is_active' => fake()->boolean(),
                'status' => 'available',
                'created_by' => $admin->id,
                'features' => [
                    ['key' => 'إطلالة', 'value' => 'بحرية'],
                    ['key' => 'مسبح خاص', 'value' => 'نعم'],
                    ['key' => 'حديقة', 'value' => 'نعم'],
                    ['key' => 'مناسب للعائلات', 'value' => 'نعم']
                ]
            ]
        ];

        foreach ($properties as $propertyData) {
            $features = $propertyData['features'];
            unset($propertyData['features']);

            $property = Property::create($propertyData);

            // Add features
            foreach ($features as $feature) {
                $property->features()->create($feature);
            }
        }
    }
}
