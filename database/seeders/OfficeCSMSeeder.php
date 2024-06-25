<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OfficeCSM;


class OfficeCSMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          //
          OfficeCSM::truncate();
          $csvFile = fopen(base_path("database/data/tbl_offices_csm.csv"), "r");
  
          $firstline = true;
          while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
              if (!$firstline) {
                  OfficeCSM::create([
                      "office_name" => $data['0']
                  ]);
              }
              $firstline = false;
          }
  
          fclose($csvFile);
    }
}
