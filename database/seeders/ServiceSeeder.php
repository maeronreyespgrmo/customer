<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::truncate();
        $csvFile = fopen(base_path("database/data/tbl_services.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Service::create([
                    "office_id" => $data['0'],
                    "service_name" => $data['1']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
