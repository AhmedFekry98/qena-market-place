<?php

namespace Database\Seeders\SystemManagements;

use App\Features\SystemManagements\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::create([
            'user_id' => 1, // Admin User -> Admin
            'role_id' => 1,
        ]);

        if (! app()->environment('production')) {
            UserRole::create([
                'user_id' => 2, // Manager User -> Agent
                'role_id' => 2,
            ]);
            UserRole::create([
                'user_id' => 3, // Normal User -> Customer
                'role_id' => 3,
            ]);
        }


    }
}
