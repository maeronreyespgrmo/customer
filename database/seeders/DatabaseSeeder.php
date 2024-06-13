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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            OfficeSeeder::class,
            HospitalSeeder::class,
            DoctorSeeder::class,
            ManagerSeeder::class,
            ChartSettingCSSSeeder::class,
            ChartSettingPSSSeeder::class,
            RegionTableSeeder::class,
            ProvinceTableSeeder::class,
            CitiesAndMunicipalitiesTableSeeder::class,
            BarangaysTableSeeder::class,
            ServicesCSMSeeder::class
        ]);
    }
}
