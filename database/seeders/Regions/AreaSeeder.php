<?php

namespace Database\Seeders\Regions;

use App\Features\Regions\Models\Area;
use App\Features\Regions\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get cities for relationships
        $riyadh = City::where('code', 'RYD')->first();
        $jeddah = City::where('code', 'JED')->first();
        $dammam = City::where('code', 'DMM')->first();
        $mecca = City::where('code', 'MEC')->first();
        $medina = City::where('code', 'MED')->first();

        if (!$riyadh || !$jeddah || !$dammam) {
            return; // Skip if cities don't exist
        }

        $areas = [
            // Riyadh Areas
            [
                'city_id' => $riyadh->id,
                'name' => 'Al Olaya',
                'name_ar' => 'العليا',
                'code' => 'RYD-OLY',
                'is_active' => true
            ],
            [
                'city_id' => $riyadh->id,
                'name' => 'Al Malqa',
                'name_ar' => 'الملقا',
                'code' => 'RYD-MLQ',
                'is_active' => true
            ],
            [
                'city_id' => $riyadh->id,
                'name' => 'Al Nakheel',
                'name_ar' => 'النخيل',
                'code' => 'RYD-NKH',
                'is_active' => true
            ],
            [
                'city_id' => $riyadh->id,
                'name' => 'King Fahd District',
                'name_ar' => 'حي الملك فهد',
                'code' => 'RYD-KFD',
                'is_active' => true
            ],
            [
                'city_id' => $riyadh->id,
                'name' => 'Al Sahafa',
                'name_ar' => 'الصحافة',
                'code' => 'RYD-SHF',
                'is_active' => true
            ],

            // Jeddah Areas
            [
                'city_id' => $jeddah->id,
                'name' => 'Al Tahlia',
                'name_ar' => 'التحلية',
                'code' => 'JED-THL',
                'is_active' => true
            ],
            [
                'city_id' => $jeddah->id,
                'name' => 'Al Rawdah',
                'name_ar' => 'الروضة',
                'code' => 'JED-RWD',
                'is_active' => true
            ],
            [
                'city_id' => $jeddah->id,
                'name' => 'Al Salamah',
                'name_ar' => 'السلامة',
                'code' => 'JED-SLM',
                'is_active' => true
            ],
            [
                'city_id' => $jeddah->id,
                'name' => 'Al Corniche',
                'name_ar' => 'الكورنيش',
                'code' => 'JED-CRN',
                'is_active' => true
            ],
            [
                'city_id' => $jeddah->id,
                'name' => 'Al Balad',
                'name_ar' => 'البلد',
                'code' => 'JED-BLD',
                'is_active' => true
            ],

            // Dammam Areas
            [
                'city_id' => $dammam->id,
                'name' => 'Al Faisaliyah',
                'name_ar' => 'الفيصلية',
                'code' => 'DMM-FSL',
                'is_active' => true
            ],
            [
                'city_id' => $dammam->id,
                'name' => 'Al Shatea',
                'name_ar' => 'الشاطئ',
                'code' => 'DMM-SHT',
                'is_active' => true
            ],
            [
                'city_id' => $dammam->id,
                'name' => 'Al Adamah',
                'name_ar' => 'الأدامة',
                'code' => 'DMM-ADM',
                'is_active' => true
            ],
            [
                'city_id' => $dammam->id,
                'name' => 'Al Noor',
                'name_ar' => 'النور',
                'code' => 'DMM-NOR',
                'is_active' => true
            ],

            // Mecca Areas (if exists)
            ...$mecca ? [
                [
                    'city_id' => $mecca->id,
                    'name' => 'Al Haram 1',
                    'name_ar' => 'الحرم 1',
                    'code' => 'MEC-HRM',
                    'is_active' => true
                ],
                [
                    'city_id' => $mecca->id,
                    'name' => 'Al Aziziyah',
                    'name_ar' => 'العزيزية',
                    'code' => 'MEC-AZZ',
                    'is_active' => true
                ],
                [
                    'city_id' => $mecca->id,
                    'name' => 'Al Shisha',
                    'name_ar' => 'الشيشة',
                    'code' => 'MEC-SHS',
                    'is_active' => true
                ]
            ] : [],

            // Medina Areas (if exists)
            ...$medina ? [
                [
                    'city_id' => $medina->id,
                    'name' => 'Al Haram',
                    'name_ar' => 'الحرم',
                    'code' => 'MED-HRM',
                    'is_active' => true
                ],
                [
                    'city_id' => $medina->id,
                    'name' => 'Al Anbariyah',
                    'name_ar' => 'العنبرية',
                    'code' => 'MED-ANB',
                    'is_active' => true
                ],
                [
                    'city_id' => $medina->id,
                    'name' => 'Quba',
                    'name_ar' => 'قباء',
                    'code' => 'MED-QBA',
                    'is_active' => true
                ]
            ] : []
        ];

        foreach ($areas as $area) {
            Area::firstOrCreate(
                ['code' => $area['code']],
                $area
            );
        }
    }
}
