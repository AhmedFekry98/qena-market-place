<?php

namespace Database\Seeders\SystemManagements;

use App\Features\SystemManagements\Models\TermCondition;
use Illuminate\Database\Seeder;

class TermConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 10; $i++) {
            TermCondition::create([
                'title' => fake()->sentence(3),
                'description' => fake()->text(100),
            ]);
        }
    }
}
