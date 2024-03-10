<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormCSS;
use App\Models\FormPSS;
use Carbon\Carbon;

class ImportController extends Controller
{
    //DISPLAY CSS
    public function display_css(Request $request)
    {
        $total_count = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->where('tbl_form_css.deleted_at', null)
            ->where('tbl_offices.office_name', 'LIKE', $request->office_name)
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->whereNull('tbl_form_css.deleted_at')
            ->whereRaw("
            CONCAT(
            tbl_form_css.id, 
            office_name,
            service_name,
            name_evaluatee,
            name_evaluator,
            date
            ) LIKE '%" . $request->search . "%'")
            ->count();
        $currentpage =  $request->nextpage;
        $rowsperpage = 10;
        $totalpages = ceil($total_count / $rowsperpage);
        if ($currentpage == null && !is_numeric($currentpage)) {
            $currentpage = 1;
        }
        if ($currentpage > $totalpages) {
            $currentpage = $totalpages;
        }
        $offset = ($currentpage - 1) * $rowsperpage;

        $next = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->where('tbl_offices.office_name', 'LIKE', $request->office_name)
            ->where('tbl_form_css.deleted_at', null)
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereRaw("
            CONCAT(
            tbl_form_css.id, 
            office_name,
            service_name,
            name_evaluatee,
            name_evaluator,
            date
            ) LIKE '%" . $request->search . "%'")
            ->orderBy('id', 'desc')
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //DISPLAY PSS
    public function display_pss(Request $request)
    {
        $total_count = DB::table('tbl_form_pss')
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->whereNull('tbl_form_pss.deleted_at')
            ->where('tbl_hospitals.hospital_name', 'LIKE', $request->hospital_name)
            ->whereRaw("
            CONCAT(
            tbl_form_pss.id, 
            patient_name,
            home_address,
            date,
            comments
            ) LIKE '%" . $request->search . "%'")
            ->count();
        $currentpage =  $request->nextpage;
        $rowsperpage = 10;
        $totalpages = ceil($total_count / $rowsperpage);
        if ($currentpage == null && !is_numeric($currentpage)) {
            $currentpage = 1;
        }
        if ($currentpage > $totalpages) {
            $currentpage = $totalpages;
        }
        $offset = ($currentpage - 1) * $rowsperpage;

        $next = DB::table('tbl_form_pss')
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_hospitals.hospital_name', 'LIKE', $request->hospital_name)
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereNull('tbl_form_pss.deleted_at')
            ->whereRaw("
            CONCAT(
            tbl_form_pss.id, 
            patient_name,
            home_address,
            date,
            comments
            ) LIKE '%" . $request->search . "%'")
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //IMPORT CSS FROM EXCEL TO DATABASE
    public function import_css(Request $request)
    {
        // return $request;
        try {
            DB::beginTransaction();
            for ($i = 0; $i < $request->len; $i++) {
                $query_offices = DB::table('tbl_offices')
                    ->where('office_name', 'like', '%' . $request->office_name . '%')
                    ->get();

                if ($query_offices->isNotEmpty()) {
                    $office_id = $query_offices[0]->id;
                    $query_services = DB::table('tbl_services')
                        ->where('office_id', '=', $office_id)
                        ->where('service_name', 'like', '%' . $request->arr[$i]['services_id'] . '%')
                        ->get();

                    if ($query_services->isNotEmpty()) {
                        $service_id = $query_services[0]->id;
                        $others_remarks = "";
                    } else {
                        $query_services2 = DB::table('tbl_services')
                            ->where('office_id', '=', $query_offices[0]->id)
                            ->where('service_name', '=', 'Other')
                            ->get();

                        $service_id = $query_services2[0]->id;
                        $others_remarks = $request->arr[$i]['services_id'];
                    }


                    $date = Carbon::createFromFormat('m/d/y', $request->arr[$i]['date']);
                    $formattedDate = $date->format('Y-m-d');


                    if (FormCSS::where('name_evaluatee', $request->arr[$i]['name_evaluatee'] ?? "N/A")
                        ->where('name_evaluator', $request->arr[$i]['name_evaluator'] ?? "N/A")
                        ->where('date', $formattedDate)
                        ->where('services_id', $service_id)
                        ->exists()
                    ) {
                    } else {
                        $table = new FormCSS;
                        $table->date = $formattedDate;
                        $table->name_evaluator = $request->arr[$i]['name_evaluator'] ?? "N/A";
                        $table->name_evaluatee = $request->arr[$i]['name_evaluatee'] ?? "N/A";
                        $table->services_id = $service_id;
                        $table->office_id = $office_id;
                        $table->radio_1 = $request->arr[$i]['radio_1'];
                        $table->radio_2 = $request->arr[$i]['radio_2'];
                        $table->radio_3 = $request->arr[$i]['radio_3'];
                        $table->radio_4 = $request->arr[$i]['radio_4'];
                        $table->radio_5 = $request->arr[$i]['radio_5'];
                        $table->radio_6 = $request->arr[$i]['radio_6'];
                        $table->radio_7 = $request->arr[$i]['radio_7'];
                        $table->radio_8 = $request->arr[$i]['radio_8'];
                        $table->radio_9 = $request->arr[$i]['radio_9'];
                        $table->radio_10 = $request->arr[$i]['radio_10'];
                        $table->radio_11 = $request->arr[$i]['radio_11'];
                        $table->radio_12 = $request->arr[$i]['radio_12'];
                        $table->comments = $request->arr[$i]['comments'] ?? "N/A";
                        $table->others_remarks = $others_remarks;
                        $table->save();
                    }
                }
            }
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            // DB::rollBack();
            return $e->getMessage();
        }
    }
    //FOR TESTING PUSPOSES ONLY
    public function import_test(Request $request)
    {

        if (FormCSS::where('id', '1')
            ->where('name_evaluatee', '1')
            ->where('date', '1')
            ->where('name_evaluator', '1')
            ->where('services_id', '1')
            ->exists()
        ) {
            return "Exist";
        } else {
            return "Not Exist";
        }
    }
    //IMPORT PSS FROM EXCEL TO DATABASE
    public function import_pss(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->hospital_name == "SPC") {
                $hospital_name = "SAN PABLO";
            } else {
                $hospital_name = $request->hospital_name;
            }
            $query_hospital = DB::table('tbl_hospitals')
                ->where('hospital_name', 'LIKE', '%' . $hospital_name . '%')
                ->get();

            $hospital_id = $query_hospital[0]->id;

            for ($i = 0; $i < $request->len; $i++) {

                $date = Carbon::createFromFormat('m/d/y', $request->arr[$i]['date']);
                $formattedDate = $date->format('Y-m-d');

                $date_date_in = Carbon::createFromFormat('m/d/y', $request->arr[$i]['date']);
                $formattedDate_date_in = $date_date_in->format('Y-m-d');

                $date_date_out = Carbon::createFromFormat('m/d/y', $request->arr[$i]['date']);
                $formattedDate_date_out = $date_date_out->format('Y-m-d');

                $query_form_pss = FormPSS::where('patient_name', $request->arr[$i]['patient_name'] ?? "")
                    ->where('hospital_id', $hospital_id)
                    ->where('date', $formattedDate)
                    ->get();

                if ($query_form_pss->isNotEmpty()) {
                } else {
                    $mapping_checked_doctor = array(
                        'walang isang oras (less than 1 hour)' => '1',
                        'isa hanggang  dalawang oras (1- 2 hours)' => '2',
                        'tatlo hanggang apat na oras (3-4 hours)' => '3',
                        'lima hanggang anim na oras (5-6 hours)' => '4',
                        'pito hanggang walong oras (7-8 hours)' => '5',
                        'not Indicated' => '6',
                    );

                    $mapping_before_admit = array(
                        'walang isang oras (less than 1 hour)' => '1',
                        'isa hanggang  dalawang oras (1- 2 hours)' => '2',
                        'tatlo hanggang apat na oras (3-4 hours)' => '3',
                        'lima hanggang anim na oras (5-6 hours)' => '4',
                        'pito hanggang walong oras (7-8 hours)' => '5',
                        'not Indicated' => '6',
                    );

                    $checked_doctor = isset($mapping_checked_doctor[$request->arr[$i]['checked_doctor']]) ? $mapping_checked_doctor[$request->arr[$i]['checked_doctor']] : '6';
                    $before_admit = isset($mapping_before_admit[$request->arr[$i]['before_admit']]) ? $mapping_before_admit[$request->arr[$i]['before_admit']] : '6';

                    $table = new FormPSS;
                    $table->hospital_id = $hospital_id;
                    $table->patient_name = $request->arr[$i]['patient_name'] ?? "N/A";
                    $table->home_address = $request->arr[$i]['home_address'];
                    $table->date = $formattedDate;
                    $table->date_in = $formattedDate_date_in;
                    $table->date_out = $formattedDate_date_out;
                    $table->checked_doctor = $checked_doctor;
                    $table->before_admit = $before_admit;
                    $table->radio1_a = $request->arr[$i]['radio1_a'];
                    $table->radio1_b = $request->arr[$i]['radio1_b'];
                    $table->radio1_c = $request->arr[$i]['radio1_c'];
                    $table->radio1_d = $request->arr[$i]['radio1_d'];
                    $table->radio1_e = $request->arr[$i]['radio1_e'];
                    $table->radio1_f = $request->arr[$i]['radio1_f'];
                    $table->radio1_g = $request->arr[$i]['radio1_g'];
                    $table->radio2_a = $request->arr[$i]['radio2_a'];
                    $table->radio2_b = $request->arr[$i]['radio2_b'];
                    $table->radio2_c = $request->arr[$i]['radio2_c'];
                    $table->radio2_d = $request->arr[$i]['radio2_d'];
                    $table->radio2_e = $request->arr[$i]['radio2_e'];
                    $table->radio3_a = $request->arr[$i]['radio3_a'];
                    $table->radio3_b = $request->arr[$i]['radio3_b'];
                    $table->radio3_c = $request->arr[$i]['radio3_c'];
                    $table->radio3_d = $request->arr[$i]['radio3_d'];
                    $table->radio3_e = $request->arr[$i]['radio3_e'];
                    $table->radio4_a = $request->arr[$i]['radio4_a'];
                    $table->radio4_b = $request->arr[$i]['radio4_b'];
                    $table->radio4_c = $request->arr[$i]['radio4_c'];
                    $table->radio4_d = $request->arr[$i]['radio4_d'];
                    $table->radio5_a = $request->arr[$i]['radio5_a'];
                    $table->radio5_b = $request->arr[$i]['radio5_b'];
                    $table->radio5_c = $request->arr[$i]['radio5_c'];
                    $table->radio5_d = $request->arr[$i]['radio5_d'];
                    $table->radio5_e = $request->arr[$i]['radio5_e'];
                    $table->radio6_a = $request->arr[$i]['radio6_a'];
                    $table->radio6_b = $request->arr[$i]['radio6_b'];
                    $table->radio6_c = $request->arr[$i]['radio6_c'];
                    $table->radio6_d = $request->arr[$i]['radio6_d'];
                    $table->radio6_e = $request->arr[$i]['radio6_e'];
                    $table->radio7_a = $request->arr[$i]['radio7_a'];
                    $table->radio7_b = $request->arr[$i]['radio7_b'];
                    $table->radio7_c = $request->arr[$i]['radio7_c'];
                    $table->radio7_d = $request->arr[$i]['radio7_d'];
                    $table->radio7_e = $request->arr[$i]['radio7_e'];
                    $table->radio8_a = $request->arr[$i]['radio8_a'];
                    $table->radio8_b = $request->arr[$i]['radio8_b'];
                    $table->radio8_c = $request->arr[$i]['radio8_c'];
                    $table->radio8_d = $request->arr[$i]['radio8_d'];
                    $table->radio8_e = $request->arr[$i]['radio8_e'];
                    $table->radio9_a = $request->arr[$i]['radio9_a'];
                    $table->radio9_b = $request->arr[$i]['radio9_b'];
                    $table->radio9_c = $request->arr[$i]['radio9_c'];
                    $table->radio9_d = $request->arr[$i]['radio9_d'];
                    $table->radio9_e = $request->arr[$i]['radio9_e'];
                    $table->radio10_a = $request->arr[$i]['radio10_a'];
                    $table->radio10_b = $request->arr[$i]['radio10_b'];
                    $table->radio10_c = $request->arr[$i]['radio10_c'];
                    $table->radio10_d = $request->arr[$i]['radio10_d'];
                    $table->radio10_e = $request->arr[$i]['radio10_e'];
                    $table->radio11_a = $request->arr[$i]['radio11_a'];
                    $table->radio11_b = $request->arr[$i]['radio11_b'];
                    $table->radio11_c = $request->arr[$i]['radio11_c'];
                    $table->radio11_d = $request->arr[$i]['radio11_d'];
                    $table->radio12_a = $request->arr[$i]['radio12_a'];
                    $table->radio12_b = $request->arr[$i]['radio12_b'];
                    $table->radio12_c = $request->arr[$i]['radio12_c'];
                    $table->radio12_d = $request->arr[$i]['radio12_d'];
                    $table->radio12_e = $request->arr[$i]['radio12_e'];
                    $table->radio13_a = $request->arr[$i]['radio13_a'];
                    $table->radio13_b = $request->arr[$i]['radio13_b'];
                    $table->radio13_c = $request->arr[$i]['radio13_c'];
                    $table->radio13_d = $request->arr[$i]['radio13_d'];
                    $table->radio13_e = $request->arr[$i]['radio13_e'];
                    $table->radio14_a = $request->arr[$i]['radio14_a'];
                    $table->radio14_b = $request->arr[$i]['radio14_b'];
                    $table->radio14_c = $request->arr[$i]['radio14_c'];
                    $table->radio14_d = $request->arr[$i]['radio14_d'];
                    $table->radio14_e = $request->arr[$i]['radio14_e'];
                    $table->comments = $request->arr[$i]['comments'] ?? "N/A";
                    $table->save();
                }
            }
            DB::commit();
            return $request->arr;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}
