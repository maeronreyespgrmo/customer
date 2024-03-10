<!-- PAGE 1 -->

<html>

<head>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-size: 8px;
        }

        .font-11 {
            font-size: 9pt;
        }

        @media print {
            br {
                display: none;

            }

            * {
                margin: 0;
                padding: 0;
            }

            body {
                font-size: 6px;
            }

            .page-break {
                page-break-after: always;
            }

            .custom-table {
                font-size: 8px;
                /* Change the font size as per your preference */
            }

            footer {
                position: fixed;
                bottom: 0;
                left: 0px;
                right: 0px;
            }
        }

        @page {
            size: Legal;
            margin: 0 10px;
        }
    </style>
    <link href="../../../../../css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="container md-4">
        <header>
            <center>
                <table style="width: 70%;">
                    <tr>
                        <td width="15%">
                            <center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
                                    align="left"> </center>
                        </td>
                        <td align="center">
                            <p contenteditable="true" class="font-11">Republic of the Philippines</p>
                            <p contenteditable="true" class="font-11">INTERNAL AUDIT SERVICES</p>
                            <p contenteditable="true" style="font-size: 12pt"><b>PROVINCIAL GOVERNMENT OF LAGUNA</b></p>
                            <p contenteditable="true" class="font-11">Pedro Guevara Street, Santa Cruz Laguna</p>
                            <p contenteditable="true" class="font-11">Email Address:audit@laguna.gov.ph
                                501-3413</p>
                        </td>
                        <td width="15%"><img src="data:image/png;base64,{{ $logo2 }}" height="90"
                                width="90" alt="Image"></td>
                    </tr>
                </table>
            </center>
        </header>

        <footer>

        </footer>
        <div>
            <p contenteditable="true">{{ $date_issued }}</p>
            <p contenteditable="true"><b>{{ $manager }}</b></p>
            <p contenteditable="true">{{ $office_name }}</p>
            <p contenteditable="true">Dear {{ $manager_lastname }}</p><br>
            <span contenteditable="true">
                This is to inform you of the <b>{{ $current_month }} Customer Satisfaction(CSAT)</b> result of the
                department. The result revealed that your <b>{{ $total_respondents }} clients</b> were
                <b>{{ $degree_satisfaction_remarks }}</b> with the kind of service they got from your personnel.
                <b>{{ $invalidated }} accomplished</b> CSQ were invalidated as the requested service were not clearly
                identified on the form. Accordingly, the <b>{{ $office_name }}</b> was
                <b>{{ $overall_performance_remarks }}</b> in its service performance during the said month.</span>
            <p>The following were the detailed results culled from the retrieved Customer Satisfaction
                Questionnaire(CSQ) responses:</p><br>
            <table class="custom-table table-bordered" style="width: 100%;font-size:11px;">
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
                        <td>{{ $item->total_respondents }}</td>
                        <td>{{ $item->delivery_service }}</td>
                        <td>{{ $item->communications }}</td>
                        <td>{{ $item->quality_staff }}</td>
                        <td>{{ $item->quality_work }}</td>
                        <td>{{ $item->problem_solving }}</td>
                        <td>{{ $item->average }}</td>
                    </tr>
                @endforeach

                @if (count($results) === 1)
                    <tr>
                        <td>Overall Result</td>
                        <td>{{ $total_respondents }}</td>
                        <td>{{ $overall_delivery_service }}</td>
                        <td>{{ $overall_communications }}</td>
                        <td>{{ $overall_quality_staff }}</td>
                        <td>{{ $overall_quality_work }}</td>
                        <td>{{ $overall_problem_solving }}</td>
                        <td>{{ $overall_average }}</td>
                    </tr>

                    <tr>
                        <td colspan="8">Comments and Suggestions were lifted from CSQ verbatim</td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <ul id="comment">
                                @php
                                    $counter = 0;
                                @endphp
                                @foreach ($comments_arr1 as $keys1 => $comment_items_1)
                                    @if ($keys1 == 0)
                                        @foreach ($comment_items_1 as $keys2 => $comment_items_2)
                                            {{-- {{ $comment_items_2->service_name }} --}}
                                            @if (empty($comment_items_2['comment']))
                                            @else
                                                <li><b><p>{{ $comments_arr1[$keys1][$keys2]['service_name'] }}</p></b></li>
                                            @endif

                                            @foreach ($comment_items_2['comment'] as $keys3 => $comment_items_3)
                                                {{-- <li>{{ $comment_items_3->services_name }}</li> --}}
                                                <ul>
                                                    @foreach ($comment_items_3 as $keys3 => $comment_items_4)
                                                        <li>{{ $comment_items_4 }}</li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach

                            </ul>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
        <center>
            <footer>
                <img src="data:image/png;base64,{{ $logo3 }}" height="50" width="100" alt="Image">
            </footer>
        </center>
    </div>
    
    <div class="page-break"></div>
    <script>
        var tdElement = document.getElementById('comment'); // Replace 'myTableCell' with the actual ID of your <td> element
        console.log(document.getElementById('comment').innerHTML)
        if (tdElement.innerHTML.trim() == '') {
            // If the <td> is empty, insert text

            tdElement.textContent = 'NO INDICATED COMMENT/S';
        }
    </script>
</body>

</html>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
@foreach ($results as $key => $result_item)
    @if ($key === 0)
    @else
        <html>

        <head>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                }

                body {
                    font-size: 12px;
                }

                .font-11 {
                    font-size: 9pt;
                }

                .custom-table {
                    font-size: 12px;
                    /* Change the font size as per your preference */
                }

                @media print {
                    * {
                        margin: 0;
                        padding: 0;
                    }

                    body {
                        font-size: 12px;
                    }

                    .page-break {
                        page-break-after: always;
                    }

                    .custom-table {
                        font-size: 12px;
                        /* Change the font size as per your preference */
                    }

                    footer {
                        position: fixed;
                        bottom: 0;
                        left: 0px;
                        right: 0px;
                    }
                }
                @page {
            size: Legal;
            margin: 0;
        }
            </style>
            <link href="../../../../../../css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
                crossorigin="anonymous">
        </head>

        <body>
            <div class="container md-4">
                <header>
                    <table style="width: 100%;">
                        <tr>
                            <td width="15%">
                                <center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
                                        align="left"> </center>
                            </td>
                            <td align="center">
                                <p contenteditable="true" class="font-11">Republic of the Philippines</p>
                                <p contenteditable="true" class="font-11">INTERNAL AUDIT SERVICES</p>
                                <p contenteditable="true" style="font-size: 12pt"><b>PROVINCIAL GOVERNMENT OF LAGUNA</b>
                                </p>
                                <p contenteditable="true" class="font-11">Pedro Guevara Street, Santa Cruz Laguna</p>
                                <p contenteditable="true" class="font-11">Email Address:audit@laguna.gov.ph
                                    501-3413</p>
                            </td>
                            <td width="15%"><img src="data:image/png;base64,{{ $logo2 }}" height="90"
                                    width="90" alt="Image"></td>
                        </tr>
                    </table>
                </header>

                <footer>

                </footer>

                <table class="custom-table table-bordered" style="width: 100%;font-size:11px;">
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
                    @foreach ($result_item as $key => $item)
                        <tr>
                            <td>{{ $item->service_name }}</td>
                            <td>{{ $item->total_respondents }}</td>
                            <td>{{ $item->delivery_service }}</td>
                            <td>{{ $item->communications }}</td>
                            <td>{{ $item->quality_staff }}</td>
                            <td>{{ $item->quality_work }}</td>
                            <td>{{ $item->problem_solving }}</td>
                            <td>{{ $item->average }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Overall Result</td>
                        <td>{{ $total_respondents }}</td>
                        <td>{{ $overall_delivery_service }}</td>
                        <td>{{ $overall_communications }}</td>
                        <td>{{ $overall_quality_staff }}</td>
                        <td>{{ $overall_quality_work }}</td>
                        <td>{{ $overall_problem_solving }}</td>
                        <td>{{ $overall_average }}</td>
                    </tr>

                    <tr>
                        <td colspan="8">Comments and Suggestions were lifted from CSQ verbatim</td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <ul id="comment">
                                @php
                                    $counter = 0;
                                @endphp
                                @foreach ($comments_arr1 as $keys1 => $comment_items_1)
                                    @if (empty($comments_arr1['comment']))
                                        <li>NO INDICATED COMMENT/S</li>
                                    @endif
                                    @if ($keys1 == 0)
                                        @foreach ($comment_items_1 as $keys2 => $comment_items_2)
                                            @if (empty($comment_items_2['comment']))
                                            @else
                                                <li><b>{{ $comments_arr1[$keys1][$keys2]['service_name'] }}</b></li>
                                            @endif

                                            @foreach ($comment_items_2['comment'] as $keys3 => $comment_items_3)
                                                {{-- <li>{{ $comment_items_3->services_name }}</li> --}}
                                                <ul>
                                                    @foreach ($comment_items_3 as $keys3 => $comment_items_4)
                                                        <li>{{ $comment_items_4 }}</li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach

                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
            <center>
                <footer>
                    <img src="data:image/png;base64,{{ $logo3 }}" height="50" width="100" alt="Image">
                </footer>
            </center>
            </div>


            <div class="page-break"></div>
            <script>
                var tdElement = document.getElementById('comment'); // Replace 'myTableCell' with the actual ID of your <td> element
                console.log(document.getElementById('comment').innerHTML)
                if (tdElement.innerHTML.trim() == '') {
                    // If the <td> is empty, insert text

                    tdElement.textContent = 'NO INDICATED COMMENT/S';
                }
            </script>
        </body>

        </html>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    @endif
@endforeach
<!---COMMENTSPAGE FIRST 50---->
@foreach ($comments_arr1 as $keys1 => $comment_items_1)
    @foreach ($comment_items_1 as $keys2 => $comment_items_2)
        @if ($keys1 != 0)
            <html>

            <head>
                <style>
                    * {
                        margin: 0;
                        padding: 0;
                    }

                    body {
                        font-size: 12px;
                    }

                    .font-11 {
                        font-size: 9pt;
                    }

                    .custom-table {
                        font-size: 12px;
                        /* Change the font size as per your preference */
                    }

                    @media print {
                        * {
                            margin: 0;
                            padding: 0;
                        }

                        body {
                            font-size: 12px;
                        }

                        .page-break {
                            page-break-after: always;
                        }

                        .custom-table {
                            font-size: 12px;
                            /* Change the font size as per your preference */
                        }

                        footer {
                            position: fixed;
                            bottom: 0;
                            left: 0px;
                            right: 0px;
                        }
                    }
                    @page {
            size: Legal;
            margin: 0;
        }
                </style>
                <link href="../../../../../../css/bootstrap.min.css" rel="stylesheet"
                    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
                    crossorigin="anonymous">
            </head>

            <body>
                <div class="container md-4">
                    <header>
                        <center>
                            <table style="width: 70%;">
                                <tr>
                                    <td width="15%">
                                        <center> <img src="/images/seal_laguna.png" alt="" width="80"
                                                height="80" align="left"> </center>
                                    </td>
                                    <td align="center">
                                        <p contenteditable="true" class="font-11">Republic of the Philippines</p>
                                        <p contenteditable="true" class="font-11">INTERNAL AUDIT SERVICES</p>
                                        <p contenteditable="true" style="font-size: 12pt"><b>PROVINCIAL GOVERNMENT
                                                OF
                                                LAGUNA</b>
                                        </p>
                                        <p contenteditable="true" class="font-11">Pedro Guevara Street, Santa Cruz
                                            Laguna
                                        </p>
                                        <p contenteditable="true" class="font-11">Email
                                            Address:audit@laguna.gov.ph
                                            501-3413</p>
                                    </td>
                                    <td width="15%"><img src="data:image/png;base64,{{ $logo2 }}"
                                            height="90" width="90" alt="Image"></td>
                                </tr>
                            </table>
                        </center>
                    </header>

                    <footer>

                    </footer>
                    <div>
                        <table class="custom-table table-bordered" style="width: 100%;font-size:11px;">
                            <tr>
                                <td colspan="8">Comments and Suggestions were lifted from CSQ verbatim</td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    <ul>
                                        @if (empty($comment_items_2['comment']))
                                        @else
                                            <li><b>{{ $comments_arr1[$keys1][$keys2]['service_name'] }}</b></li>
                                        @endif

                                        @foreach ($comment_items_2['comment'] as $keys3 => $comment_items_3)
                                            {{-- <li>{{ $comment_items_3->services_name }}</li> --}}
                                            <ul>
                                                @foreach ($comment_items_3 as $keys3 => $comment_items_4)
                                                    <li>{{ $comment_items_4 }}</li>
                                                @endforeach
                                            </ul>
                                        @endforeach


                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <center>
                        <footer>
                            <img src="data:image/png;base64,{{ $logo3 }}" height="50" width="100"
                                alt="Image">
                        </footer>
                    </center>
                </div>


                <div class="page-break"></div>
            </body>

            </html>
        @endif
    @endforeach
@endforeach
<!-- PAGE 2 -->
<html>

<head>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-size: 12px;
        }

        .font-11 {
            font-size: 9pt;
        }

        .custom-table {
            font-size: 12px;
            /* Change the font size as per your preference */
        }

        @media print {
            * {
                margin: 0;
                padding: 0;
            }

            body {
                font-size: 12px;
            }

            .page-break {
                page-break-after: always;
            }

            .custom-table {
                font-size: 12px;
                /* Change the font size as per your preference */
            }

            footer {
                position: fixed;
                bottom: 0;
                left: 0px;
                right: 0px;
            }
        }
        @page {
            size: Legal;
            margin: 0;
        }
    </style>
    <link href="../../../../../../css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container md-4">
        <header>
            <center>
                <table style="width: 70%;">
                    <tr>
                        <td width="15%">
                            <center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
                                    align="left"> </center>
                        </td>
                        <td align="center">
                            <p contenteditable="true" class="font-11">Republic of the Philippines</p>
                            <p contenteditable="true" class="font-11">INTERNAL AUDIT SERVICES</p>
                            <p contenteditable="true" style="font-size: 12pt"><b>PROVINCIAL GOVERNMENT OF
                                    LAGUNA</b>
                            </p>
                            <p contenteditable="true" class="font-11">Pedro Guevara Street, Santa Cruz Laguna</p>
                            <p contenteditable="true" class="font-11">Email Address:audit@laguna.gov.ph
                                501-3413</p>
                        </td>
                        <td width="15%"><img src="data:image/png;base64,{{ $logo2 }}" height="90"
                                width="90" alt="Image"></td>
                    </tr>
                </table>
            </center>
        </header>

        <footer>

        </footer>
        <div>
            <p>Analytics</p>
            <p><b>Figure of 1: No of Respondents</b></p>
            <div style="width:500px;height:150px"><canvas id="myChart1"></canvas></div>
            <div contenteditable="true"><b>Figure 1 - No of Respondents</b>, presents the number of
                client-respondents
                for <span id="date1"></span>. It is good that the department has conducted its CSS this
                {{ $current_month }} with

                @if ($total_respondents <= 1)
                    {{ $total_respondents }} respondent
                @else
                    {{ $total_respondents }} respondents
                @endif
            </div>

            <div><b>Figure 2 - CSAT Rating</b></div>
            <div style="width:500px;height:150px"><canvas id="myChart2"></canvas></div>
            <div contenteditable="true"><b>Figure 2 - CSAT Ratings</b>, displays the graphical comparison of the
                department's ratings of <span id="date2"></span> {{ $office_name }} rating is
                {{ $overall_average }}</div>

            <div contenteditable="true">It is recommended that the department shall</div>
            <ul>
                <li contenteditable="true">religiously conduct CSS in every service encounter and improve customer
                    participation by increasing the number of respondents not just through the paper and pen format
                    but
                    also with the online CSS.</li>
                <li contenteditable="true">

                    @if ($degree_satisfaction_remarks == 'Very Satisfied')
                        maintain the <b>{{ $overall_performance_remarks }}</b> Service performance of the
                        department by
                        making the customers <b>Very Satisfied</b> in the next cycles;
                    @else
                        improve the <b>{{ $overall_performance_remarks }}</b> Service performance of the department
                        by
                        making the customers <b>Very Satisfied</b> in the next cycles;
                    @endif
                </li>


                <li contenteditable="true">

                    @if ($degree_satisfaction_remarks == 'Not Satisfied')
                        encourage the personnel to providing satisfactory services to the customers during
                        department
                        meeting
                    @else
                        recognize the personnel with their effort of providing satisfactory services to the
                        customers
                        during department meeting
                    @endif

                </li>
                <li contenteditable="true">
                    use the analytics provided to track the department's performance and ensure that the number of
                    respondents keep increasing without compromising quality service delivery
                </li>
            </ul>
        </div>

        <div contenteditable="true">
            Thank you very much for you cooperation. Let us continue the Serbisyong Tama!
        </div>
        <p style="line-height: 1.5;">&nbsp;</p>
        <p style="line-height: 1.5;">&nbsp;</p>
        <p style="line-height: 1.5;">&nbsp;</p>
        <div style="position:relative;margin-left:50px;">
            <table border=0 style="width:100%">
                <tr>
                    <td colspan="4">
                        <div class="signature-1">
                            <div>
                                Respectfully,
                            </div>
                            <p style="line-height: 1.5;">&nbsp;</p>

                            <div contenteditable="true">
                                <b>Ms.Maria A.Lim</b>
                            </div>
                            <br>
                            <div contenteditable="true">
                                Auditor IV
                            </div>
                        </div>
                    </td>
                    <td colspan="8">
                        <div class="signature-2">
                            <div contenteditable="true">
                                Noted by:
                            </div>
                            <p style="line-height: 1.5;">&nbsp;</p>

                            <div contenteditable="true">
                                <b>Atty. Dulce H. Rebanal</b>
                            </div>
                            <br>
                            <div contenteditable="true">
                                Provincial Administrator
                            </div>
                    </td>
                </tr>
            </table>
        </div>
        <center>
            <footer>
                <img src="data:image/png;base64,{{ $logo3 }}" height="50" width="100" alt="Image">
            </footer>
        </center>
    </div>


    <div class="page-break"></div>
    <script src="../../../../../js/chart.js"></script>
    <script>
        let array_value1 = Object.values(@json($chart1[0]));
        let array_month1 = Object.keys(@json($chart1[0])).map(x => x.toUpperCase());

        let array_value2 = Object.values(@json($chart2[0]));
        let array_month2 = Object.keys(@json($chart2[0]));

        let yearString = {{ $yearString }}
        let prevyearString = {{ $yearString }} - 1

        let chart_settings = @json($chart_settings)

        let value1 = @json($monthString);
        let value2 = @json($monthString);
        let rr_month1 = 12 - value1;
        let rr_month2 = 12 - value2;
        array_value1.splice(value1, rr_month1)
        array_month1.splice(value1, rr_month1)
        array_value2.splice(value2, rr_month2)
        array_month2.splice(value2, rr_month2)

        if (array_month1.length == 1) {
            array_value1.unshift(0);
            array_month1.unshift("DECEMBER");
            const [firstElement, ...restOfArray] = array_month1;
            const lastElement = array_month1[array_month1.length - 2];
            document.getElementById("date1").innerHTML = `${firstElement} ${prevyearString} TO ${lastElement} ${yearString}`
        } else {
            const [firstElement, ...restOfArray] = array_month1;
            const lastElement = array_month1[array_month1.length - 2];
            document.getElementById("date1").innerHTML = `${firstElement}  TO ${lastElement} ${yearString}`
        }

        if (array_month2.length == 1) {
            array_value2.unshift(0);
            array_month2.unshift("DECEMBER");
            const [firstElement, ...restOfArray] = array_month2;
            const lastElement = array_month2[array_month2.length - 2];
            document.getElementById("date2").innerHTML = `${firstElement} ${prevyearString} TO ${lastElement} ${yearString}`
        } else {
            const [firstElement, ...restOfArray] = array_month2;
            const lastElement = array_month2[array_month2.length - 2];
            document.getElementById("date2").innerHTML = `${firstElement}  TO ${lastElement} ${yearString}`
        }


        // Get the canvas element
        var ctx1 = document.getElementById('myChart1').getContext('2d');
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        // Create the chart
        var myChart = new Chart(ctx1, {
            type: chart_settings,
            data: {
                labels: array_month1,
                datasets: [{
                    label: 'Figure 1 No. of Respondents',
                    data: array_value1,
                    backgroundColor: [
                        'rgba(255, 0, 0)',
                        'rgba(0, 255, 0)',
                        'rgba(0, 0, 255)',
                        'rgba(255, 255, 0)',
                        'rgba(255, 0, 255)',
                        'rgba(0, 255, 255)',
                        'rgba(128, 0, 0)',
                        'rgba(0, 128, 0)',
                        'rgba(0, 0, 128)',
                        'rgba(128, 128, 0)',
                        'rgba(128, 0, 128)',
                        'rgba(0, 128, 128)',
                        'rgba(128, 128, 128)'
                    ],
                    borderColor: [
                        'rgba(255, 0, 0)',
                        'rgba(0, 255, 0)',
                        'rgba(0, 0, 255)',
                        'rgba(255, 255, 0)',
                        'rgba(255, 0, 255)',
                        'rgba(0, 255, 255)',
                        'rgba(128, 0, 0)',
                        'rgba(0, 128, 0)',
                        'rgba(0, 0, 128)',
                        'rgba(128, 128, 0)',
                        'rgba(128, 0, 128)',
                        'rgba(0, 128, 128)',
                        'rgba(128, 128, 128)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true, // Remove x-axis labels
                    },
                    y: {
                        beginAtZero: true,
                        display: true,
                    }
                },
                plugins: {
                    legend: {
                        display: false, // Remove the legend
                        labels: {
                            fontSize: 8 // Legend font size
                        }
                    }
                }
            }
        });


        var myChart2 = new Chart(ctx2, {
            type: chart_settings,
            data: {
                labels: array_month2,
                datasets: [{
                    label: 'Figure 2 CSAT Ratings',
                    data: array_value2,
                    backgroundColor: [
                        'rgba(255, 0, 0)',
                        'rgba(0, 255, 0)',
                        'rgba(0, 0, 255)',
                        'rgba(255, 255, 0)',
                        'rgba(255, 0, 255)',
                        'rgba(0, 255, 255)',
                        'rgba(128, 0, 0)',
                        'rgba(0, 128, 0)',
                        'rgba(0, 0, 128)',
                        'rgba(128, 128, 0)',
                        'rgba(128, 0, 128)',
                        'rgba(0, 128, 128)',
                        'rgba(128, 128, 128)'
                    ],
                    borderColor: [
                        'rgba(255, 0, 0)',
                        'rgba(0, 255, 0)',
                        'rgba(0, 0, 255)',
                        'rgba(255, 255, 0)',
                        'rgba(255, 0, 255)',
                        'rgba(0, 255, 255)',
                        'rgba(128, 0, 0)',
                        'rgba(0, 128, 0)',
                        'rgba(0, 0, 128)',
                        'rgba(128, 128, 0)',
                        'rgba(128, 0, 128)',
                        'rgba(0, 128, 128)',
                        'rgba(128, 128, 128)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false, // Remove the legend
                        labels: {
                            fontSize: 8 // Legend font size
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
<link rel="stylesheet" href="../../../../../css/webfonts/fontawesome.all.min.css">
<style>
    .floatingButtonWrap {
        display: block;
        position: fixed;
        bottom: 45px;
        right: 45px;
        z-index: 999999999;
    }

    .floatingButtonInner {
        position: relative;
    }

    .floatingButton {
        display: block;
        width: 90px;
        height: 90px;
        text-align: center;
        background: -webkit-linear-gradient(55deg, #0c0b0c, #507cb3);
        background: -o-linear-gradient(55deg, #8769a9, #507cb3);
        background: linear-gradient(55deg, #2ac676, #0e6de3);
        color: #fff;
        line-height: 50px;
        position: absolute;
        border-radius: 60% 60%;
        bottom: 0px;
        right: 0px;
        border: 5px solid #0e2a6f;
        /* opacity: 0.3; */
        opacity: 1;
        transition: all 0.4s;
    }

    .floatingButton .fa {
        font-size: 15px !important;
        line-height: 5;
    }

    .floatingButton.open,
    .floatingButton:hover,
    .floatingButton:focus,
    .floatingButton:active {
        opacity: 1;
        color: #fff;
    }


    .floatingButton .fa {
        transform: rotate(0deg);
        transition: all 0.4s;
    }

    .floatingButton.open .fa {
        transform: rotate(270deg);
    }

    .floatingMenu {
        position: absolute;
        bottom: 60px;
        right: 0px;
        /* width: 200px; */
        display: none;
    }

    .floatingMenu li {
        width: 100%;
        float: right;
        list-style: none;
        text-align: right;
        margin-bottom: 5px;
    }

    .floatingMenu li a {
        padding: 8px 15px;
        display: inline-block;
        background: #ccd7f5;
        color: #1244c2;
        border-radius: 5px;
        overflow: hidden;
        white-space: nowrap;
        transition: all 0.4s;
        /* -webkit-box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.22);
    box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.22); */
        -webkit-box-shadow: 1px 3px 5px rgba(211, 224, 255, 0.5);
        box-shadow: 1px 3px 5px rgba(211, 224, 255, 0.5);
    }

    .floatingMenu li a:hover {
        margin-right: 10px;
        text-decoration: none;
    }

    @media print {
        .floatingButtonWrap {
            display: none;
        }
    }

    @page {
            size: Legal;
            margin: 0;
        }
</style>

<div class="floatingButtonWrap">
    <div class="floatingButtonInner">
        <a href="#" class="floatingButton">
            <i class="fa fa-print icon-default"></i>
        </a>
        <ul class="floatingMenu">
            <li>
                <a href="#" onclick="window.print()">Print as PDF</a>
            </li>
            <li>
                <a href="/wordcss/{{ $monthString }}/{{ $yearString }}/{{ $month }}/{{ $office_name }}">Print
                    as Word Doc</a>
            </li>
        </ul>
    </div>
</div>
<script src="../../../../../js/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.floatingButton').on('click',
            function(e) {
                e.preventDefault();
                $(this).toggleClass('open');
                if ($(this).children('.fa').hasClass('fa-print')) {
                    $(this).children('.fa').removeClass('fa-print');
                    $(this).children('.fa').addClass('fa-print');
                } else if ($(this).children('.fa').hasClass('fa-print')) {
                    $(this).children('.fa').removeClass('fa-print');
                    $(this).children('.fa').addClass('fa-print');
                }
                $('.floatingMenu').stop().slideToggle();
            }
        );
        $(this).on('click', function(e) {

            var container = $(".floatingButton");
            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && $('.floatingButtonWrap').has(e.target).length === 0) {
                if (container.hasClass('open')) {
                    container.removeClass('open');
                }
                if (container.children('.fa').hasClass('fa-print')) {
                    container.children('.fa').removeClass('fa-print');
                    container.children('.fa').addClass('fa-print');
                }
                $('.floatingMenu').hide();
            }

            // if the target of the click isn't the container and a descendant of the menu
            if (!container.is(e.target) && ($('.floatingMenu').has(e.target).length > 0)) {
                $('.floatingButton').removeClass('open');
                $('.floatingMenu').stop().slideToggle();
            }
        });
    });
</script>
