<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\FormCSS;
use App\Models\FormPSS;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Exceptions\Handler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Exception;

class PDFController extends Controller
{
    //
    public function test(Request $request)
    {
        // $pdf = new Pdf();
        // $pdf->setOptions(['javascript-delay' => 1000]); // Optional: Set JavaScript delay if required
        // $pdf->generateFromHtml('<h1>Hello, Laravel!</h1>', 'path/to/output.pdf');
    }
    //GENERATE REPORT CSS
    public function report_css(Request $request)
    {
        $monthYearString = $request->monthyear;
        $monthString = $request->month;
        $yearString = $request->year;
        $yy = $request->year;
        $prev_y = $yy-1;
        $office_name = $request->office_name;

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

        $invalidated = $countInvalidated;

        $currentDate = Carbon::now()->formatLocalized('%B %d, %Y');

        $date = Carbon::createFromFormat('Y-m', $monthYearString);
        $monthYear = $date->format('F Y');

        $date1 = Carbon::createFromFormat('m', '05');
        $month = $date1->format('F');

        $prevmonthYearString = $date->subMonth();
        $prevmonthYear = $prevmonthYearString->format('F Y');

        // $results = DB::select("
        // SELECT *,TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
        // FROM(
        // SELECT
        // service_name,
        // TRUNCATE(COALESCE((SELECT COUNT(id) FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS total_respondents,
        // TRUNCATE(COALESCE((SELECT AVG(radio_1+radio_2)/2 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS delivery_service,
        // TRUNCATE(COALESCE((SELECT AVG(radio_3+radio_4+radio_5)/3 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS communications,
        // TRUNCATE(COALESCE((SELECT AVG(radio_6+radio_7+radio_8+radio_9)/4 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS quality_staff,
        // TRUNCATE(COALESCE((SELECT AVG(radio_10+radio_11)/2 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS quality_work,
        // TRUNCATE(COALESCE((SELECT AVG(radio_12)/1 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS problem_solving
        // FROM tbl_services WHERE office_id = " . $result_offices[0]->id . ") AS C");

        // $results = DB::select("
        // SELECT * FROM(
        //     SELECT *,TRUNCATE((delivery_service + communications + quality_staff + quality_work + problem_solving) / 5,2) AS average
        //     FROM(
        //     SELECT
        //     id,
        //     service_name,
        //     TRUNCATE(COALESCE((SELECT COUNT(id) FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS total_respondents,
        //     TRUNCATE(COALESCE((SELECT AVG(radio_1+radio_2)/2 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS delivery_service,
        //     TRUNCATE(COALESCE((SELECT AVG(radio_3+radio_4+radio_5)/3 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS communications,
        //     TRUNCATE(COALESCE((SELECT AVG(radio_6+radio_7+radio_8+radio_9)/4 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS quality_staff,
        //     TRUNCATE(COALESCE((SELECT AVG(radio_10+radio_11)/2 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS quality_work,
        //     TRUNCATE(COALESCE((SELECT AVG(radio_12)/1 FROM tbl_form_css WHERE services_id = tbl_services.id AND DATE LIKE '%" . $monthYearString . "%'),0),2) AS problem_solving
        //     FROM tbl_services WHERE office_id = " . $result_offices[0]->id . ") AS C
        //     ) AS tb1 WHERE average !='0.00'");

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

        // return $results;
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
            </script>
            ";
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
            // return $results;


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
            $overall_average =  number_format($averages['average'], 2);

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
            // return$averages_chart2;

            $overall_delivery_service = number_format($averages['delivery_service'], 2);
            $overall_communications =  number_format($averages['communications'], 2);
            $overall_quality_staff =  number_format($averages['quality_staff'], 2);
            $overall_quality_work =  number_format($averages['quality_work'], 2);
            $overall_problem_solving =  number_format($averages['problem_solving'], 2);
            // $overall_average =  number_format($averages['average'], 2);
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
            elseif ($overall_average >= 4) {
                $degree_satisfaction_remarks = "Very Satisfied";
                $overall_performance_remarks = "Very Good";
            } 
            else {
            
            }


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
                // echo $collection_comments[$keys]['total_count'];
            }

            $limit = 100; // Set the limit for total_count

            $dividedData = [];

            foreach ($collection_comments as $keys => $item) {
                $total_count = $item["total_count"];
                if ($item["total_count"] > $limit) {
                    while ($total_count > 0) {
                        $chunk_count = min($total_count, $limit);
                        $item_copy = $item; // Copy the item
                        $item_copy["total_count"] = $chunk_count; // Update total_count
                        $dividedData[$keys][0] = $item_copy; // Add the chunk to the result array
                        $total_count -= $chunk_count;
                    }
                } else {
                    // $item["total_count"] = $total_count;
                    $dividedData[0][$keys] = $item; // Add the item as is

                }
            }


            // return$dividedData;
            // dd($collection_comments);

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

            // return$result_chart;

            // return$result_chart;

            $imagePath1 = 'images/logo.png';
            $imageData1 = base64_encode(file_get_contents($imagePath1));

            $imagePath2 = 'images/coa-logo.png';
            $imageData2 = base64_encode(file_get_contents($imagePath2));

            $imagePath3 = 'images/ambisyon.png';
            $imageData3 = base64_encode(file_get_contents($imagePath3));
            $results_chart_settings = DB::table('tbl_chart_settings_css')
                ->get();
        
            $data = [
                'logo1' => $imageData1,
                'logo2' => $imageData2,
                'logo3' => $imageData3,
                'date_selected' => $currentDate,
                'manager' => $result_managers[0]->manager_name,
                'manager_lastname' => $manager_final_lastname,
                'office_name' => $office_name,
                'total_survey' => "0",
                'month' => $month,
                'monthString' => $monthString,
                'yearString' => $yearString,
                'degree_satisfaction_remarks' => $degree_satisfaction_remarks,
                'overall_performance_remarks' => $overall_performance_remarks,
                'csat_current_min_name' => 'Invalidated',
                'date_issued' => $currentDate,
                'current_month' => $monthYear,
                'prev_month' => $prevmonthYear,
                'chart1' => $result_chart,
                'chart2' => $averages_chart2,
                'chart_settings' => $results_chart_settings[0]->chart_name,
                'results' => $chunkedArray_services,
                'total_respondents' => array_sum($arr_total_respondents),
                'total_respondents_words' => $this->numberToWord(array_sum($arr_total_respondents)),
                'overall_delivery_service' => $overall_delivery_service,
                'overall_communications' => $overall_communications,
                'overall_quality_staff' => $overall_quality_staff,
                'overall_quality_work' => $overall_quality_work,
                'overall_problem_solving' => $overall_problem_solving,
                'overall_average' => $overall_average,
                'invalidated' => $invalidated,
                'invalidated_words' => $this->numberToWord($invalidated),
                'comments_arr1' => $dividedData
            ];

            return view('report_css', $data);
        }
    }

    public function report_csm(Request $request)
    {  
        //II. SCOPE SERVICES EXTERNAL
            $query_scope_external = "
            SELECT service_name,id,services_id,responses FROM(
            SELECT
            id,services_id,responses,
            (
            SELECT service_name
            FROM tbl_services_csm
            WHERE id = tb2.services_id AND service_type = '0'
            )AS service_name
            FROM(
            SELECT
            tbl_form_csm.id,
            SUBSTRING_INDEX(SUBSTRING_INDEX(service_id, ',', n.digit + 1), ',', -1) AS services_id,
            COUNT(*) AS responses
            FROM
            tbl_form_csm
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
            ON LENGTH(service_id) - LENGTH(REPLACE(service_id, ',', '')) >= n.digit
            WHERE tbl_form_csm.office_id = '21'
            GROUP BY
            services_id
            )tb2
            )tb3 WHERE service_name IS NOT NULL
            ";

            $result_scope_external = DB::select($query_scope_external);
            $sum_scope_external = 0; 
            foreach ($result_scope_external as $item) {
                $sum_scope_external += $item->responses;
            }        
        //II. SCOPE SERVICES INTERNAL
        $query_scope_internal = "
        SELECT service_name,id,services_id,responses FROM(
        SELECT
        id,services_id,responses,
        (
        SELECT service_name
        FROM tbl_services_csm
        WHERE id = tb2.services_id AND service_type = '1'
        )AS service_name
        FROM(
        SELECT
        tbl_form_csm.id,
        SUBSTRING_INDEX(SUBSTRING_INDEX(service_id, ',', n.digit + 1), ',', -1) AS services_id,
        COUNT(*) AS responses
        FROM
        tbl_form_csm
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
        ON LENGTH(service_id) - LENGTH(REPLACE(service_id, ',', '')) >= n.digit
        WHERE tbl_form_csm.office_id = '21'
        GROUP BY
        services_id
        )tb2
        )tb3 WHERE service_name IS NOT NULL
        ";

        $result_scope_internal = DB::select($query_scope_internal);

        //II. PEOPLE ANSWERED THE SURVEY

        $sum = 0; // Initialize the variable

        foreach ($numbers as $number) {
        $sum += $number; // Add each number to the sum
        }


        //II. TOTAL PEOPLE ANSWERED SURVEY

        //II. PEOPLE PERCENTAGE

        //II. SERVICES THAT HAS NO CLIENTS

        //III. METHODOLOGY

        //IV.A RESULT CC

        //IV.A RESULT SQD

        //IV.B Average Score Services
        
        //IV.B Average Score Services

        $data = [
            'result_scope_external' => $result_scope_external,
            'result_scope_internal' => $result_scope_internal,
            'sum_scope_external' => $result_scope_external,
            'sum_scope_internal' => $result_scope_internal,
        ];
        

        return view('report_csm',$data);
    }
    //GENERATE REPORTS PSS
    public function report_pss(Request $request)
    {
        $imagePath1 = 'images/logo.png';
        $imageData1 = base64_encode(file_get_contents($imagePath1));

        $imagePath2 = 'images/coa-logo.png';
        $imageData2 = base64_encode(file_get_contents($imagePath2));

        $imagePath3 = 'images/ambisyon.png';
        $imageData3 = base64_encode(file_get_contents($imagePath3));
        $yy = $request->year;
        // Create a new Carbon date object by parsing the date string
        $carbonDate = Carbon::parse($yy);
        $currentDate = Carbon::now();

        // Convert the Carbon date object to the desired date in word format
        $dateInWordFormat = $carbonDate->format('F Y');
        $dateMonthInWordFormat = $currentDate->format('F m Y');
        // return $dateMonthInWordFormat;
        $hospital_name = $request->hospital_name;
        $query_doctor = DB::table('tbl_doctors')
            ->join('tbl_hospitals', 'tbl_doctors.hospital_id', '=', 'tbl_hospitals.id')
            ->where('tbl_hospitals.hospital_name', $hospital_name)
            ->select('*')
            ->get();

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
        // return $results;
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
        }

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


        // return $comments;
        $collection_comments = Collection::make($comments);
        $comment_array = $collection_comments->toArray();

        if (empty($comment_array)) {
            $chunkedArray_comment = array();
        } else {
            $chunkedArray_comment = array_chunk($comment_array, 50) ?? array("No available comments");
        }

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
            $percentage_chart1 = ($value_chart1 / $totalSum_chart1) * 100;
            $percentages_chart1[] = round($percentage_chart1);
        }

        $convertedArray2 = array_map(function ($value) {
            return (float)$value;
        }, $arr_charts2[0] ?? [0]);

        $totalSum_chart2 = array_sum($convertedArray2);
        $percentages_chart2 = [];
        foreach ($convertedArray2 as $value_chart2) {
            $percentage_chart2 = ($value_chart2 / $totalSum_chart2) * 100;
            $percentages_chart2[] = round($percentage_chart2);
        }

        // return $percentages_chart1;

        $highestValue1 = max($convertedArray1);
        $index1 = array_keys($convertedArray1, $highestValue1)[0] ?? [0];

        $lowestValue1 = min($convertedArray1);
        $index1_min = array_keys($convertedArray1, $lowestValue1)[0] ?? [0];

        $highestValue2 = max($convertedArray2);
        $index2 = array_keys($convertedArray2, $highestValue2)[0] ?? [0];

        $lowestValue2 = min($convertedArray2);
        $index2_min = array_keys($convertedArray2, $lowestValue2)[0] ?? [0];

        // return $results[0]->overall_average;

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

        $results_chart_settings = DB::table('tbl_chart_settings_pss')
            ->get();


        $data = [
            'logo1' => $imageData1,
            'logo2' => $imageData2,
            'footer' => $imageData3,
            'date' => $yy,
            'date_today' => $dateMonthInWordFormat,
            'hospital_name' => $hospital_name,
            'manager_name' => $query_doctor[0]->doctor_name,
            'manager_lastname' => $query_doctor[0]->doctor_name,
            'position' => $query_doctor[0]->position,
            'monthYear' => $yy,
            'mm_string' => $dateInWordFormat,
            'total_respondents' => $bb_arr_count,
            'total_avg1' => $results[0]->total_avg1,
            'total_avg2' => $results[0]->total_avg2,
            'total_avg3' => $results[0]->total_avg3,
            'total_avg4' => $results[0]->total_avg4,
            'total_avg5' => $results[0]->total_avg5,
            'total_avg6' => $results[0]->total_avg6,
            'total_avg7' => $results[0]->total_avg7,
            'total_avg8' => $results[0]->total_avg8,
            'total_avg9' => $results[0]->total_avg9,
            'total_avg10' => $results[0]->total_avg10,
            'total_avg11' => $results[0]->total_avg11,
            'total_avg12' => $results[0]->total_avg12,
            'total_avg13' => $results[0]->total_avg13,
            'total_avg14' => $results[0]->total_avg14,
            'overall_average' => $results[0]->overall_average,
            'degree_satisfaction_remarks' => $degree_satisfaction_remarks,
            'overall_performance_remarks' => $overall_performance_remarks,
            'radio1_a_avg' => $results[0]->radio1_a_avg,
            'radio1_b_avg' => $results[0]->radio1_b_avg,
            'radio1_c_avg' => $results[0]->radio1_c_avg,
            'radio1_d_avg' => $results[0]->radio1_d_avg,
            'radio1_e_avg' => $results[0]->radio1_e_avg,
            'radio1_f_avg' => $results[0]->radio1_f_avg,
            'radio1_g_avg' => $results[0]->radio1_g_avg,
            'radio2_a_avg' => $results[0]->radio2_a_avg,
            'radio2_b_avg' => $results[0]->radio2_b_avg,
            'radio2_c_avg' => $results[0]->radio2_c_avg,
            'radio2_d_avg' => $results[0]->radio2_d_avg,
            'radio2_e_avg' => $results[0]->radio2_e_avg,
            'radio3_a_avg' => $results[0]->radio3_a_avg,
            'radio3_b_avg' => $results[0]->radio3_b_avg,
            'radio3_c_avg' => $results[0]->radio3_c_avg,
            'radio3_d_avg' => $results[0]->radio3_d_avg,
            'radio3_e_avg' => $results[0]->radio3_e_avg,
            'radio4_a_avg' => $results[0]->radio4_a_avg,
            'radio4_b_avg' => $results[0]->radio4_b_avg,
            'radio4_c_avg' => $results[0]->radio4_c_avg,
            'radio4_d_avg' => $results[0]->radio4_d_avg,
            'radio5_a_avg' => $results[0]->radio5_a_avg,
            'radio5_b_avg' => $results[0]->radio5_b_avg,
            'radio5_c_avg' => $results[0]->radio5_c_avg,
            'radio5_d_avg' => $results[0]->radio5_d_avg,
            'radio5_e_avg' => $results[0]->radio5_e_avg,
            'radio6_a_avg' => $results[0]->radio6_a_avg,
            'radio6_b_avg' => $results[0]->radio6_b_avg,
            'radio6_c_avg' => $results[0]->radio6_c_avg,
            'radio6_d_avg' => $results[0]->radio6_d_avg,
            'radio6_e_avg' => $results[0]->radio6_e_avg,
            'radio7_a_avg' => $results[0]->radio7_a_avg,
            'radio7_b_avg' => $results[0]->radio7_b_avg,
            'radio7_c_avg' => $results[0]->radio7_c_avg,
            'radio7_d_avg' => $results[0]->radio7_d_avg,
            'radio7_e_avg' => $results[0]->radio7_e_avg,
            'radio8_a_avg' => $results[0]->radio8_a_avg,
            'radio8_b_avg' => $results[0]->radio8_b_avg,
            'radio8_c_avg' => $results[0]->radio8_c_avg,
            'radio8_d_avg' => $results[0]->radio8_d_avg,
            'radio8_e_avg' => $results[0]->radio8_e_avg,
            'radio9_a_avg' => $results[0]->radio9_a_avg,
            'radio9_b_avg' => $results[0]->radio9_b_avg,
            'radio9_c_avg' => $results[0]->radio9_c_avg,
            'radio9_d_avg' => $results[0]->radio9_d_avg,
            'radio9_e_avg' => $results[0]->radio9_e_avg,
            'radio10_a_avg' => $results[0]->radio10_a_avg,
            'radio10_b_avg' => $results[0]->radio10_b_avg,
            'radio10_c_avg' => $results[0]->radio10_c_avg,
            'radio10_d_avg' => $results[0]->radio10_d_avg,
            'radio10_e_avg' => $results[0]->radio10_e_avg,
            'radio11_a_avg' => $results[0]->radio11_a_avg,
            'radio11_b_avg' => $results[0]->radio11_b_avg,
            'radio11_c_avg' => $results[0]->radio11_c_avg,
            'radio11_d_avg' => $results[0]->radio11_d_avg,
            'radio12_a_avg' => $results[0]->radio12_a_avg,
            'radio12_b_avg' => $results[0]->radio12_b_avg,
            'radio12_c_avg' => $results[0]->radio12_c_avg,
            'radio12_d_avg' => $results[0]->radio12_d_avg,
            'radio12_e_avg' => $results[0]->radio12_e_avg,
            'radio13_a_avg' => $results[0]->radio13_a_avg,
            'radio13_b_avg' => $results[0]->radio13_b_avg,
            'radio13_c_avg' => $results[0]->radio13_c_avg,
            'radio13_d_avg' => $results[0]->radio13_d_avg,
            'radio13_e_avg' => $results[0]->radio13_e_avg,
            'radio14_a_avg' => $results[0]->radio14_a_avg,
            'radio14_b_avg' => $results[0]->radio14_b_avg,
            'radio14_c_avg' => $results[0]->radio14_c_avg,
            'radio14_d_avg' => $results[0]->radio14_d_avg,
            'radio14_e_avg' => $results[0]->radio14_e_avg,
            'comments' => $chunkedArray_comment,
            'municipality' => $bb_arr,
            'municipality_total' => $bb_arr_count,
            'chart1' => $convertedArray1,
            'chart2' => $convertedArray2,
            'chart1_total' => $percentages_chart1,
            'chart2_total' => $percentages_chart2,
            'chart_settings' => $results_chart_settings[0]->chart_name,
            'highest_chart1' => $highestValue1,
            'highest_chart2' => $highestValue2,
            'highest_chart1_index' => $index1,
            'highest_chart2_index' => $index2,
            'lowest_chart1' => $lowestValue1,
            'lowest_chart2' => $lowestValue2,
            'lowest_chart1_index' => $index1_min,
            'lowest_chart2_index' => $index2_min,
        ];

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
            return view('report_pss', $data);
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
