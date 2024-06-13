<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceCSM;

class ServicesCSMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ServiceCSM::truncate();
        $csvFile = fopen(base_path("database/data/tbl_services_csm.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                ServiceCSM::create([
                    "office_id" => $data['0'],
                    "service_name" => $data['1']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
