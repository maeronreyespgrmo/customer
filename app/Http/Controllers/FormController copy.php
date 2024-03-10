<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\FormCSS;
use App\Models\FormPSS;
use App\Models\Office;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    //SAVE CSS FORM 
    public function save_css(Request $request)
    {
        $originalArrayServices = [];
        try {
            DB::beginTransaction();
            $query_offices = DB::table('tbl_offices')
                ->select('id')
                ->where('office_name', $request->office_name)
                ->get();

                foreach($request->services as $services_item){
                    $query_services = DB::table('tbl_services')
                    ->select('id')
                    ->where('service_name', $services_item)
                    ->where('office_id', $query_offices[0]->id)
                    ->get();
                    $originalArrayServices[] = $query_services[0]->id;
                }

                $services = implode(',',  $originalArrayServices);

            // $query_services = DB::table('tbl_services')
            //     ->select('id')
            //     ->where('service_name', $request->services)
            //     ->where('office_id', $query_offices[0]->id)
            //     ->get();

            $services_id = $query_services[0]->id;

            $table = new FormCSS;
            $table->date = $request->date;
            $table->name_evaluatee = $request->name_evaluatee;
            $table->name_evaluator = $request->name_evaluator;
            // $table->services_id = $query_services[0]->id;
            $table->services_id = $services;
            $table->office_id = $query_offices[0]->id;
            $table->radio_1 = $request->radio_1;
            $table->radio_2 = $request->radio_2;
            $table->radio_3 = $request->radio_3;
            $table->radio_4 = $request->radio_4;
            $table->radio_5 = $request->radio_5;
            $table->radio_6 = $request->radio_6;
            $table->radio_7 = $request->radio_7;
            $table->radio_8 = $request->radio_8;
            $table->radio_9 = $request->radio_9;
            $table->radio_10 = $request->radio_10;
            $table->radio_11 = $request->radio_11;
            $table->radio_12 = $request->radio_12;
            $table->comments = $request->comments;
            $table->others_remarks = $request->others_remarks;
            $table->save();

            DB::commit();
            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE CSS FORM
    public function edit_css(Request $request)
    {
        try {
            DB::beginTransaction();

            $query_services = DB::table('tbl_services')
                ->select('id')
                ->where('service_name', $request->services)
                ->get();

            $query_offices = DB::table('tbl_offices')
                ->select('id')
                ->where('office_name', $request->office_name)
                ->where('office_id', $query_offices[0]->id)
                ->get();

            FormCSS::where('id', $request->id)->update([
                'date' => $request->date,
                'name_evaluatee' => $request->name_evaluatee,
                'name_evaluator' => $request->name_evaluator,
                'services_id' => $query_services[0]->id,
                'office_id' => $query_offices[0]->id,
                'radio_1' => $request->radio_1,
                'radio_2' => $request->radio_2,
                'radio_3' => $request->radio_3,
                'radio_4' => $request->radio_4,
                'radio_5' => $request->radio_5,
                'radio_6' => $request->radio_6,
                'radio_7' => $request->radio_7,
                'radio_8' => $request->radio_8,
                'radio_9' => $request->radio_9,
                'radio_10' => $request->radio_10,
                'radio_11' => $request->radio_11,
                'radio_12' => $request->radio_12,
                'comments' => $request->comments,
                'others_remarks' => $request->others_remarks
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE CSS FORM
    public function destroy_css(Request $request)
    {
        $id = FormCSS::find($request->id);
        $id->delete();
        return "success";
    }
    //VIEW CSS FORM
    public function view_css(Request $request)
    {
        $result = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->where('tbl_form_css.id', $request->id)
            ->get();

        return $result;
    }
    //VIEW PSS FORM
    public function view_pss(Request $request)
    {
        $result = DB::table('tbl_form_pss')
            ->select('tbl_hospitals.hospital_name', 'tbl_form_pss.*')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_form_pss.id', '=', $request->id)
            ->get();

        return $result;
    }
    //SAVE PSS FORM
    public function save_pss(Request $request)
    {


        try {
            DB::beginTransaction();
            $hospitals = DB::table('tbl_hospitals')
                ->select('id')
                ->where('hospital_name', $request->hospital_name)
                ->get();
            $table = new FormPSS;
            $table->hospital_id = $hospitals[0]->id;
            $table->patient_name = $request->patient_name;
            $table->home_address = $request->home_address;
            $table->date = $request->date;
            $table->date_in = $request->date_in;
            $table->date_out = $request->date_out;
            $table->checked_doctor = $request->checked_doctor;
            $table->before_admit = $request->before_admit;
            $table->radio1_a = $request->radio1_a;
            $table->radio1_b = $request->radio1_b;
            $table->radio1_c = $request->radio1_c;
            $table->radio1_d = $request->radio1_d;
            $table->radio1_e = $request->radio1_e;
            $table->radio1_f = $request->radio1_f;
            $table->radio1_g = $request->radio1_g;
            $table->radio2_a = $request->radio2_a;
            $table->radio2_b = $request->radio2_b;
            $table->radio2_c = $request->radio2_c;
            $table->radio2_d = $request->radio2_d;
            $table->radio2_e = $request->radio2_e;
            $table->radio3_a = $request->radio3_a;
            $table->radio3_b = $request->radio3_b;
            $table->radio3_c = $request->radio3_c;
            $table->radio3_d = $request->radio3_d;
            $table->radio3_e = $request->radio3_e;
            $table->radio4_a = $request->radio4_a;
            $table->radio4_b = $request->radio4_b;
            $table->radio4_c = $request->radio4_c;
            $table->radio4_d = $request->radio4_d;
            $table->radio5_a = $request->radio5_a;
            $table->radio5_b = $request->radio5_b;
            $table->radio5_c = $request->radio5_c;
            $table->radio5_d = $request->radio5_d;
            $table->radio5_e = $request->radio5_e;
            $table->radio6_a = $request->radio6_a;
            $table->radio6_b = $request->radio6_b;
            $table->radio6_c = $request->radio6_c;
            $table->radio6_d = $request->radio6_d;
            $table->radio6_e = $request->radio6_e;
            $table->radio7_a = $request->radio7_a;
            $table->radio7_b = $request->radio7_b;
            $table->radio7_c = $request->radio7_c;
            $table->radio7_d = $request->radio7_d;
            $table->radio7_e = $request->radio7_e;
            $table->radio8_a = $request->radio8_a;
            $table->radio8_b = $request->radio8_b;
            $table->radio8_c = $request->radio8_c;
            $table->radio8_d = $request->radio8_d;
            $table->radio8_e = $request->radio8_e;
            $table->radio9_a = $request->radio9_a;
            $table->radio9_b = $request->radio9_b;
            $table->radio9_c = $request->radio9_c;
            $table->radio9_d = $request->radio9_d;
            $table->radio9_e = $request->radio9_e;
            $table->radio10_a = $request->radio10_a;
            $table->radio10_b = $request->radio10_b;
            $table->radio10_c = $request->radio10_c;
            $table->radio10_d = $request->radio10_d;
            $table->radio10_e = $request->radio10_e;
            $table->radio11_a = $request->radio11_a;
            $table->radio11_b = $request->radio11_b;
            $table->radio11_c = $request->radio11_c;
            $table->radio11_d = $request->radio11_d;
            $table->radio12_a = $request->radio12_a;
            $table->radio12_b = $request->radio12_b;
            $table->radio12_c = $request->radio12_c;
            $table->radio12_d = $request->radio12_d;
            $table->radio12_e = $request->radio12_e;
            $table->radio13_a = $request->radio13_a;
            $table->radio13_b = $request->radio13_b;
            $table->radio13_c = $request->radio13_c;
            $table->radio13_d = $request->radio13_d;
            $table->radio13_e = $request->radio13_e;
            $table->radio14_a = $request->radio14_a;
            $table->radio14_b = $request->radio14_b;
            $table->radio14_c = $request->radio14_c;
            $table->radio14_d = $request->radio14_d;
            $table->radio14_e = $request->radio14_e;
            $table->comments = $request->comments;
            $table->save();
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //UPDATE PSS FORM
    public function edit_pss(Request $request)
    {
        try {
            DB::beginTransaction();
            $hospitals = DB::table('tbl_hospitals')
                ->select('id')
                ->where('hospital_name', $request->hospital_name)
                ->get();

            FormPSS::where('id', $request->id)->update([
                'hospital_id' => $hospitals[0]->id,
                'patient_name' => $request->patient_name,
                'home_address' => $request->home_address,
                'date' => $request->date,
                'date_in' => $request->date_in,
                'date_out' => $request->date_out,
                'checked_doctor' => $request->checked_doctor,
                'before_admit' => $request->before_admit,
                'radio1_a' => $request->radio1_a,
                'radio1_b' => $request->radio1_b,
                'radio1_c' => $request->radio1_c,
                'radio1_d' => $request->radio1_d,
                'radio1_e' => $request->radio1_e,
                'radio1_f' => $request->radio1_f,
                'radio1_g' => $request->radio1_g,
                'radio2_a' => $request->radio2_a,
                'radio2_b' => $request->radio2_b,
                'radio2_c' => $request->radio2_c,
                'radio2_d' => $request->radio2_d,
                'radio2_e' => $request->radio2_e,
                'radio3_a' => $request->radio3_a,
                'radio3_b' => $request->radio3_b,
                'radio3_c' => $request->radio3_c,
                'radio3_d' => $request->radio3_d,
                'radio3_e' => $request->radio3_e,
                'radio4_a' => $request->radio4_a,
                'radio4_b' => $request->radio4_b,
                'radio4_c' => $request->radio4_c,
                'radio4_d' => $request->radio4_d,
                'radio5_a' => $request->radio5_a,
                'radio5_b' => $request->radio5_b,
                'radio5_c' => $request->radio5_c,
                'radio5_d' => $request->radio5_d,
                'radio5_e' => $request->radio5_e,
                'radio6_a' => $request->radio6_a,
                'radio6_b' => $request->radio6_b,
                'radio6_c' => $request->radio6_c,
                'radio6_d' => $request->radio6_d,
                'radio6_e' => $request->radio6_e,
                'radio7_a' => $request->radio7_a,
                'radio7_b' => $request->radio7_b,
                'radio7_c' => $request->radio7_c,
                'radio7_d' => $request->radio7_d,
                'radio7_e' => $request->radio7_e,
                'radio8_a' => $request->radio8_a,
                'radio8_b' => $request->radio8_b,
                'radio8_a' => $request->radio8_a,
                'radio8_c' => $request->radio8_c,
                'radio8_d' => $request->radio8_d,
                'radio8_e' => $request->radio8_e,
                'radio9_a' => $request->radio9_a,
                'radio9_b' => $request->radio9_b,
                'radio9_c' => $request->radio9_c,
                'radio9_d' => $request->radio9_d,
                'radio9_e' => $request->radio9_e,
                'radio10_a' => $request->radio10_a,
                'radio10_b' => $request->radio10_b,
                'radio10_c' => $request->radio10_c,
                'radio10_d' => $request->radio10_d,
                'radio10_e' => $request->radio10_e,
                'radio11_a' => $request->radio11_a,
                'radio11_b' => $request->radio11_b,
                'radio11_c' => $request->radio11_c,
                'radio11_d' => $request->radio11_d,
                'radio12_a' => $request->radio12_a,
                'radio12_b' => $request->radio12_b,
                'radio12_c' => $request->radio12_c,
                'radio12_d' => $request->radio12_d,
                'radio12_e' => $request->radio12_e,
                'radio13_a' => $request->radio13_a,
                'radio13_b' => $request->radio13_b,
                'radio13_c' => $request->radio13_c,
                'radio13_d' => $request->radio13_d,
                'radio14_a' => $request->radio14_a,
                'radio14_b' => $request->radio14_b,
                'radio14_c' => $request->radio14_c,
                'radio14_d' => $request->radio14_c,
                'radio14_e' => $request->radio14_e,
                'comments' => $request->comments
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DELETE PSS FORM
    public function destroy_pss(Request $request)
    {
        $id = FormPSS::find($request->id);
        $id->delete();
        return "success";
    }
    //OFFICE DROPDOWN
    public function office_dropdown(Request $request)
    {
        $offices = Office::orderBy('office_name', 'ASC')->get();
        return $offices;
    }
    //SERVICE DROPDOWN
    public function service_dropdown(Request $request)
    {
        // $results = Service::pluck('service_name');
        $office_name = $request->office_name;
        $result_office = Office::where('office_name', $office_name)->pluck('id');
        $results = Service::where('office_id', $result_office[0])
            ->where('deleted_at', '=', ' ')
            ->pluck('service_name');
        return $results;
    }
    //MUNICIPALITY DROPDOWN BUT NOT IN USED
    public function municipality_dropdown(Request $request)
    {
        $results = Municipality::pluck('municipality_name');
        return $results;
    }

    public function home_address_dropdown(Request $request)
    {
        // return $home_address = $request->home_address;
        // $query = "SELECT * FROM (
        //     SELECT CONCAT(barangay_name, ' ', city_name, ' ', province_name) AS home_address FROM (
        //         SELECT tbl_provinces.name AS province_name, bb AS city_name, barangay_name
        //         FROM tbl_regions
        //         JOIN tbl_provinces ON tbl_regions.code = tbl_provinces.region_code
        //         JOIN (
        //             SELECT province_code, NAME AS bb, CODE AS cc
        //             FROM tbl_cities
        //         ) AS join1 ON tbl_provinces.code = join1.province_code
        //         JOIN (
        //             SELECT city_and_municipality_code, NAME AS barangay_name
        //             FROM tbl_barangays
        //         ) AS join2 ON join1.cc = join2.city_and_municipality_code
        //     ) tb1
        // ) tb2 WHERE home_address LIKE '%" . $home_address . "%'
        // LIMIT 10
        // ";

        // Execute the query and retrieve the results
        // $results = DB::select($query);

        // return $results;
        // return $request->province;
        $cities = DB::table('tbl_cities')
            ->where('province_code', $request->province)
            ->get();

        return $cities;
    }

    //CHANGE DROPDOWN
    public function change_dropdown(Request $request)
    {
        $officeName = $request->office_name;
        $services = DB::table('tbl_services')
            ->where('office_id', function ($query) use ($officeName) {
                $query->select('id')
                    ->from('tbl_offices')
                    ->where('office_name', $officeName)
                    ->where('tbl_services.deleted_at', '=', NULL);
            })
            ->pluck('service_name');
        return $services;
    }
}
