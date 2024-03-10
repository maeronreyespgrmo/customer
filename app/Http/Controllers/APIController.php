<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\FormCSS;
use App\Models\FormPSS;
use App\Models\Office;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    //
    public function api_save_css(Request $request)
    {
        try {
            DB::beginTransaction();

            $table = new FormCSS;
            $table->date = $request->date;
            $table->name_evaluatee = $request->name_evaluatee;
            $table->name_evaluator = $request->name_evaluator;
            $table->services_id = $request->services;
            $table->office_id = $request->services_data;
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

    public function api_save_pss(Request $request)
    {
        try {
            DB::beginTransaction();
            $table = new FormPSS;
            $table->hospital_id = $request->hospital_id;
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
            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function api_view_survey_css(Request $request)
    {
        // $formData = FormCSS::limit(100)->get();
        // $formData = FormCSS::all();
        $formData = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->whereNull('tbl_form_css.deleted_at')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->orderBy('id', 'desc')
            ->get();
        return $formData;
    }


    public function api_load_more_view_survey_css($offset, $limit)
    {
        // $formData = FormCSS::limit(5)->get();
        // $formData = FormCSS::all();

        $formData = FormCSS::skip(5)->take(5)->get();


        return $formData;
    }

    public function api_view_survey_pss(Request $request)
    {
        // $formData = FormPSS::limit(100)->get();
        $formData = DB::table('tbl_form_pss')
            ->select('tbl_form_pss.*')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->get();
        return $formData;
    }

    public function wew(Request $request)
    {
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $user = Auth::user();
            // $token = $user->createToken('main')->plainTextToken;
            $status = "Success";
        } else {
            $status = "failed";
        }

        return response([
            'data' => $user,
            'status' => $status
        ]);
    }

    public function test()
    {
        $results = DB::select("
        SELECT *
        FROM (
            SELECT
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '01') AS jan,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '02') AS feb,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '03') AS march,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '04') AS april,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '05') AS may,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '06') AS june,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '07') AS july,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '08') AS aug,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '09') AS sep,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '10') AS oct,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '11') AS novv,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '12') AS decc
        ) TB
     ");
        return $results;
    }

    public function monthly_pss()
    {
        $results = DB::select("
        SELECT *
        FROM (
            SELECT
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '01') AS jan,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '02') AS feb,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '03') AS march,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '04') AS april,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '05') AS may,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '06') AS june,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '07') AS july,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '08') AS aug,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '09') AS sep,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '10') AS oct,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '11') AS novv,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '12') AS decc
        ) TB
     ");
        return $results;
    }

    public function count_survey()
    {
        $results = DB::select("
        SELECT (count_form_pss + count_form_css) AS total_survey, count_form_pss, count_form_css
        FROM (
        SELECT 
        (SELECT COUNT(id) FROM tbl_form_pss) AS count_form_pss,
        (SELECT COUNT(id) FROM tbl_form_css) AS count_form_css
        ) TB
        ");

        return $results;
    }

    public function api_services_dropdown_default(Request $request)
    {
        $result_office = Office::where('office_name', 'Vet')->pluck('id');
        $results = Service::where('office_id', $result_office[0])->pluck('service_name');
        return $results;
    }

    public function api_office_dropdown(Request $request)
    {
        $offices = Office::all();
        return $offices;
    }

    public function api_services_dropdown(Request $request)
    {
        $officeName = $request->office_name;
        $services = DB::table('tbl_services')
            ->where('office_id', function ($query) use ($officeName) {
                $query->select('id')
                    ->from('tbl_offices')
                    ->where('id', $officeName);
            })
            ->get();
        return $services;
    }
}
