<?php

namespace Database\Seeders\SystemManagements;

use App\Features\SystemManagements\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = app()->environment('production')
        ? [
            ['name' => 'admin' , 'caption' => 'Admin'],
        ]
        : [
            ['name' => 'admin' , 'caption' => 'Admin'],
            ['name' => 'agent' , 'caption' => 'Agent'],
            ['name' => 'customer' , 'caption' => 'Customer'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
