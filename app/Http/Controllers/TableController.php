<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormCSS;
use App\Models\FormPSS;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    //
    public function view_css($id)
    {

        $result_invalidated = DB::table('tbl_form_css')
        ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
        ->select('tbl_form_css.*', 'tbl_offices.office_name')
        ->where('tbl_form_css.id', $id)
        ->get();
        
        if($result_invalidated[0]->invalidated == "yes"){
            $result = DB::table('tbl_form_css')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->select('tbl_form_css.*','tbl_offices.office_name')
            ->where('tbl_form_css.id', $id)
            ->get();
        }
        else{
            $result = DB::table('tbl_form_css')
            ->join('tbl_services', 'tbl_form_css.services_id', '=', 'tbl_services.id')
            ->join('tbl_offices', 'tbl_form_css.office_id', '=', 'tbl_offices.id')
            ->select('tbl_form_css.*', 'tbl_services.service_name', 'tbl_offices.office_name')
            ->where('tbl_form_css.id', $id)
            ->get();
        }
       
        $data = [
            'results' => $result[0],
        ];
        return view('table_css', $data);
    }
    public function view_pss($id)
    {
        $results = DB::table('tbl_form_pss')
            ->select('tbl_hospitals.hospital_name', 'tbl_form_pss.*')
            ->join('tbl_hospitals', 'tbl_form_pss.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_form_pss.id', '=', $id)
            ->get();

        $data = [
            'results' => $results[0],
        ];
        return view('table_pss', $data);
    }
}
