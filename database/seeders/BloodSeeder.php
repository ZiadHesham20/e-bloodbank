<?php

namespace Database\Seeders;

use App\Models\Blood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type1 = Blood::create([
            'type' => 'A+',
        ]);
        $type2 = Blood::create([
            'type' => 'A-'
        ]);
        $type3 = Blood::create([
            'type' => 'B+',
        ]);
        $type4 = Blood::create([
            'type' => 'B-',
        ]);
        $type5 = Blood::create([
            'type' => 'AB+',
        ]);
        $type6 = Blood::create([
            'type' => 'AB-',
        ]);
        $type7 = Blood::create([
            'type' => 'O+',
        ]);
        $type8 = Blood::create([
            'type' => 'O-',
        ]);
        $type9 = Blood::create([
            'type' => 'plasma',
        ]);
        $type9 = Blood::create([
            'type' => 'Platelets',
        ]);

    }
}
