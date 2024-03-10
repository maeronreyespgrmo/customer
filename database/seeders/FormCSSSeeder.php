<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  

class FormCSSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        $query = array(
            array(
                'name_evaluatee' => 'Maeron Reyes1',
                'name_evaluator' => "Racquel Burbos2",
                'date' => "2023-05-29",
                'office_id' => 1,
                'services_id' => 1,
                'radio_1' => "1",
                'radio_2' => "1",
                'radio_3' => "1",
                'radio_4' => "1",
                'radio_5' => "1",
                'radio_6' => "1",
                'radio_7' => "1",
                'radio_8' => "1",
                'radio_9' => "1",
                'radio_10' => "1",
                'radio_11' => "1",
                'radio_12' => "1",
                'comments' => "2323223232323232323",
                'others_remarks' => "232323",
                'invalidated' => "yes",
            ),
            array(
                'name_evaluatee' => 'Maeron Reyes2',
                'name_evaluator' => "Racquel Burbos2",
                'date' => "2023-05-29",
                'office_id' => 1,
                'services_id' => 1,
                'radio_1' => "1",
                'radio_2' => "1",
                'radio_3' => "1",
                'radio_4' => "1",
                'radio_5' => "1",
                'radio_6' => "1",
                'radio_7' => "1",
                'radio_8' => "1",
                'radio_9' => "1",
                'radio_10' => "1",
                'radio_11' => "1",
                'radio_12' => "1",
                'comments' => "adadadkajdakdjkkdaakdjkad",
                'others_remarks' => "",
                'invalidated' => "yes",
            ),
            array(
                'name_evaluatee' => 'Maeron Reyes3',
                'name_evaluator' => "Racquel Burbos3",
                'date' => "2023-05-29",
                'office_id' => 1,
                'services_id' => 1,
                'radio_1' => "4",
                'radio_2' => "3",
                'radio_3' => "2",
                'radio_4' => "4",
                'radio_5' => "3",
                'radio_6' => "2",
                'radio_7' => "4",
                'radio_8' => "3",
                'radio_9' => "2",
                'radio_10' => "1",
                'radio_11' => "4",
                'radio_12' => "4",
                'comments' => "4",
                'others_remarks' => "",
                'invalidated' => "yes",
            ),
            array(
                'name_evaluatee' => 'Maeron Reyes3',
                'name_evaluator' => "Racquel Burbos3",
                'date' => "2023-05-29",
                'office_id' => 1,
                'services_id' => 2,
                'radio_1' => "4",
                'radio_2' => "3",
                'radio_3' => "2",
                'radio_4' => "4",
                'radio_5' => "3",
                'radio_6' => "2",
                'radio_7' => "4",
                'radio_8' => "3",
                'radio_9' => "2",
                'radio_10' => "1",
                'radio_11' => "4",
                'radio_12' => "4",
                'comments' => "4",
                'others_remarks' => "",
                'invalidated' => "yes",
            ),
            array(
                'name_evaluatee' => 'Maeron Reyes3',
                'name_evaluator' => "Racquel Burbos3",
                'date' => "2023-05-29",
                'office_id' => 1,
                'services_id' => 3,
                'radio_1' => "1",
                'radio_2' => "1",
                'radio_3' => "1",
                'radio_4' => "1",
                'radio_5' => "1",
                'radio_6' => "1",
                'radio_7' => "1",
                'radio_8' => "1",
                'radio_9' => "1",
                'radio_10' => "1",
                'radio_11' => "1",
                'radio_12' => "1",
                'comments' => "1",
                'others_remarks' => "",
                'invalidated' => "yes",
            ),
            
        );
        DB::table('tbl_form_css')->insert($query);  
        
    }
}
