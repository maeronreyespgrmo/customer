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
                if($request->invalidated == "no"){
                    foreach($request->services as $services_item){
                        $query_services = DB::table('tbl_services')
                        ->select('id')
                        ->where('service_name', $services_item)
                        ->where('office_id', $query_offices[0]->id)
                        ->get();
                        $originalArrayServices[] = $query_services[0]->id;
                    }
                    $services = implode(',',  $originalArrayServices);
                }
                else{
                    $services = "invalidated";
                }

            $table = new FormCSS;
            $table->date = $request->date;
            $table->name_evaluatee = $request->name_evaluatee;
            $table->name_evaluator = $request->name_evaluator;
            $table->services_id = $services;
            $table->office_id = $query_offices[0]->id;
            $table->radio_1 = $request->radio_1 ?? "N/A";
            $table->radio_2 = $request->radio_2 ?? "N/A";
            $table->radio_3 = $request->radio_3 ?? "N/A";
            $table->radio_4 = $request->radio_4 ?? "N/A";
            $table->radio_5 = $request->radio_5 ?? "N/A";
            $table->radio_6 = $request->radio_6 ?? "N/A";
            $table->radio_7 = $request->radio_7 ?? "N/A";
            $table->radio_8 = $request->radio_8 ?? "N/A";
            $table->radio_9 = $request->radio_9 ?? "N/A";
            $table->radio_10 = $request->radio_10 ?? "N/A";
            $table->radio_11 = $request->radio_11 ?? "N/A";
            $table->radio_12 = $request->radio_12 ?? "N/A";
            $table->comments = $request->comments ?? "N/A";
            $table->invalidated = $request->invalidated;
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

            $query_offices = DB::table('tbl_offices')
                ->select('id')
                ->where('office_name', $request->office_name)
                ->get();

            if($request->invalidated == "no"){
                foreach($request->services as $services_item){
                    $query_services = DB::table('tbl_services')
                    ->select('id')
                    ->where('service_name', $services_item)
                    ->where('office_id', $query_offices[0]->id)
                    ->get();
                    $originalArrayServices[] = $query_services[0]->id;
                }
                $services = implode(',',  $originalArrayServices);
            }
            else{
                $services = "invalidated";
            }

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
                'invalidated' => $request->invalidated,
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

        $result_invalidated = DB::table('tbl_form_css')
        ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
        ->select('tbl_form_css.*', 'tbl_offices.office_name')
        ->where('tbl_form_css.id', $request->id)
        ->get();
        
        if($result_invalidated[0]->invalidated == "yes"){
            $result = DB::table('tbl_form_css')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->select('tbl_form_css.*','tbl_offices.office_name')
            ->where('tbl_form_css.id', $request->id)
            ->get();
        }
        else{
            $result = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->where('tbl_form_css.id', $request->id)
            ->get();
        }

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
            $table->patient_name = $request->patient_name ?? "N/A";
            $table->home_address = $request->home_address ?? "N/A";
            $table->date = $request->date;
            $table->date_in = $request->date_in ?? "N/A";
            $table->date_out = $request->date_out ?? "N/A";
            $table->checked_doctor = $request->checked_doctor ?? "0";
            $table->before_admit = $request->before_admit ?? "0";
            $table->radio1_a = $request->radio1_a ?? "0";
            $table->radio1_b = $request->radio1_b ?? "0";
            $table->radio1_c = $request->radio1_c ?? "0";
            $table->radio1_d = $request->radio1_d ?? "0";
            $table->radio1_e = $request->radio1_e ?? "0";
            $table->radio1_f = $request->radio1_f ?? "0";
            $table->radio1_g = $request->radio1_g ?? "0";
            $table->radio2_a = $request->radio2_a ?? "0";
            $table->radio2_b = $request->radio2_b ?? "0";
            $table->radio2_c = $request->radio2_c ?? "0";
            $table->radio2_d = $request->radio2_d ?? "0";
            $table->radio2_e = $request->radio2_e ?? "0";
            $table->radio3_a = $request->radio3_a ?? "0";
            $table->radio3_b = $request->radio3_b ?? "0";
            $table->radio3_c = $request->radio3_c ?? "0";
            $table->radio3_d = $request->radio3_d ?? "0";
            $table->radio3_e = $request->radio3_e ?? "0";
            $table->radio4_a = $request->radio4_a ?? "0";
            $table->radio4_b = $request->radio4_b ?? "0";
            $table->radio4_c = $request->radio4_c ?? "0";
            $table->radio4_d = $request->radio4_d ?? "0";
            $table->radio5_a = $request->radio5_a ?? "0";
            $table->radio5_b = $request->radio5_b ?? "0";
            $table->radio5_c = $request->radio5_c ?? "0";
            $table->radio5_d = $request->radio5_d ?? "0";
            $table->radio5_e = $request->radio5_e ?? "0";
            $table->radio6_a = $request->radio6_a ?? "0";
            $table->radio6_b = $request->radio6_b ?? "0";
            $table->radio6_c = $request->radio6_c ?? "0";
            $table->radio6_d = $request->radio6_d ?? "0";
            $table->radio6_e = $request->radio6_e ?? "0";
            $table->radio7_a = $request->radio7_a ?? "0";
            $table->radio7_b = $request->radio7_b ?? "0";
            $table->radio7_c = $request->radio7_c ?? "0";
            $table->radio7_d = $request->radio7_d ?? "0";
            $table->radio7_e = $request->radio7_e ?? "0";
            $table->radio8_a = $request->radio8_a ?? "0";
            $table->radio8_b = $request->radio8_b ?? "0";
            $table->radio8_c = $request->radio8_c ?? "0";
            $table->radio8_d = $request->radio8_d ?? "0";
            $table->radio8_e = $request->radio8_e ?? "0";
            $table->radio9_a = $request->radio9_a ?? "0";
            $table->radio9_b = $request->radio9_b ?? "0";
            $table->radio9_c = $request->radio9_c ?? "0";
            $table->radio9_d = $request->radio9_d ?? "0";
            $table->radio9_e = $request->radio9_e ?? "0";
            $table->radio10_a = $request->radio10_a ?? "0";
            $table->radio10_b = $request->radio10_b ?? "0";
            $table->radio10_c = $request->radio10_c ?? "0";
            $table->radio10_d = $request->radio10_d ?? "0";
            $table->radio10_e = $request->radio10_e ?? "0";
            $table->radio11_a = $request->radio11_a ?? "0";
            $table->radio11_b = $request->radio11_b ?? "0";
            $table->radio11_c = $request->radio11_c ?? "0";
            $table->radio11_d = $request->radio11_d ?? "0";
            $table->radio12_a = $request->radio12_a ?? "0";
            $table->radio12_b = $request->radio12_b ?? "0";
            $table->radio12_c = $request->radio12_c ?? "0";
            $table->radio12_d = $request->radio12_d ?? "0";
            $table->radio12_e = $request->radio12_e ?? "0";
            $table->radio13_a = $request->radio13_a ?? "0";
            $table->radio13_b = $request->radio13_b ?? "0";
            $table->radio13_c = $request->radio13_c ?? "0";
            $table->radio13_d = $request->radio13_d ?? "0";
            $table->radio13_e = $request->radio13_e ?? "0";
            $table->radio14_a = $request->radio14_a ?? "0";
            $table->radio14_b = $request->radio14_b ?? "0";
            $table->radio14_c = $request->radio14_c ?? "0";
            $table->radio14_d = $request->radio14_d ?? "0";
            $table->radio14_e = $request->radio14_e ?? "0";
            $table->comments = $request->comments ?? "N/A";
            $table->invalidated = $request->invalidated;
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
                'patient_name' => $request->patient_name ?? "N/A",
                'home_address' => $request->home_address ?? "N/A",
                'date' => $request->date ?? "N/A",
                'date_in' => $request->date_in ?? "N/A",
                'date_out' => $request->date_out ?? "N/A",
                'checked_doctor' => $request->checked_doctor ?? "6",
                'before_admit' => $request->before_admit ?? "6",
                'radio1_a' => $request->radio1_a ?? "0",
                'radio1_b' => $request->radio1_b ?? "0",
                'radio1_c' => $request->radio1_c ?? "0",
                'radio1_d' => $request->radio1_d ?? "0",
                'radio1_e' => $request->radio1_e ?? "0",
                'radio1_f' => $request->radio1_f ?? "0",
                'radio1_g' => $request->radio1_g ?? "0",
                'radio2_a' => $request->radio2_a ?? "0",
                'radio2_b' => $request->radio2_b ?? "0",
                'radio2_c' => $request->radio2_c ?? "0",
                'radio2_d' => $request->radio2_d ?? "0",
                'radio2_e' => $request->radio2_e ?? "0",
                'radio3_a' => $request->radio3_a ?? "0",
                'radio3_b' => $request->radio3_b ?? "0",
                'radio3_c' => $request->radio3_c ?? "0",
                'radio3_d' => $request->radio3_d ?? "0",
                'radio3_e' => $request->radio3_e ?? "0",
                'radio4_a' => $request->radio4_a ?? "0",
                'radio4_b' => $request->radio4_b ?? "0",
                'radio4_c' => $request->radio4_c ?? "0",
                'radio4_d' => $request->radio4_d ?? "0",
                'radio5_a' => $request->radio5_a ?? "0",
                'radio5_b' => $request->radio5_b ?? "0",
                'radio5_c' => $request->radio5_c ?? "0",
                'radio5_d' => $request->radio5_d ?? "0",
                'radio5_e' => $request->radio5_e ?? "0",
                'radio6_a' => $request->radio6_a ?? "0",
                'radio6_b' => $request->radio6_b ?? "0",
                'radio6_c' => $request->radio6_c ?? "0",
                'radio6_d' => $request->radio6_d ?? "0",
                'radio6_e' => $request->radio6_e ?? "0",
                'radio7_a' => $request->radio7_a ?? "0",
                'radio7_b' => $request->radio7_b ?? "0",
                'radio7_c' => $request->radio7_c ?? "0",
                'radio7_d' => $request->radio7_d ?? "0",
                'radio7_e' => $request->radio7_e ?? "0",
                'radio8_a' => $request->radio8_a ?? "0",
                'radio8_b' => $request->radio8_b ?? "0",
                'radio8_a' => $request->radio8_a ?? "0",
                'radio8_c' => $request->radio8_c ?? "0",
                'radio8_d' => $request->radio8_d ?? "0",
                'radio8_e' => $request->radio8_e ?? "0",
                'radio9_a' => $request->radio9_a ?? "0",
                'radio9_b' => $request->radio9_b ?? "0",
                'radio9_c' => $request->radio9_c ?? "0",
                'radio9_d' => $request->radio9_d ?? "0",
                'radio9_e' => $request->radio9_e ?? "0",
                'radio10_a' => $request->radio10_a ?? "0",
                'radio10_b' => $request->radio10_b ?? "0",
                'radio10_c' => $request->radio10_c ?? "0",
                'radio10_d' => $request->radio10_d ?? "0",
                'radio10_e' => $request->radio10_e ?? "0",
                'radio11_a' => $request->radio11_a ?? "0",
                'radio11_b' => $request->radio11_b ?? "0",
                'radio11_c' => $request->radio11_c ?? "0",
                'radio11_d' => $request->radio11_d ?? "0",
                'radio12_a' => $request->radio12_a ?? "0",
                'radio12_b' => $request->radio12_b ?? "0",
                'radio12_c' => $request->radio12_c ?? "0",
                'radio12_d' => $request->radio12_d ?? "0",
                'radio12_e' => $request->radio12_e ?? "0",
                'radio13_a' => $request->radio13_a ?? "0",
                'radio13_b' => $request->radio13_b ?? "0",
                'radio13_c' => $request->radio13_c ?? "0",
                'radio13_d' => $request->radio13_d ?? "0",
                'radio14_a' => $request->radio14_a ?? "0",
                'radio14_b' => $request->radio14_b ?? "0",
                'radio14_c' => $request->radio14_c ?? "0",
                'radio14_d' => $request->radio14_c ?? "0",
                'radio14_e' => $request->radio14_e ?? "0",
                'comments' => $request->comments ?? "0",
                'invalidated' => $request->invalidated
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
