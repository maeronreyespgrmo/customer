<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormPSS;

class SurveyController extends Controller
{
    //DISPLAY CSS
    public function display_css(Request $request)
    {
        $total_count = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->whereNull('tbl_form_css.deleted_at')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->where('tbl_offices.office_name', 'LIKE', $request->office_name)
            ->whereRaw("
            CONCAT(
            tbl_form_css.id, 
            service_name,
            name_evaluatee,
            name_evaluator,
            invalidated,
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
            ->whereNull('tbl_form_css.deleted_at')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->where('tbl_offices.office_name', 'LIKE', $request->office_name)
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereRaw("
            CONCAT(
            tbl_form_css.id, 
            service_name,
            name_evaluatee,
            name_evaluator,
            invalidated,
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
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date' , 'hospital_name')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->whereNull('tbl_form_pss.deleted_at')
            ->where('tbl_hospitals.hospital_name', 'LIKE', $request->hospital_name)
            ->whereRaw("
            CONCAT(
            tbl_form_pss.id, 
            patient_name,
            hospital_name,
            home_address,
            date,
            invalidated,
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
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date', 'hospital_name')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->whereNull('tbl_form_pss.deleted_at')
            ->where('tbl_hospitals.hospital_name', 'LIKE', $request->hospital_name)
            ->whereRaw("
            CONCAT(
            tbl_form_pss.id, 
            patient_name,
            hospital_name,
            home_address,
            date,
            invalidated,
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
    //DISPLAY OFFICES DROPDOWN
    public function display_offices(Request $request)
    {
        $offices = DB::table('tbl_offices')
            ->whereNull('tbl_offices.deleted_at')
            ->orderBy('office_name', 'ASC')
            ->get();
        return $offices;
    }
    //DISPLAY HOSPITALS
    public function display_hospitals(Request $request)
    {
        $hospitals = DB::table('tbl_hospitals')
            ->whereNull('tbl_hospitals.deleted_at')
            ->orderBy('hospital_name', 'ASC')
            ->get();
        return $hospitals;
    }
}
