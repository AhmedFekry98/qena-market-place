<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Properties\PropertiesSeeder;
use Database\Seeders\Properties\PropertyTypesSeeder;
use Database\Seeders\Regions\AreaSeeder;
use Database\Seeders\Regions\CitySeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\SystemManagements\UserSeeder;
use Database\Seeders\SystemManagements\RoleSeeder;
use Database\Seeders\SystemManagements\PermissionSeeder;
use Database\Seeders\SystemManagements\RolePermissionSeeder;
use Database\Seeders\SystemManagements\UserRoleSeeder;
use Database\Seeders\SystemManagements\GeneralSettingSeeder;
use Database\Seeders\Banners\BannerSeeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Development seeders
     */
    private $developmentSeeders = [
        UserSeeder::class,
        RoleSeeder::class,
        PermissionSeeder::class,
        RolePermissionSeeder::class,
        UserRoleSeeder::class,
        PropertyTypesSeeder::class,
        CitySeeder::class,
        AreaSeeder::class,
        PropertiesSeeder::class,
        BannerSeeder::class,
        GeneralSettingSeeder::class,
    ];


    /**
     * Production seeders
     */
    private $productionSeeders = [
        UserSeeder::class,
        RoleSeeder::class,
        PermissionSeeder::class,
        RolePermissionSeeder::class,
        UserRoleSeeder::class,
        GeneralSettingSeeder::class,
        PropertyTypesSeeder::class,
        CitySeeder::class,
        AreaSeeder::class,
    ];




    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // make sure to run variable seeders based on environment
        if (! app()->environment('production')) {
            $this->call($this->developmentSeeders);
        }else{
            $this->call($this->productionSeeders);
        }

    }
}
