<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;
use PhpOffice\PhpWord\Element\Header;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Chart;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\Drawing;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WordController extends Controller
{
    //
    public function generateWordCSS($monthString, $yearString, $month, $office_name)
    {
        //QUERY
        $monthYearString = $yearString . "-" . $monthString;
        $yy = $yearString;
        $prev_y = $yy-1;

        $yyString = Carbon::parse($monthYearString);
        $mm_string = $yyString->formatLocalized('%B %Y'); // Converts date to "Wednesday, 15 February 2023"

        // $monthString = '05';
        // $yearString = '2023';
        // $office_name = 'Laguna Provincial Library(LIBRARY)';
        // return$monthYearString;

        $result_offices = DB::table('tbl_offices')
            ->select('office_name', 'id')
            ->where('office_name', $office_name)
            ->get();

        $result_managers = DB::table('tbl_managers')
            ->select('manager_name', 'id','first_name','middle_name','last_name','suffix')
            ->where('office_id', $result_offices[0]->id)
            ->get();

            // $manager_lastname = last(explode(" ", $result_managers[0]->manager_name));
            // $manager_suffix = head(explode(" ", $result_managers[0]->manager_name));
            // $manager_final_lastname = $manager_suffix." ".$manager_lastname;
            $manager_lastname = $result_managers[0]->last_name;
            $manager_suffix = $result_managers[0]->suffix;
            $manager_final_lastname = $manager_suffix." ".$manager_lastname;

            $countInvalidated = DB::table('tbl_form_css')
            ->where('invalidated', 'yes')
            ->whereNull('deleted_at')
            ->where('office_id', $result_offices[0]->id)
            ->where('date', 'LIKE', '%' . $monthYearString . '%')
            ->count();

            // $invalidated = $invalidatedCount[0]->count_invalidated;
            $invalidated = $countInvalidated;

        $currentDate = Carbon::now()->formatLocalized('%B %d, %Y');

        $date = Carbon::createFromFormat('Y-m', $monthYearString);
        $monthYear = $date->format('F Y');

        $date1 = Carbon::createFromFormat('m', '05');
        $month = $date1->format('F');

        $prevmonthYearString = $date->subMonth();
        $prevmonthYear = $prevmonthYearString->format('F Y');

        $results = DB::select("SELECT
        *,
        (
        SELECT service_name
        FROM tbl_services
        WHERE id = tb2.service_id
        )AS service_name,
        TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
        FROM(
        SELECT
        tbl_form_css.id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
        COUNT(*) AS total_respondents,
        TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
        TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
        TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
        TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
        TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
        FROM
        tbl_form_css
        JOIN
            (
             SELECT 0 AS digit
             UNION ALL
             SELECT 1 UNION ALL
             SELECT 2 UNION ALL
             SELECT 3 UNION ALL
             SELECT 4 UNION ALL
             SELECT 5 UNION ALL
             SELECT 6 UNION ALL
             SELECT 7 UNION ALL
             SELECT 8 UNION ALL
             SELECT 9 UNION ALL
             SELECT 10 UNION ALL
             SELECT 11 UNION ALL
             SELECT 12 UNION ALL
             SELECT 13 UNION ALL
             SELECT 14 UNION ALL
             SELECT 15 UNION ALL
             SELECT 16 UNION ALL
             SELECT 17 UNION ALL
             SELECT 18 UNION ALL
             SELECT 19 UNION ALL
             SELECT 20
             ) n
            ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
            WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != '' AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%" . $monthYearString . "%'
        GROUP BY
        service_id
        )tb2");

        if (empty($results)) {
            return "
            <script src='../../../../../js/jquery-3.6.0.min.js'></script>
            <script src='../../../../../js/sweetalert2.js'></script>
            <script>
            $(document).ready(()=> {
            // jQuery code here
            Swal.fire(
            'No data!',
            'No Records Found',
            'error'
            )
            setTimeout(()=> {
            window.history.back();
            }, 3500);

            });
            </script>";
        } else {


            $collection_services = Collection::make($results);
            // Number of equal parts to divide the collection

            $services_array = $collection_services->toArray();

            if (empty($services_array)) {
                // Array is empty
                $chunkedArray_services = array();
            } else {
                // Array is not empty
                if (count($services_array) <= 12) {
                    $services_parts = 1;
                    $chunkedArray_services = array_chunk($services_array, ceil(count($services_array) / $services_parts)) ?? array("No available services");
                } else {
                    $services_parts = 2;
                    $chunkedArray_services = array_chunk($services_array, ceil(count($services_array) / $services_parts)) ?? array("No available services");
                }
            }


            $attributes = [
                'delivery_service',
                'communications',
                'quality_staff',
                'quality_work',
                'problem_solving',
                'average',
            ];

            $averages = [];

            foreach ($attributes as $attribute) {
                $values = array_map(fn ($item) => $item->{$attribute}, $results);
                $averages[$attribute] = array_sum($values) / count($values);
            }

            $arr_total_respondents = array_map(fn ($item) =>

            $item->total_respondents, $results);

            // Access the individual averages
            $overall_delivery_service = number_format($averages['delivery_service'], 2);
            $overall_communications =  number_format($averages['communications'], 2);
            $overall_quality_staff =  number_format($averages['quality_staff'], 2);
            $overall_quality_work =  number_format($averages['quality_work'], 2);
            $overall_problem_solving =  number_format($averages['problem_solving'], 2);
            $overall_average =  $averages['average'];


            if ($overall_average >= 1 && $overall_average < 2) {
                $degree_satisfaction_remarks = "Not Satisfied";
                $overall_performance_remarks = "Poor";
            } 
            elseif ($overall_average >= 2 && $overall_average < 3) {
                $degree_satisfaction_remarks = "Slightly Satisfied";
                $overall_performance_remarks = "Fair";
            } 
            elseif ($overall_average >= 3 && $overall_average < 4) {
                $degree_satisfaction_remarks = "Satisfied";
                $overall_performance_remarks = "Good";
            } 
            elseif ($overall_delivery_service == 4 && $overall_communications == 4 && $overall_quality_staff == 4 && $overall_quality_work == 4 && $overall_problem_solving == 4) {
                $degree_satisfaction_remarks = "Very Satisfied";
                $overall_performance_remarks = "Very Good";
            } 
            elseif ($overall_average >= 4) {
                $degree_satisfaction_remarks = "Very Satisfied";
                $overall_performance_remarks = "Very Good";
            } 
            else {
            }

            //CSAT RATINGS
            /**temporary the query is long under study of average of  */

            $results_jan = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-01%'
            GROUP BY
            service_id
            )tb2");

            $results_feb = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-02%'
            GROUP BY
            service_id
            )tb2");

            $results_march = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-03%'
            GROUP BY
            service_id
            )tb2");

            $results_april = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-04%'
            GROUP BY
            service_id
            )tb2");

            $results_may = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-05%'
            GROUP BY
            service_id
            )tb2");

            $results_june = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-06%'
            GROUP BY
            service_id
            )tb2");

            $results_july = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-07%'
            GROUP BY
            service_id
            )tb2");

            $results_august = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-08%'
            GROUP BY
            service_id
            )tb2");

            $results_sept = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-09%'
            GROUP BY
            service_id
            )tb2");

            $results_oct = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-10%'
            GROUP BY
            service_id
            )tb2");

            $results_nov = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-11%'
            GROUP BY
            service_id
            )tb2");

            $results_dec = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-12%'
            GROUP BY
            service_id
            )tb2");

            $results_dec = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."-12%'
            GROUP BY
            service_id
            )tb2");

            $results_prev_dec = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$prev_y."-12%'
            GROUP BY
            service_id
            )tb2");

            $results_average = DB::select("SELECT
            *,
            (
            SELECT service_name
            FROM tbl_services
            WHERE id = tb2.service_id
            )AS service_name,
            TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
            FROM(
            SELECT
            tbl_form_css.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(services_id, ',', n.digit + 1), ',', -1) AS service_id,
            COUNT(*) AS total_respondents,
            TRUNCATE(COALESCE((AVG(tbl_form_css.radio_1+tbl_form_css.radio_2)/2),0),2) AS delivery_service,
            TRUNCATE(COALESCE((AVG(radio_3+radio_4+radio_5)/3),0),2) AS communications,
            TRUNCATE(COALESCE((AVG(radio_6+radio_7+radio_8+radio_9)/4),0),2) AS quality_staff,
            TRUNCATE(COALESCE((AVG(radio_10+radio_11)/2),0),2) AS quality_work,
            TRUNCATE(COALESCE((AVG(radio_12)/1),0),2) AS problem_solving
            FROM
            tbl_form_css
            JOIN
                (
                 SELECT 0 AS digit
                 UNION ALL
                 SELECT 1 UNION ALL
                 SELECT 2 UNION ALL
                 SELECT 3 UNION ALL
                 SELECT 4 UNION ALL
                 SELECT 5 UNION ALL
                 SELECT 6 UNION ALL
                 SELECT 7 UNION ALL
                 SELECT 8 UNION ALL
                 SELECT 9 UNION ALL
                 SELECT 10 UNION ALL
                 SELECT 11 UNION ALL
                 SELECT 12 UNION ALL
                 SELECT 13 UNION ALL
                 SELECT 14 UNION ALL
                 SELECT 15 UNION ALL
                 SELECT 16 UNION ALL
                 SELECT 17 UNION ALL
                 SELECT 18 UNION ALL
                 SELECT 19 UNION ALL
                 SELECT 20
                 ) n
                ON LENGTH(services_id) - LENGTH(REPLACE(services_id, ',', '')) >= n.digit
                WHERE tbl_form_css.office_id = " . $result_offices[0]->id . " AND tbl_form_css.services_id != 'invalidated' AND DATE LIKE '%".$yy."%'
            GROUP BY
            service_id
            )tb2");

            $averages_chart2 = array(array(
            'JANUARY'=> $results_jan[0]->average ?? 0,
            'FEBRUARY'=> $results_feb[0]->average ?? 0,
            'MARCH'=> $results_march[0]->average ?? 0,
            'APRIL'=> $results_april[0]->average ?? 0,
            'MAY'=> $results_may[0]->average ?? 0,
            'JUNE'=> $results_june[0]->average ?? 0,
            'JULY'=> $results_july[0]->average ?? 0,
            'AUGUST'=> $results_august[0]->average ?? 0,
            'SEPTEMBER'=> $results_sept[0]->average ?? 0,
            'OCTOBER'=> $results_oct[0]->average ?? 0,
            'NOVEMBER'=> $results_nov[0]->average ?? 0,
            'DECEMBER'=> $results_dec[0]->average ?? 0,
            'PREV_DEC'=> $results_prev_dec[0]->average ?? 0,
            'AVERAGE'=> $results_average[0]->average ?? 0,
             ));

            // $averages_chart2[0]['PREV_DEC'] = $results_prev_dec[0]->average ?? 0;

            // return $averages_chart2;

            $finalComments = DB::table(function ($query) use ($office_name, $monthYearString) {
                $query->select(
                        DB::raw('IF(COUNT(*) = 1, tbl_form_css.comments, CONCAT(tbl_form_css.comments, "(", COUNT(*), "X)")) AS final_comments'),
                        DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_form_css.services_id, ",", n.digit + 1), ",", -1) AS service_id')
                    )
                    ->from('tbl_form_css')
                    ->join(DB::raw('(SELECT 0 AS digit
                         UNION ALL
                         SELECT 1 UNION ALL
                         SELECT 2 UNION ALL
                         SELECT 3 UNION ALL
                         SELECT 4 UNION ALL
                         SELECT 5 UNION ALL
                         SELECT 6 UNION ALL
                         SELECT 7 UNION ALL
                         SELECT 8 UNION ALL
                         SELECT 9 UNION ALL
                         SELECT 10 UNION ALL
                         SELECT 11 UNION ALL
                         SELECT 12 UNION ALL
                         SELECT 13 UNION ALL
                         SELECT 14 UNION ALL
                         SELECT 15 UNION ALL
                         SELECT 16 UNION ALL
                         SELECT 17 UNION ALL
                         SELECT 18 UNION ALL
                         SELECT 19 UNION ALL
                         SELECT 20) AS n'), function ($join) {
                        $join->on(DB::raw('LENGTH(tbl_form_css.services_id) - LENGTH(REPLACE(tbl_form_css.services_id, ",", ""))'), '>=', DB::raw('n.digit'));
                    })
                    ->where('tbl_form_css.office_id', function ($query) use ($office_name) {
                        $query->select('id')
                            ->from('tbl_offices')
                            ->where('office_name', 'LIKE', '%' . $office_name . '%');
                    })
                    ->where('DATE', 'LIKE', '%' . $monthYearString . '%')
                    ->groupBy('service_id', 'comments');
            }, 'tb1')
            ->where('tb1.final_comments', 'NOT LIKE', '%N/A%')
            ->where('tb1.final_comments', 'NOT LIKE', '%None%')
            ->get();

    // return$finalComments;

            $collection_comments = array();

            $collection_service_id = collect($finalComments);

            $servicesIds_arr = $collection_service_id->pluck('services_id')->all();

            $collection_final_comments = collect($finalComments);



            foreach ($results as $keys => $value) {

                $result_final_comments_arr = $collection_final_comments->filter(function ($item) use ($value) {
                    if ($item->service_id == $value->service_id) {
                        return $item->final_comments;
                    }
                })->values();
                $wew = array();

                $output = array();

                foreach ($result_final_comments_arr as $key => $values) {
                    $output[] = [$values->final_comments];
                }




                $collection_comments[$keys] = array(
                    "service_name" => $value->service_name,
                    "comment" =>  $output,
                    "total_count" => count($result_final_comments_arr) + 1,
                );
            }



            $limit = 35;

            $dividedData = [];

            foreach ($collection_comments as $keys => $item) {
                $total_count = $item["total_count"];
                if ($item["total_count"] > $limit) {

                    while ($total_count > 0) {
                        $chunk_count = min($total_count, $limit);
                        $item_copy = $item;
                        $item_copy["total_count"] = $chunk_count;
                        $dividedData[$keys][0] = $item_copy;
                        $total_count -= $chunk_count;
                    }
                } else {
                    $dividedData[0][$keys] = $item;
                }
            }


            // return $comments;

            $query_chart1 = DB::table('tbl_form_css')
                ->selectRaw("(SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-06%' AND office_id = (SELECT id FROM tbl_offices WHERE id = tbl_form_css.office_id)) AS chart1_prev")
                ->selectRaw("(SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-06%' AND office_id = (SELECT id FROM tbl_offices WHERE id = tbl_form_css.office_id)) AS chart1_current")
                ->limit(1)
                ->get();

            $query = "
        SELECT *, (january + february + march + april + may + june + july + august + september + october + november + december) AS total
        FROM (
            SELECT
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-01%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS january,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-02%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS february,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-03%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS march,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-04%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS april,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-05%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS may,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-06%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS june,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-07%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS july,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-08%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS august,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-09%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS september,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-10%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS october,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-11%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS november,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$yy-12%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS december,
                (SELECT COUNT(id) FROM tbl_form_css WHERE DATE LIKE '%$prev_y-12%' AND office_id = (SELECT id FROM tbl_offices WHERE office_name = '$office_name')) AS prev_dec
        ) tb1
        LIMIT 1;
    ";

            $result_chart = DB::select($query);

            $results_chart_settings = DB::table('tbl_chart_settings_css')
                ->get();
            // return "wew";
            if($invalidated == 0){
                if ($degree_satisfaction_remarks == 'Very Satisfied') {
                    $degree_satisfaction_remarks1 = "Maintain the $overall_performance_remarks Service performance of the department by making the customers Very Satisfied in the next cycles";
                    $degree_satisfaction_remarks2 = "Recognize the $overall_performance_remarks personnel with their effort of providing satisfactory services to the customers during department meeting";
                } else {
                    $degree_satisfaction_remarks1 = "Improve the $overall_performance_remarks Service performance of the department by making the customers Very Satisfied in the next cycles";
                    $degree_satisfaction_remarks2 = "Encourage the personnel to providing satisfactory services to the customers during department meeting";

                }
            }
            else{
                if ($degree_satisfaction_remarks == 'Very Satisfied') {
                    $degree_satisfaction_remarks1 = "Maintain the $overall_performance_remarks Service performance of the department by making the customers Very Satisfied in the next cycles";
                    $degree_satisfaction_remarks2 = "Recognize the $overall_performance_remarks personnel with their effort of providing satisfactory services to the customers during department meeting";
                } else {
                    $degree_satisfaction_remarks1 = "Improve the $overall_performance_remarks Service performance of the department by making the customers Very Satisfied in the next cycles";
                    $degree_satisfaction_remarks2 = "Encourage the personnel to providing satisfactory services to the customers during department meeting";

                }
            }


            Settings::setOutputEscapingEnabled(true);
            $phpWord = new PhpWord();
            $template = new TemplateProcessor('documents/CSS_NEW.docx');

            //SERVICES
            $section = $phpWord->addSection();

            // Define the table style
            $styleTable = array(
                'borderSize' => 5,
                'borderColor' => '000000',
                'spaceBefore' => 1,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 1,
                'gridSpan' => 5,
                'space' => array('line' => 1000)
            );


            $table_font_head_style = array(
                'size' => 10,
                'bold' => true,
                'name' => 'Calibri(Body)',
                'spaceBefore' => 0,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 0,
            );

            $table_font_body_style = array(
                'size' => 10,
                'bold' => false,
                'name' => 'Calibri(Body)',
                'space' => array('line' => 1000),
                'spaceBefore' => 0,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 0,
            );

            $fixedSpacingStyle = array(
                'spaceBefore' => 0,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 0,   // Set the spacing after the paragraph to 0
            );


            $phpWord->addTableStyle('myTable', $styleTable);
            $table = $section->addTable('myTable');

            $table->addRow();
            $table->addCell(
                4000,
                array(
                    'borderSize' => 5,
                    'borderColor' => '000000',
                    'spaceBefore' => 0,  // Set the spacing before the paragraph to 0
                    'spaceAfter' => 0,
                    'gridSpan' => 6
                )
            )->addText('Services Rendered', $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText('Total No. of Respondents', $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText('Delivery of Services', $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText('Communication', $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText('Quality of Staff', $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText('Quality of Work', $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText('Problem Solving', $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText('Average', $table_font_head_style, array('align' => 'center'));

            foreach ($results as $key => $item) {
                $table->addRow();
                $table->addCell(4000,   array(
                    'borderSize' => 5,
                    'borderColor' => '000000',
                    'spaceBefore' => 0,
                    'spaceAfter' => 0,
                    'gridSpan' => 6
                ))->addText($item->service_name, $table_font_body_style, array('align' => 'left'));
                $table->addCell(1000, $styleTable)->addText($item->total_respondents, $table_font_body_style, array('align' => 'center'));
                $table->addCell(1000, $styleTable)->addText(number_format((float)$item->delivery_service, 2, '.', ''), $table_font_body_style, array('align' => 'center'));
                $table->addCell(1000, $styleTable)->addText(number_format((float)$item->communications, 2, '.', ''), $table_font_body_style, array('align' => 'center'));
                $table->addCell(1000, $styleTable)->addText(number_format((float)$item->quality_staff, 2, '.', ''), $table_font_body_style, array('align' => 'center'));
                $table->addCell(1000, $styleTable)->addText(number_format((float)$item->quality_work, 2, '.', ''), $table_font_body_style, array('align' => 'center'));
                $table->addCell(1000, $styleTable)->addText(number_format((float)$item->problem_solving, 2, '.', ''), $table_font_body_style, array('align' => 'center'));
                $table->addCell(1000, $styleTable)->addText(number_format((float)$item->average, 2, '.', ''), $table_font_head_style, array('align' => 'center'));
            }

            $table->addRow();
            $table->addCell(4000, array(
                'borderSize' => 5,
                'borderColor' => '000000',
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'gridSpan' => 6
            ))->addText('Overall Result', $table_font_head_style, array('align' => 'left'));
            $table->addCell(1000, $styleTable)->addText(array_sum($arr_total_respondents), $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText(number_format((float)$overall_delivery_service, 2, '.', ''), $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText(number_format((float)$overall_communications, 2, '.', ''), $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText(number_format((float)$overall_quality_staff, 2, '.', ''), $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText(number_format((float)$overall_quality_work, 2, '.', ''), $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText(number_format((float)$overall_problem_solving, 2, '.', ''), $table_font_head_style, array('align' => 'center'));
            $table->addCell(1000, $styleTable)->addText(number_format((float)$overall_average, 2, '.', ''), $table_font_head_style, array('align' => 'center'));
            $table->addRow();

            $fancyTableFontStyle = ['bold' => true, 'size' => 10];

            $table->addCell(11000, array(
                'borderLeftSize' => 5,
                'borderLeftColor' => '000000',
                'borderRightSize' => 5,
                'borderRightColor' => '000000',
                'borderTopSize' => 5,
                'borderTopColor' => '000000',
                'borderBottomSize' => 5,
                'borderBottomColor' => '000000',
                'gridSpan' => 41
            ))->addText('Comments', $table_font_head_style, array('align' => 'center'));

            // return empty($dividedData);

            foreach ($dividedData as $keys1 => $comment_items_1) {

                foreach ($comment_items_1 as $keys2 => $comment_items_2) {

                    if (empty($comment_items_2['comment'])) {
                        $service_name = "";
                        $table->addRow();
                        $table->addCell(11000, array(
                            'gridSpan' => 41,
                            'bold' => true,
                            'borderLeftSize' => 1,
                            'borderLeftColor' => '000000',
                            'borderRightSize' => 1,
                            'borderRightColor' => '000000',
                            'borderTopSize' => 1,
                            'borderTopColor' => 'white',
                            'borderBottomSize' => 0,
                            'borderBottomColor' => '000000',
                        ))->addText($service_name, $fancyTableFontStyle);
                        break;
                    } else {
                        $service_name = $dividedData[$keys1][$keys2]['service_name'];
                        $table->addRow();
                        $table->addCell(11000, array(
                            'gridSpan' => 41,
                            'bold' => true,
                            'borderLeftSize' => 1,
                            'borderLeftColor' => '000000',
                            'borderRightSize' => 1,
                            'borderRightColor' => '000000',
                            'borderTopSize' => 1,
                            'borderTopColor' => 'white',
                            'borderBottomSize' => 0,
                            'borderBottomColor' => '000000',
                        ))->addText($service_name, $fancyTableFontStyle);
                    }
             
                        foreach ($comment_items_2['comment'] as $keys3 => $comment_items_3) {
                            foreach ($comment_items_3 as $keys3 => $comment_items_4) {  
                                $table->addRow();
                                $table->addCell(11000, array(
                                    'gridSpan' => 41,
                                    'borderLeftSize' => 1,
                                    'borderLeftColor' => '000000',
                                    'borderRightSize' => 1,
                                    'borderRightColor' => '000000',
                                    'borderTopSize' => 1,
                                    'borderTopColor' => 'white',
                                    'borderBottomSize' => 0,
                                    'borderBottomColor' => '000000',
                                ))->addListItem($comment_items_4);
                               
                            }
                        }
             
                }
            }

            $template->cloneBlock('myTable', 2, true, true);
            $template->setComplexBlock('services', $table);

            $chart_value_arr1 = array_map(fn ($item) =>
            [
                $item->january,
                $item->february,
                $item->march,
                $item->april,
                $item->may,
                $item->june,
                $item->july,
                $item->august,
                $item->september,
                $item->october,
                $item->november,
                $item->december,
                $item->prev_dec,
                $item->total
            ], $result_chart);

            // return$result_chart;


            $chart_value_arr2 = array_map(fn ($item) =>
            [
                number_format((float)$item['JANUARY'], 2, '.', ''),
                number_format((float)$item['FEBRUARY'], 2, '.', ''),
                number_format((float)$item['MARCH'], 2, '.', ''),
                number_format((float)$item['APRIL'], 2, '.', ''),
                number_format((float)$item['MAY'], 2, '.', ''),
                number_format((float)$item['JUNE'], 2, '.', ''),
                number_format((float)$item['JULY'], 2, '.', ''),
                number_format((float)$item['AUGUST'], 2, '.', ''),
                number_format((float)$item['SEPTEMBER'], 2, '.', ''),
                number_format((float)$item['OCTOBER'], 2, '.', ''),
                number_format((float)$item['NOVEMBER'], 2, '.', ''),
                number_format((float)$item['DECEMBER'], 2, '.', ''),
                number_format((float)$item['PREV_DEC'], 2, '.', ''),
                number_format((float)$item['AVERAGE'], 2, '.', ''),
            ], $averages_chart2);

            $chart_name_arr1 = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec',
                'PREV_DEC',
                'Total',
            ];

            $chart_name_arr2 = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec',
                'PREV_DEC',
                'Average',
            ];

            $rr_month1 = 12 - $monthString;
            array_splice($chart_name_arr1, $monthString, $rr_month1);
            array_splice($chart_value_arr1[0], $monthString, $rr_month1);

            array_splice($chart_name_arr2, $monthString, $rr_month1);
            array_splice($chart_value_arr2[0], $monthString, $rr_month1);

            if($monthString == 01){
                $chart_name_arr1 = array_reverse(array_filter($chart_name_arr1, function($month) {
                    return $month !== "Total";
                }));

                $chart_name_arr2 = array_reverse(array_filter($chart_name_arr2, function($month) {
                    return $month !== "Average";
                }));

                $chart_value_arr1 =  array_reverse(array_values(array_filter($chart_value_arr1[0], function($value, $index) {
                    return $index !== 2;
                }, ARRAY_FILTER_USE_BOTH)));

                $chart_value_arr2 =  array_reverse(array_values(array_filter($chart_value_arr2[0], function($value, $index) {
                    return $index !== 2;
                }, ARRAY_FILTER_USE_BOTH)));

                $series1 = $chart_value_arr1;
                $series2 = $chart_value_arr2;
                $csa_rating = $chart_value_arr2;

                $chart_name_arr1[0] = "DEC ${prev_y}";
                $chart_name_arr1[1] = "JAN ${yy}";

                $chart_name_arr2[0] = "DEC ${prev_y}";
                $chart_name_arr2[1] = "JAN ${yy}";

                if (count($chart_name_arr1) == 1) {
                    array_unshift($chart_value_arr1, 0);
                    array_unshift($chart_name_arr1, "DECEMBER");
                    $month_from1 = $chart_name_arr1[0];
                    $month_to1 = $chart_name_arr1[count($chart_name_arr1) - 1];
                } else {
                    $month_from1 = $chart_name_arr1[0];
                    $month_to1 = $chart_name_arr1[count($chart_name_arr1) - 1];
                }

                if (count($chart_name_arr2) == 1) {
                    array_unshift($chart_value_arr2, 0);
                    array_unshift($chart_name_arr2, "DECEMBER");
                    $month_from2 = $chart_name_arr2[0];
                    $month_to2 = $chart_name_arr2[count($chart_name_arr2) - 1];
                } else {
                    $month_from2 = $chart_name_arr2[0]." ".$prev_y;
                    $month_to2 = $chart_name_arr2[count($chart_name_arr2) - 1];
                }

                $result_csa_rating = implode(" and ", [$csa_rating[1]]);

            }
            else{

                $chart_name_arr1 = array_values(array_filter($chart_name_arr1, function($month) {
                    return $month !== "PREV_DEC";
                }));

                $chart_name_arr2 = array_values(array_filter($chart_name_arr2, function($month) {
                    return $month !== "PREV_DEC";
                }));
                $BABY1 = count($chart_value_arr1[0]);
                $BABY2 = count($chart_value_arr2[0]);
                // return count($chart_value_arr1[0]);
                $chart_value_arr1 =  array_values(array_filter($chart_value_arr1[0], function($value, $index) use ($BABY1){
                    return $index !== $BABY1 - 2;
                }, ARRAY_FILTER_USE_BOTH));

                $chart_value_arr2 =  array_values(array_filter($chart_value_arr2[0], function($value, $index) use ($BABY2){
                    return $index !== $BABY2 - 2;
                }, ARRAY_FILTER_USE_BOTH));

              
                $series1 = $chart_value_arr1;
                $series2 = $chart_value_arr2;
                $csa_rating = $chart_value_arr2;

                if (count($chart_name_arr1) == 1) {
                    array_unshift($chart_value_arr1, 0);
                    array_unshift($chart_name_arr1, "DECEMBER");
                    $month_from1 = $chart_name_arr1[count($chart_name_arr1) - 1]." ".$yy;
                    $month_to1 = $chart_name_arr1[count($chart_name_arr1) - 2]." ".$yy;
              
                } else {
                    $month_from1 = $chart_name_arr1[0]." ".$yy;
                    $month_to1 = $chart_name_arr1[count($chart_name_arr1) - 1]." ".$yy;
                }
                // return$month_to1;
               
                if (count($chart_name_arr2) == 1) {
                    array_unshift($chart_value_arr2, 0);
                    array_unshift($chart_name_arr2, "DECEMBER");
                    $month_from2 = $chart_name_arr2[0]." ".$yy;
                    $month_to2 = $chart_name_arr2[count($chart_name_arr2) - 1]." ".$yy;
                } else {
                    $month_from2 = $chart_name_arr2[0]." ".$yy;
                    $month_to2 = $chart_name_arr2[count($chart_name_arr2) - 1]." ".$yy;
                }
         
                array_pop($csa_rating);
                $result_csa_rating = implode(" and ", $csa_rating);
                // return$result_csa_rating;
            }



            // return $result_csa_rating;

            $results_chart_settings = DB::table('tbl_chart_settings_css')
                ->pluck('chart_name');

            $chart1 = new Chart("column", $chart_name_arr1, $series1);
            // $chart1->addSeries($categories, $series1);

            $chart1->getStyle()
                ->setWidth(Converter::inchToEmu(4.0))
                ->setHeight(Converter::inchToEmu(1.28))
                ->setShowGridX(false)
                ->setShowGridY(false)
                ->setShowAxisLabels(true)
                ->setShowLegend(false)
                ->setLegendPosition("l");

            $chart1->getStyle()->setDataLabelOptions([
                'showVal' => true,
                'showCatName' => false,
            ]);

            $chart1->getStyle()->getDataLabelOptions();
            $chart1->getStyle()->setValueLabelPosition('none');

            $chart1->getStyle()
                ->setColors(
                    array(
                        'FF0000',
                        '00FF00',
                        '0000FF',
                        'FFFF00',
                        'FF00FF',
                        '00FFFF',
                        '800080',
                        'A52A2A',
                        'FFC0CB',
                        'FFD700',
                        'C0C0C0',
                        'E6E6FA',
                        '4B0082'
                    )
                );

            $template->setChart("chart1", $chart1);
            $chart2 = new Chart(
                "column",
                $chart_name_arr2,
                $series2
            );
            // return $series2;
            // $chart2->addSeries($categories, $series1);

            $chart2->getStyle()
                ->setWidth(Converter::inchToEmu(4.0))
                ->setHeight(Converter::inchToEmu(1.28))
                ->setShowGridX(false)
                ->setShowGridY(false)
                ->setShowAxisLabels(true)
                ->setShowLegend(false)
                ->setLegendPosition('l');

            $chart2->getStyle()->setDataLabelOptions([
                'showVal' => true,
                'showCatName' => false,
            ]);

            $chart2->getStyle()->setValueLabelPosition('none');
            $chart2->getStyle()
                ->setColors(
                    array(
                        'FF0000',
                        '00FF00',
                        '0000FF',
                        'FFFF00',
                        'FF00FF',
                        '00FFFF',
                        '800080',
                        'A52A2A',
                        'FFC0CB',
                        'FFD700',
                        'C0C0C0',
                        'E6E6FA',
                        '4B0082'
                    )
                );
            $words = explode(' ', $result_managers[0]->manager_name);
            $manager_suffix = "Ms";
            $manager_firstname = $words[0];
            $manager_lastname = $manager_suffix . " " . end($words);
            
            $styleTable = array(
                'spaceBefore' => 1,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 1,
                'gridSpan' => 1,
                'space' => array('line' => 1000)
            );
            
            $table = new Table(['borderSize' => 20, 'borderColor' => 'white', 'width' => 10000, 'unit' => TblWidth::TWIP]);
            $table->addRow();
            $table->addCell(100,$styleTable)->addListItem('religiously conduct CSS in every service encounter and improve customer participation by increasing the number of respondents not just through the paper and pen format but also with the online CSS.');
            $table->addRow();
            $table->addCell(100,$styleTable)->addListItem($degree_satisfaction_remarks1);
            if($invalidated > 0){
                $table->addRow();
                $table->addCell(100)->addListItem($degree_satisfaction_remarks2);
            }
            $invalidated_words = $this->numberToWord($invalidated);
            $table->addRow();
            $table->addCell(100)->addListItem('use the analytics provided to track the departments performance and ensure that the number of respondents keep increasing without compromising quality service delivery.');
            $template->setComplexBlock('degree_text', $table);

            $invalidated_text =  ($invalidated > 0 ) ? "${invalidated_words} (${invalidated}) accomplished CSQ was invalidated as the requested service was not identified on the form." : "";
            $template->setValue('invalidated', $invalidated_text);

            $template->setChart("chart2", $chart2);
            $template->setValue('date_issued', $currentDate);
            $template->setValue('manager', $result_managers[0]->manager_name);
            $template->setValue('manager_lastname', $manager_final_lastname);
            $template->setValue('office_name', $office_name);
            $template->setValue('total_respondents', array_sum($arr_total_respondents));
            $template->setValue('total_respondents_words', $this->numberToWord(array_sum($arr_total_respondents)));
            $template->setValue('current_month', $mm_string);
            $template->setValue('degree_satisfaction_remarks', $degree_satisfaction_remarks);
            $template->setValue('overall_performance_remarks', $overall_performance_remarks);
            $template->setValue('degree_satisfaction_remarks1', $degree_satisfaction_remarks1);
            $template->setValue('degree_satisfaction_remarks2',$degree_satisfaction_remarks2);
            $template->setValue('month_from1', $month_from1);
            $template->setValue('month_to1', $month_to1);
            $template->setValue('month_from2', $month_from1);
            $template->setValue('month_to2', $month_to1);
            $template->setValue('yearString', $yearString);
            $template->setValue('csa_rating', $result_csa_rating);

            $template->saveAs('documents/output/CSS_' . $yearString . '_' . $office_name . '.docx');
            return response()->download('documents/output/CSS_' . $yearString . '_' . $office_name . '.docx')->deleteFileAfterSend(true);
        }
    }

    public function generateWordPSS($currentdate, $year, $hospital_name)
    {
        $yy = $year;
        $date = $currentdate;
        $carbonDate = Carbon::parse($yy);
        $currentDate = Carbon::now();

        $yearString = Carbon::parse($year);
        $mm_string = $yearString->formatLocalized('%B %Y'); // Converts date to "Wednesday, 15 February 2023"
        // return$wordDate;


        // $hospital_name = "SAN PEDRO DISTRICT HOSPITAL";
        $query_doctor = DB::table('tbl_doctors')
            ->join('tbl_hospitals', 'tbl_doctors.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_hospitals.hospital_name', $hospital_name)
            ->select('*')
            ->get();
        // return $query_doctor;

        $results = DB::select("
        SELECT *,
        ROUND((total_avg1+total_avg2+total_avg3+total_avg4+total_avg5+total_avg6+total_avg7+total_avg8+total_avg9+total_avg10+total_avg11+total_avg12+total_avg13+total_avg14)/14,2) AS overall_average
         FROM(
        SELECT
        *,
        TRUNCATE((tb.radio1_a_avg+tb.radio1_b_avg+tb.radio1_c_avg+tb.radio1_d_avg+tb.radio1_e_avg+tb.radio1_f_avg+tb.radio1_g_avg)/count_total_avg1,2) AS total_avg1,
        TRUNCATE((tb.radio2_a_avg+tb.radio2_b_avg+tb.radio2_c_avg+tb.radio2_d_avg+tb.radio2_e_avg )/count_total_avg2,2) AS total_avg2,
        TRUNCATE((tb.radio3_a_avg+tb.radio3_b_avg+tb.radio3_c_avg+tb.radio3_d_avg+tb.radio3_e_avg) /count_total_avg3,2) AS total_avg3,
        TRUNCATE((tb.radio4_a_avg+tb.radio4_b_avg+tb.radio4_c_avg+tb.radio4_d_avg)/count_total_avg4,2) AS total_avg4,
        TRUNCATE((tb.radio5_a_avg+tb.radio5_b_avg+tb.radio5_c_avg+tb.radio5_d_avg+tb.radio5_e_avg )/count_total_avg5,2) AS total_avg5,
        TRUNCATE((tb.radio6_a_avg+tb.radio6_b_avg+tb.radio6_c_avg+tb.radio6_d_avg+tb.radio6_e_avg )/count_total_avg6,2) AS total_avg6,
        TRUNCATE((tb.radio7_a_avg+tb.radio7_b_avg+tb.radio7_c_avg+tb.radio7_d_avg+tb.radio7_e_avg )/count_total_avg7,2) AS total_avg7,
        TRUNCATE((tb.radio8_a_avg+tb.radio8_b_avg+tb.radio8_c_avg+tb.radio8_d_avg+tb.radio8_e_avg )/count_total_avg8,2) AS total_avg8,
        TRUNCATE((tb.radio9_a_avg+tb.radio9_b_avg+tb.radio9_c_avg+tb.radio9_d_avg+tb.radio9_e_avg)/count_total_avg9,2) AS total_avg9,
        TRUNCATE((tb.radio10_a_avg+tb.radio10_b_avg+tb.radio10_c_avg+tb.radio10_d_avg+tb.radio10_e_avg )/count_total_avg10,2)AS total_avg10,
        TRUNCATE((tb.radio11_a_avg+tb.radio11_b_avg+tb.radio11_c_avg+tb.radio11_d_avg )/count_total_avg11,2) AS total_avg11,
        TRUNCATE((tb.radio12_a_avg+tb.radio12_b_avg+tb.radio12_c_avg+tb.radio12_d_avg+tb.radio12_e_avg )/count_total_avg12,2) AS total_avg12,
        TRUNCATE((tb.radio13_a_avg+tb.radio13_b_avg+tb.radio13_c_avg+tb.radio13_d_avg+tb.radio13_e_avg )/count_total_avg13,2) AS total_avg13,
        TRUNCATE((tb.radio14_a_avg+tb.radio14_b_avg+tb.radio14_c_avg+tb.radio14_d_avg+tb.radio14_e_avg )/count_total_avg14,2) AS total_avg14
        FROM (
        SELECT
        *,
        (CASE WHEN radio1_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio1_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio1_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio1_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio1_e_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio1_f_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio1_g_avg=0 THEN 0 ELSE 1 END) AS count_total_avg1,
        (CASE WHEN radio2_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio2_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio2_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio2_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio2_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg2,
        (CASE WHEN radio3_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio3_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio3_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio3_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio3_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg3,
        (CASE WHEN radio4_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio4_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio4_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio4_d_avg=0 THEN 0 ELSE 1 END) AS count_total_avg4,
        (CASE WHEN radio5_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio5_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio5_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio5_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio5_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg5,
        (CASE WHEN radio6_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio6_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio6_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio6_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio6_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg6,
        (CASE WHEN radio7_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio7_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio7_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio7_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio7_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg7,
        (CASE WHEN radio8_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio8_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio8_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio8_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio8_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg8,
        (CASE WHEN radio9_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio9_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio9_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio9_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio9_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg9,
        (CASE WHEN radio10_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg10,
        (CASE WHEN radio11_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio11_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio11_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio11_d_avg=0 THEN 0 ELSE 1 END) AS count_total_avg11,
        (CASE WHEN radio12_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio12_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio12_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio12_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio12_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg12,
        (CASE WHEN radio10_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio10_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg13,
        (CASE WHEN radio14_a_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio14_b_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio14_c_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio14_d_avg=0 THEN 0 ELSE 1 END)
        +(CASE WHEN radio14_e_avg=0 THEN 0 ELSE 1 END) AS count_total_avg14
        FROM (
        SELECT
        DATE,
        TRUNCATE((SUM(radio1_a)/SUM(CASE WHEN radio1_a=0 THEN 0 ELSE 1 END)),2) AS radio1_a_avg,
        TRUNCATE((SUM(radio1_b)/SUM(CASE WHEN radio1_b=0 THEN 0 ELSE 1 END)),2) AS radio1_b_avg,
        TRUNCATE((SUM(radio1_c)/SUM(CASE WHEN radio1_c=0 THEN 0 ELSE 1 END)),2) AS radio1_c_avg,
        TRUNCATE((SUM(radio1_d)/SUM(CASE WHEN radio1_d=0 THEN 0 ELSE 1 END)),2) AS radio1_d_avg,
        TRUNCATE((SUM(radio1_e)/SUM(CASE WHEN radio1_e=0 THEN 0 ELSE 1 END)),2) AS radio1_e_avg,
        TRUNCATE((SUM(radio1_f)/SUM(CASE WHEN radio1_f=0 THEN 0 ELSE 1 END)),2) AS radio1_f_avg,
        TRUNCATE((SUM(radio1_g)/SUM(CASE WHEN radio1_g=0 THEN 0 ELSE 1 END)),2) AS radio1_g_avg,
        TRUNCATE((SUM(radio2_a)/SUM(CASE WHEN radio2_a=0 THEN 0 ELSE 1 END)),2) AS radio2_a_avg,
        TRUNCATE((SUM(radio2_b)/SUM(CASE WHEN radio2_b=0 THEN 0 ELSE 1 END)),2) AS radio2_b_avg,
        TRUNCATE((SUM(radio2_c)/SUM(CASE WHEN radio2_c=0 THEN 0 ELSE 1 END)),2) AS radio2_c_avg,
        TRUNCATE((SUM(radio2_d)/SUM(CASE WHEN radio2_d=0 THEN 0 ELSE 1 END)),2) AS radio2_d_avg,
        TRUNCATE((SUM(radio2_e)/SUM(CASE WHEN radio2_e=0 THEN 0 ELSE 1 END)),2) AS radio2_e_avg,
        TRUNCATE((SUM(radio3_a)/SUM(CASE WHEN radio3_a=0 THEN 0 ELSE 1 END)),2) AS radio3_a_avg,
        TRUNCATE((SUM(radio3_b)/SUM(CASE WHEN radio3_b=0 THEN 0 ELSE 1 END)),2) AS radio3_b_avg,
        TRUNCATE((SUM(radio3_c)/SUM(CASE WHEN radio3_c=0 THEN 0 ELSE 1 END)),2) AS radio3_c_avg,
        TRUNCATE((SUM(radio3_d)/SUM(CASE WHEN radio3_d=0 THEN 0 ELSE 1 END)),2) AS radio3_d_avg,
        TRUNCATE((SUM(radio3_e)/SUM(CASE WHEN radio3_e=0 THEN 0 ELSE 1 END)),2) AS radio3_e_avg,
        TRUNCATE((SUM(radio4_a)/SUM(CASE WHEN radio4_a=0 THEN 0 ELSE 1 END)),2) AS radio4_a_avg,
        TRUNCATE((SUM(radio4_b)/SUM(CASE WHEN radio4_b=0 THEN 0 ELSE 1 END)),2) AS radio4_b_avg,
        TRUNCATE((SUM(radio4_c)/SUM(CASE WHEN radio4_c=0 THEN 0 ELSE 1 END)),2) AS radio4_c_avg,
        TRUNCATE((SUM(radio4_d)/SUM(CASE WHEN radio4_d=0 THEN 0 ELSE 1 END)),2) AS radio4_d_avg,
        TRUNCATE((SUM(radio5_a)/SUM(CASE WHEN radio5_a=0 THEN 0 ELSE 1 END)),2) AS radio5_a_avg,
        TRUNCATE((SUM(radio5_b)/SUM(CASE WHEN radio5_b=0 THEN 0 ELSE 1 END)),2) AS radio5_b_avg,
        TRUNCATE((SUM(radio5_c)/SUM(CASE WHEN radio5_c=0 THEN 0 ELSE 1 END)),2) AS radio5_c_avg,
        TRUNCATE((SUM(radio5_d)/SUM(CASE WHEN radio5_d=0 THEN 0 ELSE 1 END)),2) AS radio5_d_avg,
        TRUNCATE((SUM(radio5_e)/SUM(CASE WHEN radio5_e=0 THEN 0 ELSE 1 END)),2) AS radio5_e_avg,
        TRUNCATE((SUM(radio6_a)/SUM(CASE WHEN radio6_a=0 THEN 0 ELSE 1 END)),2) AS radio6_a_avg,
        TRUNCATE((SUM(radio6_b)/SUM(CASE WHEN radio6_b=0 THEN 0 ELSE 1 END)),2) AS radio6_b_avg,
        TRUNCATE((SUM(radio6_c)/SUM(CASE WHEN radio6_c=0 THEN 0 ELSE 1 END)),2) AS radio6_c_avg,
        TRUNCATE((SUM(radio6_d)/SUM(CASE WHEN radio6_d=0 THEN 0 ELSE 1 END)),2) AS radio6_d_avg,
        TRUNCATE((SUM(radio6_e)/SUM(CASE WHEN radio6_e=0 THEN 0 ELSE 1 END)),2) AS radio6_e_avg,
        TRUNCATE((SUM(radio7_a)/SUM(CASE WHEN radio7_a=0 THEN 0 ELSE 1 END)),2) AS radio7_a_avg,
        TRUNCATE((SUM(radio7_b)/SUM(CASE WHEN radio7_b=0 THEN 0 ELSE 1 END)),2) AS radio7_b_avg,
        TRUNCATE((SUM(radio7_c)/SUM(CASE WHEN radio7_c=0 THEN 0 ELSE 1 END)),2) AS radio7_c_avg,
        TRUNCATE((SUM(radio7_d)/SUM(CASE WHEN radio7_d=0 THEN 0 ELSE 1 END)),2) AS radio7_d_avg,
        TRUNCATE((SUM(radio7_e)/SUM(CASE WHEN radio7_e=0 THEN 0 ELSE 1 END)),2) AS radio7_e_avg,
        TRUNCATE((SUM(radio8_a)/SUM(CASE WHEN radio8_a=0 THEN 0 ELSE 1 END)),2) AS radio8_a_avg,
        TRUNCATE((SUM(radio8_b)/SUM(CASE WHEN radio8_b=0 THEN 0 ELSE 1 END)),2) AS radio8_b_avg,
        TRUNCATE((SUM(radio8_c)/SUM(CASE WHEN radio8_c=0 THEN 0 ELSE 1 END)),2) AS radio8_c_avg,
        TRUNCATE((SUM(radio8_d)/SUM(CASE WHEN radio8_d=0 THEN 0 ELSE 1 END)),2) AS radio8_d_avg,
        TRUNCATE((SUM(radio8_e)/SUM(CASE WHEN radio8_e=0 THEN 0 ELSE 1 END)),2) AS radio8_e_avg,
        TRUNCATE((SUM(radio9_a)/SUM(CASE WHEN radio9_a=0 THEN 0 ELSE 1 END)),2) AS radio9_a_avg,
        TRUNCATE((SUM(radio9_b)/SUM(CASE WHEN radio9_b=0 THEN 0 ELSE 1 END)),2) AS radio9_b_avg,
        TRUNCATE((SUM(radio9_c)/SUM(CASE WHEN radio9_c=0 THEN 0 ELSE 1 END)),2) AS radio9_c_avg,
        TRUNCATE((SUM(radio9_d)/SUM(CASE WHEN radio9_d=0 THEN 0 ELSE 1 END)),2) AS radio9_d_avg,
        TRUNCATE((SUM(radio9_e)/SUM(CASE WHEN radio9_e=0 THEN 0 ELSE 1 END)),2) AS radio9_e_avg,
        TRUNCATE((SUM(radio10_a)/SUM(CASE WHEN radio10_a=0 THEN 0 ELSE 1 END)),2) AS radio10_a_avg,
        TRUNCATE((SUM(radio10_b)/SUM(CASE WHEN radio10_b=0 THEN 0 ELSE 1 END)),2) AS radio10_b_avg,
        TRUNCATE((SUM(radio10_c)/SUM(CASE WHEN radio10_c=0 THEN 0 ELSE 1 END)),2) AS radio10_c_avg,
        TRUNCATE((SUM(radio10_d)/SUM(CASE WHEN radio10_d=0 THEN 0 ELSE 1 END)),2) AS radio10_d_avg,
        TRUNCATE((SUM(radio10_e)/SUM(CASE WHEN radio10_e=0 THEN 0 ELSE 1 END)),2) AS radio10_e_avg,
        TRUNCATE((SUM(radio11_a)/SUM(CASE WHEN radio11_a=0 THEN 0 ELSE 1 END)),2) AS radio11_a_avg,
        TRUNCATE((SUM(radio11_b)/SUM(CASE WHEN radio11_b=0 THEN 0 ELSE 1 END)),2) AS radio11_b_avg,
        TRUNCATE((SUM(radio11_c)/SUM(CASE WHEN radio11_c=0 THEN 0 ELSE 1 END)),2) AS radio11_c_avg,
        TRUNCATE((SUM(radio11_d)/SUM(CASE WHEN radio11_d=0 THEN 0 ELSE 1 END)),2) AS radio11_d_avg,
        TRUNCATE((SUM(radio12_a)/SUM(CASE WHEN radio12_a=0 THEN 0 ELSE 1 END)),2) AS radio12_a_avg,
        TRUNCATE((SUM(radio12_b)/SUM(CASE WHEN radio12_b=0 THEN 0 ELSE 1 END)),2) AS radio12_b_avg,
        TRUNCATE((SUM(radio12_c)/SUM(CASE WHEN radio12_c=0 THEN 0 ELSE 1 END)),2) AS radio12_c_avg,
        TRUNCATE((SUM(radio12_d)/SUM(CASE WHEN radio12_d=0 THEN 0 ELSE 1 END)),2) AS radio12_d_avg,
        TRUNCATE((SUM(radio12_e)/SUM(CASE WHEN radio12_e=0 THEN 0 ELSE 1 END)),2) AS radio12_e_avg,
        TRUNCATE((SUM(radio13_a)/SUM(CASE WHEN radio13_a=0 THEN 0 ELSE 1 END)),2) AS radio13_a_avg,
        TRUNCATE((SUM(radio13_b)/SUM(CASE WHEN radio13_b=0 THEN 0 ELSE 1 END)),2) AS radio13_b_avg,
        TRUNCATE((SUM(radio13_c)/SUM(CASE WHEN radio13_c=0 THEN 0 ELSE 1 END)),2) AS radio13_c_avg,
        TRUNCATE((SUM(radio13_d)/SUM(CASE WHEN radio13_d=0 THEN 0 ELSE 1 END)),2) AS radio13_d_avg,
        TRUNCATE((SUM(radio13_e)/SUM(CASE WHEN radio13_e=0 THEN 0 ELSE 1 END)),2) AS radio13_e_avg,
        TRUNCATE((SUM(radio14_a)/SUM(CASE WHEN radio14_a=0 THEN 0 ELSE 1 END)),2) AS radio14_a_avg,
        TRUNCATE((SUM(radio14_b)/SUM(CASE WHEN radio14_b=0 THEN 0 ELSE 1 END)),2) AS radio14_b_avg,
        TRUNCATE((SUM(radio14_c)/SUM(CASE WHEN radio14_c=0 THEN 0 ELSE 1 END)),2) AS radio14_c_avg,
        TRUNCATE((SUM(radio14_d)/SUM(CASE WHEN radio14_d=0 THEN 0 ELSE 1 END)),2) AS radio14_d_avg,
        TRUNCATE((SUM(radio14_e)/SUM(CASE WHEN radio14_e=0 THEN 0 ELSE 1 END)),2) AS radio14_e_avg
        FROM tbl_form_pss WHERE DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name LIKE '%" . $hospital_name . "%')
        )tb1
        )tb
        )tb3");


        if ($results[0]->overall_average == 0) {
            return "
            <script src='../../../../../js/jquery-3.6.0.min.js'></script>
            <script src='../../../../../js/sweetalert2.js'></script>
            <script>
            $(document).ready(()=> {
            // jQuery code here
            Swal.fire(
            'No data!',
            'No Records Found',
            'error'
            )
            setTimeout(()=> {
            window.history.back();
            }, 3500);

            });
            </script>
            ";
        } else {


            $subquery = DB::table('tbl_form_pss')
                ->select([
                    'comments',
                    DB::raw('COUNT(*) AS comment_count')
                ])
                ->where('DATE', 'LIKE', '%' . $yy . '%')
                ->where('hospital_id', function ($query) use ($hospital_name) {
                    $query->select('id')
                        ->from('tbl_hospitals')
                        ->where('hospital_name', $hospital_name);
                })
                ->groupBy('comments')
                ->orderByDesc('comment_count');

            $finalQuery = DB::table(DB::raw("({$subquery->toSql()}) AS tb"))
                ->mergeBindings($subquery)
                ->select('comments', DB::raw('IF(comment_count = 1, comments, CONCAT(comments, "(", comment_count, ")")) AS final_comments'));

            $comments = DB::table(DB::raw("({$finalQuery->toSql()}) AS tb2"))
                ->mergeBindings($finalQuery)
                ->select('final_comments')
                ->where('final_comments', 'NOT LIKE', '%N/A%')
                ->pluck('final_comments');

            $aa_arr = array(
                'SANTA CRUZ',
                'MAGDALENA',
                'LOS BANOS',
                'NAGCARLAN',
                'LILIW',
                'BAY',
                'CALAUAN',
                'CAVINTI',
                'PAETE',
                'KALAYAAN',
                'LUMBAN',
                'LUISIANA',
                'ALAMINOS',
                'MAJAYJAY',
                'BINAN',
                'CABUYAO',
                'CALAMBA',
                'SAN PABLO',
                'SAN PEDRO',
                'SANTA ROSA',
                'STA MARIA',
                'SINILOAN',
                'VICTORIA',
                'MABITAC',
                'PAGSANJAN',
                'PAKIL',
                'PANGIL',
                'FAMY',
                'PILA',
                'CAVITE',
                'BATANGAS',
                'QUEZON',
                'RIZAL',
                'NOT APPLICABLE'
            );

            $bb_arr = array();


            foreach ($aa_arr as $keys => $items) {
                $municipality = DB::select("SELECT COUNT(home_address) as home_count FROM(
      SELECT
                DATE,
                hospital_id,
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(
                UPPER(home_address),
                ' ',
                ' '
                ),
                ',',
                ' '
                ),
                'BRGY. ZONE 1',
                ''
                ),
                'LAG.',
                ''
                ),
                'LAGUNA',
                ''
                ),
                'MAKATI CITY',
                'NOT APPLICABLE'
                ),
                'CITY',
                ''
                ),
                'CAV.',
                'CAVITE'
                ),
                '.',
                ' '
                ),
                'STA CRUZ',
                'SANTA CRUZ'
                ),
                'LOS BAÃ±OS',
                'LOS BANOS'
                ),
                'LOS BAÃ‘OS',
                'LOS BANOS'
                ),
                'Los Baños',
                'LOS BANOS'
                ),
                'STA  CRUZ ',
                'SANTA CRUZ'
                ),
                'N/A',
                'NOT APPLICABLE'
                ) AS home_address
                FROM tbl_form_pss

                )tb1
                WHERE DATE LIKE '%$yy%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '$hospital_name') AND UPPER(home_address) LIKE '%" . $items . "%'");
                $bb_arr[$keys]['home_address'] = $items;
                $bb_arr[$keys]['home_count'] = $municipality[0]->home_count;
            }

            $bb_arr_collection = collect($bb_arr);

            $map_bb_arr = $bb_arr_collection->map(function ($item) {
                return $item['home_count'];
            });

            $bb_arr_count = $map_bb_arr->sum();

            $results_charts1 = DB::select("
        SELECT
        *
        FROM (
        SELECT
        (SELECT COUNT(checked_doctor) FROM tbl_form_pss WHERE checked_doctor = '1' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart1_slice1,
        (SELECT COUNT(checked_doctor) FROM tbl_form_pss WHERE checked_doctor = '2' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart1_slice2,
        (SELECT COUNT(checked_doctor) FROM tbl_form_pss WHERE checked_doctor = '3' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart1_slice3,
        (SELECT COUNT(checked_doctor) FROM tbl_form_pss WHERE checked_doctor = '4' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart1_slice4,
        (SELECT COUNT(checked_doctor) FROM tbl_form_pss WHERE checked_doctor = '5' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart1_slice5,
        (SELECT COUNT(checked_doctor) FROM tbl_form_pss WHERE checked_doctor = '6' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart1_slice6
        FROM tbl_form_pss
        GROUP BY finalchart1_slice1
        ) AS tb1
");


            $results_charts2 = DB::select("
        SELECT
        *
        FROM (
        SELECT
        (SELECT COUNT(before_admit) FROM tbl_form_pss WHERE before_admit = '1' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart2_slice1,
        (SELECT COUNT(before_admit) FROM tbl_form_pss WHERE before_admit = '2' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart2_slice2,
        (SELECT COUNT(before_admit) FROM tbl_form_pss WHERE before_admit = '3' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart2_slice3,
        (SELECT COUNT(before_admit) FROM tbl_form_pss WHERE before_admit = '4' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart2_slice4,
        (SELECT COUNT(before_admit) FROM tbl_form_pss WHERE before_admit = '5' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart2_slice5,
        (SELECT COUNT(before_admit) FROM tbl_form_pss WHERE before_admit = '6' AND DATE LIKE '%" . $yy . "%' AND hospital_id = (SELECT id FROM tbl_hospitals WHERE hospital_name = '" . $hospital_name . "')) AS finalchart2_slice6
        FROM tbl_form_pss
        GROUP BY finalchart2_slice1
        ) AS tb1
");

            $arr_charts1 = array_map(fn ($item) =>
            [
                $item->finalchart1_slice1,
                $item->finalchart1_slice2,
                $item->finalchart1_slice3,
                $item->finalchart1_slice4,
                $item->finalchart1_slice5,
                $item->finalchart1_slice6
            ], $results_charts1);

            $arr_charts2 = array_map(fn ($item) =>
            [
                $item->finalchart2_slice1,
                $item->finalchart2_slice2,
                $item->finalchart2_slice3,
                $item->finalchart2_slice4,
                $item->finalchart2_slice5,
                $item->finalchart2_slice6
            ], $results_charts2);

            $convertedArray1 = array_map(function ($value) {
                return (float)$value;
            }, $arr_charts1[0] ?? [0]);

            $totalSum_chart1 = array_sum($convertedArray1);
            $percentages_chart1 = [];
            foreach ($convertedArray1 as $value_chart1) {
                if ($value_chart1 == 0) {
                    $percentage_chart = "0";
                    $percentages_chart1[] = $value_chart1;
                } else {
                    $percentage_chart1 = ($value_chart1 / $totalSum_chart1) * 100;
                    $percentages_chart1[] = round($percentage_chart1);
                }
            }

            $convertedArray2 = array_map(function ($value) {
                return (float)$value;
            }, $arr_charts2[0] ?? [0]);

            $totalSum_chart2 = array_sum($convertedArray2);
            $percentages_chart2 = [];
            foreach ($convertedArray2 as $value_chart2) {
                if ($value_chart2 == 0) {
                    $percentage_chart2 = "0";
                    $percentages_chart2[] = $value_chart2;
                } else {
                    $percentage_chart2 = ($value_chart2 / $totalSum_chart2) * 100;
                    $percentages_chart2[] = round($percentage_chart2);
                }
            }

            $highestValue1 = max($convertedArray1);
            $index1 = array_keys($convertedArray1, $highestValue1)[0] ?? [0];

            $lowestValue1 = min($convertedArray1);
            $index1_min = array_keys($convertedArray1, $lowestValue1)[0] ?? [0];

            $highestValue2 = max($convertedArray2);
            $index2 = array_keys($convertedArray2, $highestValue2)[0] ?? [0];

            $lowestValue2 = min($convertedArray2);
            $index2_min = array_keys($convertedArray2, $lowestValue2)[0] ?? [0];

            
            if ($results[0]->overall_average <= 1) {
                $degree_satisfaction_remarks = "Not Satisfied";
                $overall_performance_remarks = "Poor";
            } elseif ($results[0]->overall_average >= 2) {
                $degree_satisfaction_remarks = "Slightly Satisfied";
                $overall_performance_remarks = "Fair";
            } elseif ($results[0]->overall_average >= 3) {
                $degree_satisfaction_remarks = "Satisfied";
                $overall_performance_remarks = "Good";
            } elseif ($results[0]->overall_average >= 4) {
                $degree_satisfaction_remarks = "Very Satisfied";
                $overall_performance_remarks = "Very Good";
            } else {
                $degree_satisfaction_remarks = "";
                $overall_performance_remarks = "";
            }

            if ($degree_satisfaction_remarks == 'Very Satisfied') {
                $degree_satisfaction_remarks1 = "Maintain the $overall_performance_remarks Service performance of the department by making the customers Very Satisfied in the next cycles";
                $degree_satisfaction_remarks2 = "Recognize the $overall_performance_remarks personnel with their effort of providing satisfactory services to the customers during department meeting";
            } else {
                $degree_satisfaction_remarks1 = "Improve the $overall_performance_remarks Service performance of the department by making the customers Very Satisfied in the next cycles";
                $degree_satisfaction_remarks2 = "Encourage the personnel to providing satisfactory services to the customers during department meeting";
            }

            $results_chart_settings = DB::table('tbl_chart_settings_pss')
                ->get();
            Settings::setOutputEscapingEnabled(true);
            $phpWord = new PhpWord();
            $template = new TemplateProcessor('documents/PSS_NEW.docx');

            // return "wew";
            //SERVICES
            $section = $phpWord->addSection();

            // Define the table style
            $styleTable = array(
                'borderSize' => 5,
                'borderColor' => '000000',
                'spaceBefore' => 0,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 0,
                'gridSpan' => 5
            );

            $styleTable_municipality = array(
                'borderSize' => 5,
                'borderColor' => 'white',
                'spaceBefore' => 0,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 0,
                'gridSpan' => 5
            );


            $table_font_head_style = array(
                'size' => 8.5,
                'bold' => true,
            );

            $table_font_body_style = array(
                'size' => 8.5,
                'bold' => false,
            );

            $fixedSpacingStyle = array(
                'spaceBefore' => 0,  // Set the spacing before the paragraph to 0
                'spaceAfter' => 0,   // Set the spacing after the paragraph to 0
            );


            $phpWord->addTableStyle('myTable', $styleTable);
            $table = $section->addTable('myTable');

            $categories_1 = array(
                //ONE
                array(
                    "title" => "I. Environment of the Facility(Kapaligiran)",
                    "value" => $results[0]->total_avg1,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => " A. Rooms are clean and orderly (Mayroong malinis at maayos na mga silid)",
                    "value" => $results[0]->radio1_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " B. All linens including sheets covers are clean (Malinis ang mga sapin sa higaan at mga punda):",
                    "value" => $results[0]->radio1_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " C. Linens are being replaced every day. (Napapalitan ang mga hospital linen araw araw):",
                    "value" => $results[0]->radio1_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " D. Rooms and wards are quiet especially at night (Tahimik ang loob ng silid lalo na sa gabi): ",
                    "value" => $results[0]->radio1_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " E. Restrooms are clean (Malinis ang palikuran o CR):  ",
                    "value" => $results[0]->radio1_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " F. Treatment areas or clinics are clean and organized (May malilinis na treatment area or klinika) : ",
                    "value" => $results[0]->radio1_f_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " G. With proper waiting areas (May maayos na lugar hintayan): ",
                    "value" => $results[0]->radio1_g_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "II. Nutrition and Dietary Service (Pagkain na isinilbi)",
                    "value" => $results[0]->total_avg2,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => " a. Flavourful (Malasa):",
                    "value" => $results[0]->radio2_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " b. Nutritous (Masustansiya): ",
                    "value" => $results[0]->radio2_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " c. Served Properly (Maayos):",
                    "value" => $results[0]->radio2_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " d. Serve on time (Ibinibigay sa tamang oras):",
                    "value" => $results[0]->radio2_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " e. Food containers are collected on time (Kinukuha ang pinalagyan ng pagkain sa tamang oras)",
                    "value" => $results[0]->radio2_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " III. Medical Services (Serbisyo ng mga doctor)",
                    "value" => $results[0]->total_avg3,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => " a. Provides great medical service (Magagaling o Mahuhusay):",
                    "value" => $results[0]->radio3_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " b. Kind (Mababait):",
                    "value" => $results[0]->radio3_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " c. Caring (Maalaga): ",
                    "value" => $results[0]->radio3_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " d. Explains the patient's condition clearly (Nagpapaliwanag ng tungkol sa aking kalagayan): ",
                    "value" => $results[0]->radio3_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " e. Does patient's condition clearly (Nagpapaliwanag ng tungkol sa aking kalagayan):",
                    "value" => $results[0]->radio3_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " IV. Nursing Service (Serbisyo ng mga Nars)",
                    "value" => $results[0]->total_avg4,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => " a. Fast (Mabibilis):",
                    "value" => $results[0]->radio4_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " b. Kind (Mabait):",
                    "value" => $results[0]->radio4_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " c. Caring (Maalaga):",
                    "value" => $results[0]->radio4_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " d. Medicine are always available (Laging available ang gamot):",
                    "value" => $results[0]->radio4_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " V. Pharmacy Service (Serbisyo sa botika)",
                    "value" => $results[0]->total_avg5,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => " a. Fast (Mabibilis):",
                    "value" => $results[0]->radio5_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " b. Kind (Mababait):",
                    "value" => $results[0]->radio5_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " c. Courteous (Magagalang): ",
                    "value" => $results[0]->radio5_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " d. Medicines are always available (May saapat at available na gamot):",
                    "value" => $results[0]->radio5_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " e. Medical equipment and supplies always available (May sapat at available na kagamitang medical or medical supplies): ",
                    "value" => $results[0]->radio5_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " VI. Laboratory Service (Serbisyo nang Laboratoryo)",
                    "value" => $results[0]->total_avg6,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => " a. Fast (Mabibilis):",
                    "value" => $results[0]->radio6_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " b. Kind (Mababait): ",
                    "value" => $results[0]->radio6_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " c. Courteous (Magagalang): ",
                    "value" => $results[0]->radio6_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " d. Provides proper and clear explanation of the process that will be done (Nagpapaliwanag ng kanyang ginagawang pamaraan):",
                    "value" => $results[0]->radio6_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => " e. Laboratory results are released on time (Mabilis na naibibigay ang resulta sa mga laboratory test):",
                    "value" => $results[0]->radio6_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "VII. Imaging Service (Serbisyo Imaging o X-ray Department )",
                    "value" => $results[0]->total_avg7,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio7_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio7_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Courteous (Magagalang):",
                    "value" => $results[0]->radio7_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Provides proper and clear explanation of the process that will be done (Nagpapaliwanag ng kanyang ginagawang pamamaraan):",
                    "value" => $results[0]->radio7_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "e. Imaging X-ray results are released on time (Mabibilis na naiibigay ang resulta ng xray): ",
                    "value" => $results[0]->radio7_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "VIII. PhilHealth Section (Serbisyo ng Philhealth Seksyon)",
                    "value" => $results[0]->total_avg8,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio8_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio8_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Courteous (Magagalang):",
                    "value" => $results[0]->radio8_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Clearly explains the coverage of the benefits (Maayos magpaliwanag ng mga benepisyo)",
                    "value" => $results[0]->radio8_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "e. Appropriate benefits are granted and processed accordingly (Nagbibigay at naisasaayos ang tamang benepisyo):",
                    "value" => $results[0]->radio8_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "IX. Medical Social Services Section (Serbisyo ng Social Services Seksyon)",
                    "value" => $results[0]->total_avg9,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio9_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio9_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Corteous (Magagalang):",
                    "value" => $results[0]->radio9_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Clearly explains the coverage of the benefits (Maayos):",
                    "value" => $results[0]->radio9_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "e. Appropriate benefits are granted and processed accordingly (Naiibigay at naisaayos ang benepisyo):",
                    "value" => $results[0]->radio9_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "X. Billing Services (Serbisyo ng Billing Seksyon)",
                    "value" => $results[0]->total_avg10,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio10_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio10_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Courteous (Magagalang):",
                    "value" => $results[0]->radio10_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Appropriate Philhealth benefits are accurately deducted from the patient's bill (Tamang pagbawas ng benepisyo ng Philhealth):",
                    "value" => $results[0]->radio10_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "e. Statement of Accounts are accurately computed (Tamang tuos ng mga bayarin sa gamutan):",
                    "value" => $results[0]->radio10_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "XI. Medical Records (Serbisyo Medical Records Seksyon)",
                    "value" => $results[0]->total_avg11,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio11_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio11_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Courteous (Magagalang):",
                    "value" => $results[0]->radio11_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Requested medical documents are relaeased on time (Mabilis na naibibigay ang mga dokumentong hinihingi):",
                    "value" => $results[0]->radio11_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "XII. Security Services (Mga Serbisyo ng mga Gwardiya)",
                    "value" => $results[0]->total_avg12,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio12_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio12_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Courteous (Magagalang):",
                    "value" => $results[0]->radio12_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Deligently guards all entrances and exits (Mahigpit na binabantayan ang mga pumapasok at lumalabas ng ospital):",
                    "value" => $results[0]->radio12_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "e. Assist in the implementation of hospitals rules and policies (Tumutulong sa pagpatupad ng mga alituntunin ng ospital):",
                    "value" => $results[0]->radio12_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "XIII. Canteen Service (Serbisyo ng Kantina)",
                    "value" => $results[0]->total_avg13,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio13_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio13_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Corteous (Magagalang):",
                    "value" => $results[0]->radio13_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Foods sold are nutritous and delicous (Masasarap at masustansya ang mga binebentang pagkain):",
                    "value" => $results[0]->radio13_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "e. Foods sold are budget-friendly (Abot kaya ng presyo ng mga pagkain):",
                    "value" => $results[0]->radio13_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "XIV. Ambulance Services (Serbisyo ng Ambulansiya)",
                    "value" => $results[0]->total_avg14,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
                array(
                    "title" => "a. Fast (Mabibilis):",
                    "value" => $results[0]->radio14_a_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "b. Kind (Mababait):",
                    "value" => $results[0]->radio14_b_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "c. Corteous:",
                    "value" => $results[0]->radio14_c_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "d. Patients are well-treated (Maayos na pagtrato sa pasyente):",
                    "value" => $results[0]->radio14_d_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "e. Overall efficiency of the ambulance driver, ambulance medical staff and the ambulance service as a whole (Kahusayan ng ambulance driver, medical staff na kasama sa ambulansya at kabuuan ng serbisyo):",
                    "value" => $results[0]->radio14_e_avg,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_body_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'left')
                ),
                array(
                    "title" => "OVERALL AVERAGE FOR THE MONTH",
                    "value" => $results[0]->overall_average,
                    "style_table" => $styleTable,
                    "table_font_body_style" => $table_font_head_style,
                    "align_title" => array('align' => 'left'),
                    "align_value" => array('align' => 'right')
                ),
            );

            // return "wew";
            $table->addRow();
            $table->addCell(10500, $styleTable)->addText('TYPE OF SERVICE(URI NG SERBISYO)', $table_font_head_style);
            $table->addCell(1500, $styleTable)->addText('Average Rating', $table_font_head_style);
            foreach ($categories_1 as $key1 => $category_1) {
                $table->addRow();
                $table->addCell(10500, $categories_1[$key1]['style_table'])->addText($categories_1[$key1]['title'], $categories_1[$key1]['table_font_body_style'], $categories_1[$key1]['align_title']);
                $table->addCell(1500, $categories_1[$key1]['style_table'])->addText($categories_1[$key1]['value'], $categories_1[$key1]['table_font_body_style'], $categories_1[$key1]['align_value']);
            }

            $table->addRow();
            $table->addCell(12000, array(
                'gridSpan' => 10,
                'valign' => 'center',
                'borderLeftSize' => 5,
                'borderLeftColor' => '000000',
                'borderRightSize' => 5,
                'borderRightColor' => '000000',
                'borderTopSize' => 5,
                'borderTopColor' => '000000',
                'borderBottomSize' => 5,
                'borderBottomColor' => '000000',
            ))->addText('Comments/suggestions lifted from the CSQ verbatim', $table_font_head_style, array('align' => 'center'));

            foreach ($comments as $key => $value) {
                $table->addRow();
                $table->addCell(12000, array(
                    'gridSpan' => 10,
                    'borderLeftSize' => 5,
                    'borderLeftColor' => '000000',
                    'borderRightSize' => 5,
                    'borderRightColor' => '000000',
                    'borderTopSize' => 5,
                    'borderTopColor' => '000000',
                    'borderBottomSize' => 5,
                    'borderBottomColor' => '000000',
                ))->addText($key . "." . $value, $table_font_body_style);
            }



            $template->cloneBlock('myTable', 2, true, true);
            $template->setComplexBlock('table', $table);

            $section = $phpWord->addSection();
            $phpWord->addTableStyle('myTable', $styleTable);
            $table = $section->addTable('myTable');

            $table->addRow();
            $table->addCell(5000, array(
                'gridSpan' => 10,
                'borderLeftSize' => 5,
                'borderLeftColor' => 'white',
                'borderRightSize' => 5,
                'borderRightColor' => 'white',
                'borderTopSize' => 5,
                'borderTopColor' => 'white',
                'borderBottomSize' => 5,
                'borderBottomColor' => 'white',
            ))->addText("Count Based on Place of Residency", $table_font_head_style);
            $municipality_home_address_item = "";
            $municipality_count_item = "";
            foreach ($bb_arr as $value) {
                $home_address = $value['home_address'];
                if ($value['home_count'] != 0) {
                    $municipality_home_address_item .= "".$value['home_address'];
                    $municipality_count_item .= number_format(($value['home_count'] / $bb_arr_count) * 100, 2, '.', '') . "%" . ",";
                    $arr_municipality[] = number_format(($value['home_count'] / $bb_arr_count) * 100, 2, '.', '') . "%"." were from ".$value['home_address'];
                    
                    $final_municipality = implode(', ',$arr_municipality);
                    if ($value['home_address'] == 'QUEZON') {
                        $home_address = "QUEZON PROVINCE";
                    } elseif ($value['home_address'] == 'BATANGAS') {
                        $home_address = "BATANGAS PROVINCE";
                    } else {
                        $home_address = $value['home_address'];
                    }
                    
                    $table->addRow();
                    $table->addCell(2000, $styleTable_municipality)->addText($home_address, $table_font_body_style);
                    $table->addCell(2000, $styleTable_municipality)->addText($value['home_count']." (".number_format(($value['home_count'] / $bb_arr_count) * 100, 2, '.', '') . "%"." )", $table_font_body_style);
                }
            }
            $chart_total1 = $percentages_chart1[0] . "% of the clients were attended in 1 to 2 hours" . "," . $percentages_chart1[1] . "," . $percentages_chart1[2] . "% of the clients were attended in 3 to 4 hours" . "," . $percentages_chart1[3] . "% of the clients were attended in 5 to 6 hours" . "," . $percentages_chart1[4] . "% of the clients were attended in 7 to 8 hours" . "," . $percentages_chart1[5] . "%of the clients were attended in Not Indicated";
            $chart_total2 = $percentages_chart2[0] . "% of the clients were attended in 1 to 2 hours" . "," . $percentages_chart2[1] . "," . $percentages_chart2[2] . "% of the clients were attended in 3 to 4 hours" . "," . $percentages_chart2[3] . "% of the clients were attended in 5 to 6 hours" . "," . $percentages_chart2[4] . "% of the clients were attended in 7 to 8 hours" . "," . $percentages_chart2[5] . "%of the clients were attended in Not Indicated";
            // return $chart_total;

            $template->cloneBlock('myTable', 2, true, true);
            $template->setComplexBlock('table_residency', $table);

            $showGridLines = false;
            $showAxisLabels = true;
            $showLegend = true;
            $legendPosition = 't';

            $chart_name_arr1 = ['>1hr', '1-2hours', '3-4hours', '5-6hours', '7-8hours', 'Not Indicated'];

            $chart_final1 = new Chart("pie", $chart_name_arr1, $convertedArray1);

            $chart_final1->getStyle()
                ->setWidth(Converter::inchToEmu(3.8))
                ->setHeight(Converter::inchToEmu(2.7))
                ->setShowGridX(false)
                ->setShowGridY(false)
                ->setShowAxisLabels(true)
                ->setShowLegend(true)
                ->setLegendPosition("l");
            $chart_final1->getStyle()->setDataLabelOptions([
                'showVal' => true,
                'showCatName' => false,
                'showLegendKey' => false,
            ]);

            $template->setChart("chart1", $chart_final1);

            $chart_final2 = new Chart("pie", $chart_name_arr1, $convertedArray2);

            $chart_final2->getStyle()
                ->setWidth(Converter::inchToEmu(3.8))
                ->setHeight(Converter::inchToEmu(2.7))
                ->setShowGridX(false)
                ->setShowGridY(false)
                ->setShowAxisLabels(true)
                ->setShowLegend(true)
                ->setLegendPosition("l");
            $chart_final2->getStyle()->setDataLabelOptions([
                'showVal' => true,
                'showCatName' => false,
                'showLegendKey' => false,
            ]);

            $template->setChart("chart2", $chart_final2, array('fontSize' => 3));

            // return "wew";

            $template->setValue('date_issued', $date);
            $template->setValue('manager', $query_doctor[0]->doctor_name);
            $template->setValue('position', $query_doctor[0]->position);
            $template->setValue('hospital_name', $hospital_name);
            $template->setValue('manager_lastname', $query_doctor[0]->doctor_name);
            $template->setValue('mm_string', $mm_string);
            $template->setValue('total_respondents', $bb_arr_count);
            $template->setValue('overall_performance_remarks', $overall_performance_remarks);
            $template->setValue('municipality', $final_municipality);
            // $template->setValue('municipality_percentage', $municipality_count_item);
            $template->setValue('chart_text1', $chart_total1);
            $template->setValue('chart_text2', $chart_total2);
            $template->setValue('degree_satisfaction_remarks1', $degree_satisfaction_remarks1);
            $template->setValue('degree_satisfaction_remarks2', $degree_satisfaction_remarks2);

            $template->saveAs('documents/output/PSS_' . $yy . '_' . $hospital_name . '.docx');
            return response()->download('documents/output/PSS_' . $yy . '_' . $hospital_name . '.docx')->deleteFileAfterSend(true);
        }
    }
    public function numberToWord($num = '')
    {
        $num    = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words  = array();

            $num    = str_replace(array(',', ' '), '', trim($num));

            $list1  = array(
                '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            );

            $list2  = array(
                '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred'
            );

            $list3  = array(
                '', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num    = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds   = (int) ($num_part / 100);
                $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens       = (int) ($num_part % 100);
                $singles    = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words  = implode(', ', $words);

            $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words  = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }
}
