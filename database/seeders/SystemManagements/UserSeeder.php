<?php

namespace Database\Seeders\SystemManagements;

use App\Features\SystemManagements\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = app()->environment('production')
        ? [
            [
                'name' => 'Admin User',
                'phone_code' => '20',
                'phone' => '123456789',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ],
        ]
        : [
            [
                'name' => 'Admin User',
                'phone_code' => '20',
                'phone' => '123456789',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Agent User',
                'phone_code' => '20',
                'phone' => '123456788',
                'role' => 'agent',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Customer User',
                'phone_code' => '20',
                'phone' => '123456787',
                'role' => 'customer',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
