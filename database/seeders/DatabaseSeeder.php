<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BloodSeeder::class);
        $this->call(HospitalSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(DiseaseSeeder::class);
        $this->call(MedicineSeeder::class);
        $this->call(UserDiseaseSeeder::class);
        $this->call(UserMedicineSeeder::class);
        $this->call(HospitalBloodSeeder::class);
        $this->call(HospitalUserSeeder::class);
    }
}
