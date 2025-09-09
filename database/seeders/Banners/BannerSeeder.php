<?php

namespace Database\Seeders\Banners;

use App\Features\Banners\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       for($i = 0; $i < 10; $i++) {
           Banner::create([
               'title' => 'Banner ' . $i,
           ]);
       }
    }
}
