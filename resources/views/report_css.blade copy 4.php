<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Table with Bottom Borders</title>
        <style>
            body {
                margin: 5px 15%;
                width: 70%;
            }

            .center-div {
                position: re;
                top: 50%;
                left: 50%;
                bottom: 300%;
                transform: translate(-50%, -50%);
            }

            .image-container {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .left-image,
            .right-image {
                max-width: 100px;
                /* Adjust image size as needed */
                height: auto;
            }

            .left-image {
                order: -1;
                /* Places the image on the left */
                margin-right: 20px;
                /* Adjust as needed */
            }

            .right-image {
                order: 1;
                /* Places the image on the right */
                margin-left: 20px;
                /* Adjust as needed */
            }

            .maintable table>tfoot:last-child {

                bottom: 0;
                width: 100%;
                text-align: center;
                background-color: red;
            }



            .comment_table>table {
                border-collapse: collapse;
                width: 100%;
            }

            .comment_table>table,
            th,
            td {
                border: 1px solid black;
            }

            @media print {


                body {
                    margin: 5px 5px;
                    width: 8.5in;
                    height: 13in;
                    box-sizing: border-box
                }


                tfoot:last-child>tr {
                    position: fixed;
                    bottom: 0;
                    width: 100%;
                    text-align: center;
                    letter-spacing: 1px;
                    background-color: red;
                }

                .maintable table>tfoot:last-child {

                    bottom: 0;
                    width: 100%;
                    text-align: center;
                    background-color: red;
                }



                .dynamic-padding {
                    padding-bottom: 10px;
                    /* Initial padding - can be any value */
                }

                .center-div {
                    position: re;
                    top: 50%;
                    left: 50%;
                    bottom: 300%;
                    transform: translate(-50%, -50%);
                }

                .image-container {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .left-image,
                .right-image {
                    max-width: 100px;
                    /* Adjust image size as needed */
                    height: auto;
                }

                .left-image {
                    order: -1;
                    /* Places the image on the left */
                    margin-right: 20px;
                    /* Adjust as needed */
                }

                .right-image {
                    order: 1;
                    /* Places the image on the right */
                    margin-left: 20px;
                    /* Adjust as needed */
                }

                .title {
                    text-align: center;
                    font-size: 11px;
                    /* Adjust font size as needed */
                    font-weight: bold;
                }

                .title p {
                    word-wrap: break-word;
                    /* Allows long words to break and wrap onto the next line */
                }

                .content {
                    page-break-inside: avoid;
                    /* Prevent breaking inside the content div */
                }

                .comment_table>table {
                    page-break-inside: auto;

                    /* Ensure table rows break across pages */
                }

                .comment_table>tr {
                    page-break-inside: avoid;
                    /* Prevent individual rows from breaking across pages */
                }

                .comment_table>tr:last-child {
                    page-break-inside: auto;
                    /* Allow the last row to break across pages if needed */
                }

                .comment_table ul {
                    margin: 5px;
                    padding: 10px;
                    list-style: none;
                    /* Remove default list styling */
                }
            }

            @page {
                size: Legal;
                margin: 0;
            }
        </style>
    </head>

    <body>

        <table class="maintable">
            <thead>
                <tr>
                    <div>
                        <img src="/images/seal_laguna.png" alt="" width="50" height="50" class="left-image">
                        <div class="title">
                            <p contenteditable="true">Republic of the Philippines</p>
                            <p contenteditable="true"><b>INTERNAL AUDIT SERVICES</b></p>
                            <p contenteditable="true"><b>PROVINCIAL GOVERNMENT OF
                                    LAGUNA</b></p>
                            <p contenteditable="true">Pedro Guevara Street, Santa Cruz Laguna
                            </p>
                            <p contenteditable="true">Email Address:audit@laguna.gov.ph
                                501-3413</p>
                        </div>

                        <img src="data:image/png;base64,{{ $logo2 }}" height="60" width="60"
                            class="right-image">
                    </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>

                    <table>
                        <p contenteditable="true">{{ $date_issued }}</p>
                        <p contenteditable="true"><b>{{ $manager }}</b></p>
                        <p contenteditable="true">{{ $office_name }}</p>
                        <p contenteditable="true">Dear {{ $manager_lastname }}</p>
                        <span contenteditable="true" style="text-align:justify">
                            This is to inform you of the <b>{{ $current_month }} Customer Satisfaction(CSAT)</b>
                            result of the
                            department. The result revealed that your <b>{{ $total_respondents_words }}
                                ({{ $total_respondents }}) clients</b> were
                            <b>{{ $degree_satisfaction_remarks }}</b> with the kind of service they got from
                            your personnel.
                            @if ($invalidated > 0)
                                <b>{{ $invalidated_words }} ({{ $invalidated }}) accomplished</b> CSQ were
                                invalidated as the requested service were not clearly
                                identified on the form.
                            @endif
                            Accordingly, the <b>{{ $office_name }}</b> was
                            <b>{{ $overall_performance_remarks }}</b> in its service performance during the
                            said month.
                        </span>
                        <p>The following were the detailed results culled from the retrieved Customer
                            Satisfaction
                            Questionnaire(CSQ) responses:</p>
                    </table>
                    <table id="table" class="custom-table table-bordered" border=1>
                        <thead>
                            <tr>
                                <th>Services Rendered</th>
                                <th>Total No of Respondents</th>
                                <th>Delivery of Service</th>
                                <th>Communication</th>
                                <th>Quality of Staff</th>
                                <th>Quality of Work</th>
                                <th>Problem Solving</th>
                                <th>Average</th>
                            </tr>
                        </thead>
                        @foreach ($results[0] as $key => $item)
                            <tr>
                                <td>{{ $item->service_name }}</td>
                                <td style="text-align:center">{{ $item->total_respondents }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $item->delivery_service, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $item->communications, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $item->quality_staff, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $item->quality_work, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $item->problem_solving, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $item->average, 2) }}</td>
                            </tr>
                        @endforeach

                        @if (count($results) === 1)
                            <tr>
                                <td>Overall Result</td>
                                <td style="text-align:center">{{ $total_respondents }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $overall_delivery_service, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $overall_communications, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $overall_quality_staff, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $overall_quality_work, 2) }}</td>
                                <td style="text-align:center">
                                    {{ number_format((float) $overall_problem_solving, 2) }}</td>
                                <!-- <td>{{ number_format((float) $overall_average, 2) }}</td> -->
                                <td style="text-align:center">@php
                                    $roundedNumber = floor($overall_average * 100) / 100;

                                    // Format the rounded number with two decimal places
                                    echo $formattedNumber = number_format($roundedNumber, 2, '.', '');
                                @endphp</td>
                            </tr>
                        @endif
                    </table>

                    <div class="comment_table">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="12"><b>Comments and Suggestions</b>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments_arr1 as $keys1 => $comment_items_1)
                                    @if ($keys1 == 0)
                                        @foreach ($comment_items_1 as $keys2 => $comment_items_2)
                                            <tr>
                                                {{-- {{ $comment_items_2->service_name }} --}}
                                                @if (empty($comment_items_2['comment']))
                                                @else
                                                @endif

                                                @foreach ($comment_items_2['comment'] as $keys3 => $comment_items_3)
                                                    {{-- <li>{{ $comment_items_3->services_name }}</li> --}}

                                                    @foreach ($comment_items_3 as $keys3 => $comment_items_4)
                                                        <td>
                                                            <ul>
                                                                <li>{{ $comments_arr1[$keys1][$keys2]['service_name'] }}
                                                                </li>
                                                                <ul>
                                                                    <li>
                                                                        {{ $comment_items_4 }}

                                                                    </li>
                                                                </ul>

                                                        </td>
                                                    @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <td>

                        <footer>
                            <img src="data:image/png;base64,{{ $logo3 }}" height="40" width="100"
                                alt="Image">
                        </footer>

                    </td>
                </tr>
            </tfoot>
        </table>


    </body>

</html>
