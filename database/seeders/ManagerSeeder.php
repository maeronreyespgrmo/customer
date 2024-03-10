<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $query = array(
            array(
                'office_id' => 1,
                'manager_name' => "Dr. Mary Grace Bustamante",
            ),
            array(
                'office_id' => 2,
                'manager_name' => "Hon. Katherine C.Kaagapay",
            ),
            array(
                'office_id' => 3,
                'manager_name' => "Fatima Eleanor A. Villasenor",
            ),
            array(
                'office_id' => 4,
                'manager_name' => "Rodrigo Basbas",
            ),
            array(
                'office_id' => 5,
                'manager_name' => "Nieva M. Reodica",
            ),
            array(
                'office_id' => 6,
                'manager_name' => "N/A",
            ),
            array(
                'office_id' => 7,
                'manager_name' => "Mario C. Tobias(ICO)",
            ),
            array(
                'office_id' => 8,
                'manager_name' => "Frederick C. Caraan",
            ),
            array(
                'office_id' => 9,
                'manager_name' => "Fely T. Cruz",
            ),
            array(
                'office_id' => 10,
                'manager_name' => "Nelia Espino",
            ),
            array(
                'office_id' => 11,
                'manager_name' => "Maria Rowena Beatrize Q. Inzon",
            ),
            array(
                'office_id' => 12,
                'manager_name' => "Christopher R. Sanji",
            ),
            array(
                'office_id' => 13,
                'manager_name' => "Rene Bagamasbad",
            ),
            array(
                'office_id' => 14,
                'manager_name' => "Jaime M. Garcia",
            ),
            array(
                'office_id' => 15,
                'manager_name' => "Engr. Maximo Uri(OIC)",
            ),
            array(
                'office_id' => 16,
                'manager_name' => "Pamela Jane P. Baun",
            ),
            array(
                'office_id' => 17,
                'manager_name' => "",
            ),
            array(
                'office_id' => 18,
                'manager_name' => "Atty. Reynante Vibal(OIC)",
            ),
            array(
                'office_id' => 19,
                'manager_name' => "Mary Jane Corcuera",
            ),
            array(
                'office_id' => 20,
                'manager_name' => "Aldwin M. Cejo",
            ),
            array(
                'office_id' => 21,
                'manager_name' => "Teresita S. Ramos",
            ),
            array(
                'office_id' => 22,
                'manager_name' => "Joseph A. Jaralve, Jr(Focal Person)",
            ),
            array(
                'office_id' => 23,
                'manager_name' => "Hon. Gov. Ramil L. Hernandez",
            ),
            array(
                'office_id' => 24,
                'manager_name' => "Atty. Dulce Rabanal",
            ),
            array(
                'office_id' => 25,
                'manager_name' => "",
            ),
            array(
                'office_id' => 26,
                'manager_name' => "Marlon P. Tobias",
            ),
            array(
                'office_id' => 27,
                'manager_name' => "Edwin S. Bautista",
            ),
            array(
                'office_id' => 28,
                'manager_name' => "Dr. Sarah S. Salamat",
            ),
            array(
                'office_id' => 29,
                'manager_name' => "Jocelyn J. Litan",
            ),
            array(
                'office_id' => 30,
                'manager_name' => "Engr. Abet F. Arellano",
            ),
            array(
                'office_id' => 31,
                'manager_name' => "Joiphylen C. Bacanto",
            ),
            array(
                'office_id' => 32,
                'manager_name' => "Vivencio G. Malabanan",
            ),
            array(
                'office_id' => 33,
                'manager_name' => "Engr. Pablo V. del Mundo, Jr",
            ),
            array(
                'office_id' => 34,
                'manager_name' => "Lucia C. Almeda",
            ),
            array(
                'office_id' => 35,
                'manager_name' => "Leah Theresa R. Javier",
            ),
            array(
                'office_id' => 36,
                'manager_name' => "Mitzy C. Elbo",
            ),
            array(
                'office_id' => 37,
                'manager_name' => "Rommel Palacol/Marlon Mangahas",
            ),
            array(
                'office_id' => 38,
                'manager_name' => "Justin P. Garcia",
            ),
            array(
                'office_id' => 39,
                'manager_name' => "Dr. Jed E. Dagsan",
            ),
            array(
                'office_id' => 40,
                'manager_name' => "Engr. Pablo V. del Mundo, Jr",
            ),
            array(
                'office_id' => 41,
                'manager_name' => "Professor Monette O. Bato",
            ),
        );
        DB::table('tbl_managers')->insert($query);
    }
}
