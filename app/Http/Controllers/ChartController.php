<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    //
    public function count_survey()
    {
        /***
         * 
         * SELECT (count_form_pss+count_form_css) AS total_survey,count_form_pss,count_form_css FROM(
        SELECT 
        (SELECT COUNT(id)  FROM tbl_form_pss) AS count_form_pss,
        (SELECT COUNT(id)  FROM tbl_form_css) AS count_form_css
        )TB
         */
        //COUNT TOTAL ONLY THE CHART OF CSS AND PSS
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
    //COUNT TOTAL CSS ONLY
    public function monthly_css()
    {
        $currentYear = date('Y');
        $results = DB::select("
        SELECT *
        FROM (
            SELECT
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '01' AND DATE LIKE '%" . $currentYear . "%') AS jan,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '02' AND DATE LIKE '%" . $currentYear . "%') AS feb,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '03' AND DATE LIKE '%" . $currentYear . "%') AS march,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '04' AND DATE LIKE '%" . $currentYear . "%') AS april,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '05' AND DATE LIKE '%" . $currentYear . "%') AS may,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '06' AND DATE LIKE '%" . $currentYear . "%') AS june,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '07' AND DATE LIKE '%" . $currentYear . "%') AS july,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '08' AND DATE LIKE '%" . $currentYear . "%') AS aug,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '09' AND DATE LIKE '%" . $currentYear . "%') AS sep,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '10' AND DATE LIKE '%" . $currentYear . "%') AS OCT,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '11' AND DATE LIKE '%" . $currentYear . "%') AS novv,
            (SELECT COUNT(id) FROM tbl_form_css WHERE DATE_FORMAT(DATE, '%m') = '12' AND DATE LIKE '%" . $currentYear . "%') AS decc
        ) TB
     ");
        return $results;
    }

    public function prediction_css()
    {
        $currentYear = date('Y')-1;
     
        $results = DB::table(function ($query) {
            $query->select([
                    DB::raw('COUNT(id) AS cc_id'),
                    DB::raw('(SELECT office_name FROM tbl_offices WHERE id = tbl_form_css.office_id) AS office_name')
                ])
                ->from('tbl_form_css')
                ->where('DATE', 'LIKE', '%2023%')
                ->groupBy('office_id');
        }, 'tb1')
        ->orderByDesc('cc_id')
        ->limit(5)
        ->get();
        return $results;
    }

    //COUNT TOTAL PSS ONLY
    public function monthly_pss()
    {
        $currentYear = date('Y');
        $results = DB::select("
        SELECT *
        FROM (
            SELECT
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '01' AND DATE LIKE '%" . $currentYear . "%') AS jan,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '02' AND DATE LIKE '%" . $currentYear . "%') AS feb,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '03' AND DATE LIKE '%" . $currentYear . "%') AS march,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '04' AND DATE LIKE '%" . $currentYear . "%') AS april,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '05' AND DATE LIKE '%" . $currentYear . "%') AS may,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '06' AND DATE LIKE '%" . $currentYear . "%') AS june,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '07' AND DATE LIKE '%" . $currentYear . "%') AS july,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '08' AND DATE LIKE '%" . $currentYear . "%') AS aug,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '09' AND DATE LIKE '%" . $currentYear . "%') AS sep,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '10' AND DATE LIKE '%" . $currentYear . "%') AS oct,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '11' AND DATE LIKE '%" . $currentYear . "%') AS novv,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '12' AND DATE LIKE '%" . $currentYear . "%') AS decc
        ) TB
     ");
        return $results;
    }

    public function prediction_pss()
    {
        $currentYear = date('Y')-1;
        $results = DB::select("
        SELECT *
        FROM (
            SELECT
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '01' AND DATE LIKE '%" . $currentYear . "%') AS jan,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '02' AND DATE LIKE '%" . $currentYear . "%') AS feb,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '03' AND DATE LIKE '%" . $currentYear . "%') AS march,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '04' AND DATE LIKE '%" . $currentYear . "%') AS april,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '05' AND DATE LIKE '%" . $currentYear . "%') AS may,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '06' AND DATE LIKE '%" . $currentYear . "%') AS june,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '07' AND DATE LIKE '%" . $currentYear . "%') AS july,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '08' AND DATE LIKE '%" . $currentYear . "%') AS aug,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '09' AND DATE LIKE '%" . $currentYear . "%') AS sep,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '10' AND DATE LIKE '%" . $currentYear . "%') AS oct,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '11' AND DATE LIKE '%" . $currentYear . "%') AS novv,
            (SELECT COUNT(id) FROM tbl_form_pss WHERE DATE_FORMAT(DATE, '%m') = '12' AND DATE LIKE '%" . $currentYear . "%') AS decc
        ) TB
     ");
        return $results;
    }
}
