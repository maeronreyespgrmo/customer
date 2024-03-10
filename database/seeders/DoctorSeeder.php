<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $query = array(
            array(
                'hospital_id' => 1,
                'doctor_name' => "Dr. Petersan Y. Uy",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 2,
                'doctor_name' => "Dr. Ma. Eloisa D. Inaano",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 3,
                'doctor_name' => "Dr. Judy A. Rondilla",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 4,
                'doctor_name' => "Dr. Edgar M. Palacol",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 5,
                'doctor_name' => "Dr. Gretel Contegino",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 6,
                'doctor_name' => "Dr. Ma. Theresa V. Lapitan",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 7,
                'doctor_name' => "Dr. Herma V. Fomelosa",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 8,
                'doctor_name' => "Dr. Marigina S. Plural",
                'position' => "OIC-Chief of Hospital",
            ),
            array(
                'hospital_id' => 9,
                'doctor_name' => "Dr. Gilson R. Valendo",
                'position' => "OIC-Chief of Hospital",
            ),
        );
        DB::table('tbl_doctors')->insert($query);
    }
}
