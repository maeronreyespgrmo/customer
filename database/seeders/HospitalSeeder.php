<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $query = array(
            array(
                'hospital_name' => "BAY DISTRICT HOSPITAL",
                'hospital_address' => "Brgy Maitim Bay Laguna",
                'hospital_number' => "(049)536-0357",
            ),
            array(
                'hospital_name' => "DR. JP RIZAL MEMORIAL DISTRICT HOSPITAL",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
            array(
                'hospital_name' => "LAGUNA MEDICAL CENTER(LMC)",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
            array(
                'hospital_name' => "SAN PABLO CITY DISTRICT HOSPITAL",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
            array(
                'hospital_name' => "LUISIANA DISTRICT HOSPITAL",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
            array(
                'hospital_name' => "MAJAYJAY MEDICARE DISTRICT HOSPITAL",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
            array(
                'hospital_name' => "NAGCARLAN DISTRICT HOSPITAL",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
            array(
                'hospital_name' => "SAN PEDRO DISTRICT HOSPITAL",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
            array(
                'hospital_name' => "GEN. CAILLES MEMORIAL DISTRICT HOSPITAL",
                'hospital_address' => "Sta Cruz Laguna",
                'hospital_number' => "(049)536-786",
            ),
        );
        DB::table('tbl_hospitals')->insert($query);
    }
}
