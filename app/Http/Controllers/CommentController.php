<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormCSS;
use App\Models\FormPSS;

class CommentController extends Controller
{
    //DISPLAY VALUE tbl_form_css
    public function display_css(Request $request)
    {
        $total_count = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->where('tbl_form_css.deleted_at', null)
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->where('tbl_offices.office_name', 'LIKE', $request->office_name)
            //     ->whereRaw("
            // CONCAT(
            // tbl_form_css.id, 
            // office_name,
            // service_name,
            // name_evaluatee,
            // name_evaluator,
            // date
            // ) LIKE '%" . $request->search . "%'")
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
            ->where('tbl_form_css.deleted_at', null)
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->where('tbl_offices.office_name', 'LIKE', $request->office_name)
            // ->whereRaw("
            // CONCAT(
            // tbl_form_css.id, 
            // office_name,
            // service_name,
            // name_evaluatee,
            // name_evaluator,
            // date
            // ) LIKE '%" . $request->search . "%'")
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->orderBy('id', 'asc')
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //RESERVE CODE ONLY JUST IGNORE
    public function search_display_css(Request $request)
    {
        $total_count = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->where('tbl_form_css.deleted_at', null)
            ->where('tbl_form_css.date', 'like', '%' . $request->dates . '%')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
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
            ->where('tbl_form_css.deleted_at', null)
            ->where('tbl_form_css.date', 'like', '%' . $request->dates . '%')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->orderBy('id', 'asc')
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //DISPLAY tbl_form_pss
    public function display_pss(Request $request)
    {

        $total_count = DB::table('tbl_form_pss')
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_hospitals.hospital_name', 'LIKE', $request->hospital_name)
            //     ->whereRaw("
            // CONCAT(
            // tbl_form_pss.id, 
            // patient_name,
            // home_address,
            // date,
            // comments
            // ) LIKE '%" . $request->search . "%'")
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
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date', 'comments', 'comments_status')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_hospitals.hospital_name', 'LIKE', $request->hospital_name)
            // ->offset($offset)
            // ->limit($rowsperpage)
            // ->whereRaw("
            // CONCAT(
            // tbl_form_pss.id, 
            // patient_name,
            // home_address,
            // date,
            // comments
            // ) LIKE '%" . $request->search . "%'")
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //RESERVE CODE ONLY JUST IGNORE
    public function search_display_pss(Request $request)
    {
        $total_count = DB::table('tbl_form_pss')
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_form_pss.date', 'like', '%' . $request->dates . '%')
            ->where('tbl_hospitals.hospital_name', 'like', '%' . $request->hospital_name . '%')
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
            ->select('tbl_form_pss.id AS id', 'patient_name', 'home_address', 'date', 'comments', 'comments_status')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_form_pss.date', 'like', '%' . $request->dates . '%')
            ->where('tbl_hospitals.hospital_name', 'like', '%' . $request->hospital_name . '%')
            // ->offset($offset)
            // ->limit($rowsperpage)
            ->get();

        $myArray = array(
            array(
                "first_array" => $next,
                "last_array" => $totalpages
            )
        );
        return $myArray;
    }
    //ACTIVATE CSS
    public function activate_css(Request $request)
    {
        try {
            DB::beginTransaction();
            FormCSS::where('id', $request->id)->update([
                'comments_status' => '1'
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DEACTIVATE CSS
    public function deactivate_css(Request $request)
    {
        try {
            DB::beginTransaction();
            FormCSS::where('id', $request->id)->update([
                'comments_status' => '0'
            ]);
            DB::commit();
            return "Success";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //ACTIVATE PSS
    public function activate_pss(Request $request)
    {
        try {
            DB::beginTransaction();
            FormPSS::where('id', $request->idd)->update([
                'comments_status' => '1'
            ]);
            DB::commit();
            return "Success1";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //DEACTIVATE PSS
    public function deactivate_pss(Request $request)
    {
        try {
            DB::beginTransaction();
            FormPSS::where('id', $request->idd)->update([
                'comments_status' => '0'
            ]);
            DB::commit();
            return "Success2";
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
