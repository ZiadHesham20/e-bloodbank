<?php

namespace Database\Seeders;

use App\Models\UserDisease;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserDisease::factory()->count(50)->create();
    }
}
