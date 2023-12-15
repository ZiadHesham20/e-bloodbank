<?php

namespace Database\Seeders;

use App\Models\EmergencyDonate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmergencyDonateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmergencyDonate::factory()->count(20)->create();
    }
}
