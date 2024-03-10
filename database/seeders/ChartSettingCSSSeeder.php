<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartSettingCSSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $query = array(
            array(
                'chart_name' => "bar",
            ),
        );
        DB::table('tbl_chart_settings_css')->insert($query);
    }
}
