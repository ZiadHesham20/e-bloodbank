<?php

namespace Database\Seeders;

use App\Models\UserDiesese;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserDiesese::factory()->count(50)->create();
    }
}
