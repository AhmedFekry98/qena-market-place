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
                'name' => 'Ahmed Fekry',
                'phone_code' => '20',
                'phone' => '1012182626',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ayman Mansoure',
                'phone_code' => '20',
                'phone' => '1023440284',
                'role' => 'agent',
                'password' => Hash::make('password'),
            ],
             [
                'name' => 'Abdullah Mohamed',
                'phone_code' => '20',
                'phone' => '1011645625',
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
