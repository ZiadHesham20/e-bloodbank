<?php

namespace Database\Seeders;

use App\Models\HospitalBlood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalBloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HospitalBlood::factory()->count(500)->create();
    }
}
