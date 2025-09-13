<?php

namespace Database\Seeders\SystemManagements;

use App\Features\SystemManagements\Models\Policy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Policy::create([
                'title' => fake()->sentence(3),
                'description' => fake()->text(100),
            ]);
        }
    }
}
