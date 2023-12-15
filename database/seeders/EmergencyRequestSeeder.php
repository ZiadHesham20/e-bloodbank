<?php

namespace Database\Seeders;

use App\Models\EmergencyRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmergencyRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmergencyRequest::factory()->count(20)->create();
    }
}
