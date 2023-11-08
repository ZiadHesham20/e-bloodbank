<?php

namespace Database\Seeders;

use App\Models\HospitalUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HospitalUser::factory()->count(50)->create();
    }
}
