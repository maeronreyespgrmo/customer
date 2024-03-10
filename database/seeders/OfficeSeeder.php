<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $query = array(
            array(
                'office_name' => "Office of the Provincial Veterinarian(VET)",
            ),
            array(
                'office_name' => "Office of the Vice-Governor(VGO)",
            ),
            array(
                'office_name' => " Youth Development Affairs(YDA)",
            ),
            array(
                'office_name' => "Sectoral Concerns Office(SECTORAL)",
            ),
            array(
                'office_name' => "Special Livelihood Office(SLO)",
            ),
            array(
                'office_name' => "SANGGUNIANG PANLALAWIGAN(SP)",
            ),
            array(
                'office_name' => "Provincial Sports and Games Development Office(SPORTS)",
            ),
            array(
                'office_name' => "Serbisyong Tama Action Center(STAC)",
            ),
            array(
                'office_name' => "Office of the Provincial Treasury Office(PTO)",
            ),
            array(
                'office_name' => "Provincial Population Office - Outreach Services(PPOOUTREACH)",
            ),
            array(
                'office_name' => "Provincial Planning and Development Coordinating Office(PPDCO)",
            ),
            array(
                'office_name' => "Provincial Information Office(PIO)",
            ),
            array(
                'office_name' => "Provincial Health Office(PHO)",
            ),
            array(
                'office_name' => "Management Information Systems Office(MISO)",
            ),
            array(
                'office_name' => "Laguna Traffic Management Office(LTMO)",
            ),
            array(
                'office_name' => "Laguna Tourism, Culture, Arts & Trade Office(LTCATO)",
            ),
            array(
                'office_name' => "Provincial Legal Office(LEGAL)",
            ),
            array(
                'office_name' => "Laguna Provincial Jail(JAIL)",
            ),
            array(
                'office_name' => "Provincial Public Employment Service Office(PESO)",
            ),
            array(
                'office_name' => "Provincial Disaster Risk Reduction and Management Office(PDRRMO)",
            ),
            array(
                'office_name' => "Provincial Nutrition Action Office(NUTRITION)",
            ),
            array(
                'office_name' => "Moral Development and Women's Desk Office(MORAL)",
            ),
            array(
                'office_name' => "Office of the Governor - Executive(GOEXEC)",
            ),
            array(
                'office_name' => "Office of the Provincial Administrator(GOADMIN)",
            ),
            array(
                'office_name' => "Field Agricultural Extension Services - Office of the Provincial Agriculturist(FAES)",
            ),
            array(
                'office_name' => "Provincial Government Environment and Natural Resources Office(ENRO)",
            ),
            array(
                'office_name' => "Provincial Cooperative and Development Office(COOP)",
            ),
            array(
                'office_name' => "Laguna Provincial Chest Center(CHEST)",
            ),
            array(
                'office_name' => "Provincial Budget Office(BUDGET)",
            ),
            array(
                'office_name' => "Office of the Provincial Assessor(ASSESSOR)",
            ),
            array(
                'office_name' => "Office of the Provincial Accountant(ACCOUNTING)",
            ),
            array(
                'office_name' => "Provincial Urban Development and Housing Office(PUDHO)",
            ),
            array(
                'office_name' => "Provincial Engineering Office(ENGINEERING)",
            ),
            array(
                'office_name' => "Provincial Social Welfare and Development Office(PSWDO)",
            ),
            array(
                'office_name' => "Provincial Human Resource Management Office(PHRMO)",
            ),
            array(
                'office_name' => "Provincial General Services Office(GSO)",
            ),
            array(
                'office_name' => "Public Affairs Office(PUBLICAFFAIRS)",
            ),
            array(
                'office_name' => "Laguna Provincial Library(LIBRARY)",
            ),
            array(
                'office_name' => "Provincial Population Office - Clinical Services(PPOCLINICAL)",
            ),
            array(
                'office_name' => "Provincial Engineering Office(PEO)",
            ),
            array(
                'office_name' => "Laguna University(LU)",
            ),
        );
        DB::table('tbl_offices')->insert($query);
    }
}
