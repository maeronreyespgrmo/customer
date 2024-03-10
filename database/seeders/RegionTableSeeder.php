<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = array(
            array(
                "name" => "REGION I (ILOCOS REGION)",
                "code" => "01"
            ),
            array(
                "name" => "REGION II (CAGAYAN VALLEY)",
                "code" => "02"
            ),
            array(
                "name" => "REGION III (CENTRAL LUZON)",
                "code" => "03"
            ),
            array(
                "name" => "REGION IV-A (CALABARZON)",
                "code" => "04"
            ),
            array(
                "name" => "MIMAROPA",
                "code" => "017"
            ),
            array(
                "name" => "REGION V (BICOL REGION)",
                "code" => "05"
            ),
            array(
                "name" => "REGION VI (WESTERN VISAYAS)",
                "code" => "06"
            ),
            array(
                "name" => "REGION VII (CENTRAL VISAYAS)",
                "code" => "07"
            ),
            array(
                "name" => "REGION VIII (EASTERN VISAYAS)",
                "code" => "08"
            ),
            array(
                "name" => "REGION IX (ZAMBOANGA PENINSULA)",
                "code" => "09"
            ),
            array(
                "name" => "REGION X (NORTHERN MINDANAO)",
                "code" => "010"
            ),
            array(
                "name" => "REGION XI (DAVAO REGION)",
                "code" => "011"
            ),
            array(
                "name" => "REGION XII (SOCCSKSARGEN)",
                "code" => "012"
            ),
            array(
                "name" => "NATIONAL CAPITAL REGION (NCR)",
                "code" => "013"
            ),
            array(
                "name" => "CORDILLERA ADMINISTRATIVE REGION (CAR)",
                "code" => "014"
            ),
            array(
                "name" => "AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)",
                "code" => "015"
            ),
            array(
                "name" => "REGION XIII (Caraga)",
                "code" => "016"
            ),
            array(
                "name" => "NEGROS ISLAND REGION (NIR)",
                "code" => "018"
            )        
        );
        DB::table('tbl_regions')->insert($regions);
    }
}
