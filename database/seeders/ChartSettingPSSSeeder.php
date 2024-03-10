<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartSettingPSSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $query = array(
            array(
                'chart_name' => "pie",
            ),
        );
        DB::table('tbl_chart_settings_pss')->insert($query);
    }
}
