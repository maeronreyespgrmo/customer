<!DOCTYPE html>
<html lang="en">
    <title>
        Customer Satisfaction System
    </title>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Example</title>
        <style>
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

            body {
                margin: 5px 15%;
                width: 70%;
            }

            @media print {

                .comments_table {
                    border-collapse: collapse;
                    background-color: red;
                    page-break-after: always;
                }

                .comments_table>tr {
                    border-collapse: collapse;
                    background-color: red;
                    page-break-before: always;
                }

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
            }
        </style>
    </head>

    <body class="dynamic-padding">
        <center>
            <table class="maintable" style="overflow:hidden;">
                <thead>
                    <tr>
                        <td>

                            <div class="image-container">
                                <img src="/images/seal_laguna.png" alt="" width="50" height="50"
                                    class="left-image">
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
                        <td>
                            <div>
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
                                <div>
                                    <table id="table" class="custom-table table-bordered" border=1
                                        style="width: 100%;font-size:14px; margin-bottom:150px;">
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
                                    <table border="1"
                                        style="page-break-inside:auto;
                                               margin-top:-150px;
                                               width:100%;overflow:auto;"
                                        class="comments_table">
                                        <thead>
                                            <tr style="text-align:center">
                                                <th colspan="12"><b>Comments and Suggestions</b>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
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
                                                                        <li><b>
                                                                                <p>{{ $comments_arr1[$keys1][$keys2]['service_name'] }}
                                                                                </p>
                                                                            </b></li>
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
                                        </tbody>
                                        <tfoot>
                                        </tfoot>

                        </td>
                    </tr>
            </table>
            </div>


            </div>

            <div style="background-color:green;overflow:auto; height: auto;">
                <p><b>Analytics</b></p>
                <table>
                    <tr>
                        <td>
                            <div><b>Figure of 1: No of Respondents</b></div>
                            <div style="width:300px;height:125px"><canvas id="myChart1"></canvas></div>
                        </td>
                        <td>
                            <div contenteditable="true"><b>Figure 1 - No of Respondents</b>, presents
                                the number of
                                client-respondents
                                for <span id="date1"></span>. It is good that the department has
                                conducted its CSS this
                                {{ $current_month }} with

                                @if ($total_respondents <= 1)
                                    {{ $total_respondents_words }} ({{ $total_respondents }})
                                    respondent
                                @else
                                    {{ $total_respondents_words }} ({{ $total_respondents }})
                                    respondents
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
                <table>
                    <tr>
                        <td>
                            <div><b>Figure 2 - CSAT Rating</b></div>
                            <div style="width:300px;height:125px"><canvas id="myChart2"></canvas></div>
                        </td>
                        <td>
                            <div contenteditable="true"><b>Figure 2 - CSAT Ratings</b>, displays the
                                graphical comparison of the
                                department's ratings of <span id="date2"></span>
                                {{ $office_name }} rating is
                                <span id="csa_rating"></span>
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
                <br>
                <div contenteditable="true">It is recommended that the department shall</div>
                <ul>
                    <li contenteditable="true">religiously conduct CSS in every service encounter and
                        improve customer
                        participation by increasing the number of respondents not just through the paper
                        and pen format
                        but
                        also with the online CSS.</li>
                    <li contenteditable="true">
                        @if ($degree_satisfaction_remarks == 'Very Satisfied')
                            maintain the <b>{{ $overall_performance_remarks }}</b> Service performance
                            of the
                            department by
                            making the customers <b>Very Satisfied</b> in the next cycles;
                        @else
                            improve the <b>{{ $overall_performance_remarks }}</b> Service performance
                            of the department
                            by
                            making the customers <b>Very Satisfied</b> in the next cycles;
                        @endif
                    </li>

                    @if ($invalidated > 0)
                        <li contenteditable="true">


                            @if ($degree_satisfaction_remarks == 'Not Satisfied')
                                encourage the personnel to providing satisfactory services to the
                                customers during
                                department
                                meeting
                            @else
                                recognize the personnel with their effort of providing satisfactory
                                services to the
                                customers
                                during department meeting
                            @endif
                        </li>
                    @endif
                    <li contenteditable="true">
                        use the analytics provided to track the department's performance and ensure that
                        the number of
                        respondents keep increasing without compromising quality service delivery
                    </li>
                </ul>
            </div>
            <br>
            <div contenteditable="true">
                Thank you very much for you cooperation. Let us continue the Serbisyong Tama!
            </div>
            <br>

            <div style="position:relative;margin-left:50px;">
                <table border=0 style="width:100%">
                    <tr>
                        <td colspan="4">
                            <div class="signature-1">
                                <div>
                                    Respectfully,
                                </div>

                                <p style="line-height: 1.2;">&nbsp;</p>
                                <p style="line-height: 1.2;">&nbsp;</p>

                                <div contenteditable="true">
                                    <b>Ms.Maria A.Lim</b>
                                </div>

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

                                <p style="line-height: 1.2;">&nbsp;</p>
                                <p style="line-height: 1.2;">&nbsp;</p>

                                <div contenteditable="true">
                                    <b>Atty. Dulce H. Rebanal</b>
                                </div>

                                <div contenteditable="true">
                                    Provincial Administrator
                                </div>
                        </td>
                    </tr>
                </table>
            </div>
            </div>
            <div
                style="width:100%;background-color:red;>
            </div>
            <div style="width:100%;background-color:red;>
            </div>
            </td>
            </tr>

            </tbody>

            <!---<tfoot class="lastfoot">
                <tr>
                    <td>

                        <footer>
                            <img src="data:image/png;base64,{{ $logo3 }}" height="40" width="100"
                                alt="Image">
                        </footer>

                    </td>
                </tr>



            </tfoot>-->
            </table>
        </center>
        <script src="../../../../../js/chart.js"></script>
        <script>
            window.onload = function() {
                const table = document.querySelector('#table');

                const tfoot = table.querySelector('tfoot:last-child');
                console.log(tfoot)

                if (tfoot !== null) {
                    //tfoot.remove();
                    // Or alternatively, you can hide the last tfoot
                    tfoot.style.display = 'none';
                }
            };
            let array_value1 = Object.values(@json($chart1[0]));
            let array_month1 = Object.keys(@json($chart1[0])).map(x => x.toUpperCase());

            let array_value2 = Object.values(@json($chart2[0]));
            let array_month2 = Object.keys(@json($chart2[0]));

            let csa_array_value = Object.values(@json($chart2[0]));

            let yearString = {{ $yearString }}
            let prevyearString = {{ $yearString }} - 1

            console.log("Original_Month 1", array_month1)
            console.log("Original_Array 1", array_value1)

            console.log("Original_Month 2", array_month2)
            console.log("Original_Array 2", array_value2)

            let chart_settings = @json($chart_settings)

            let value1 = @json($monthString);
            let value2 = @json($monthString);
            let rr_month1 = 12 - value1;
            let rr_month2 = 12 - value2;
            array_value1.splice(value1, rr_month1)
            array_month1.splice(value1, rr_month1)
            array_value2.splice(value2, rr_month2)
            array_month2.splice(value2, rr_month2)
            csa_array_value.splice(value2, rr_month2)

            console.log("Splice_Month 1", array_month1)
            console.log("Splice_Array 1", array_value1)

            console.log("Splice_Month 2", array_month2)
            console.log("Splice_Array 2", array_value2)

            if (value1 == 01) {
                console.log(array_value2)

                array_month1 = array_month1.filter(month => month !== "TOTAL").reverse();
                array_month2 = array_month2.filter(month => month !== "AVERAGE").reverse();
                array_value1 = array_value1.filter((x, y) => y !== 2).reverse();
                array_value2 = array_value2.filter((x, y) => y !== 2).reverse();

                array_month1[0] = `DEC ${prevyearString}`;
                array_month2[0] = `DEC ${prevyearString}`;
                array_month1[1] = `JAN ${yearString}`;
                array_month2[1] = `JAN ${yearString}`;

                if (array_month1.length == 1) {
                    array_value1.unshift(0);
                    array_month1.unshift("DECEMBER");
                    const [firstElement, ...restOfArray] = array_month1;
                    const lastElement = array_month1[array_month1.length - 1];
                    document.getElementById("date1").innerHTML =
                        `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} TO ${lastElement}`
                } else {
                    const [firstElement, ...restOfArray] = array_month1;
                    const lastElement = array_month1[array_month1.length - 1];
                    document.getElementById("date1").innerHTML =
                        `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} TO ${lastElement}`
                }

                if (array_month2.length == 1) {
                    array_value2.unshift(0);
                    array_month2.unshift("DECEMBER");
                    const [firstElement, ...restOfArray] = array_month2;
                    const lastElement = array_month2[array_month2.length - 1];
                    document.getElementById("date2").innerHTML = `${firstElement.replace("PREV_DEC","DEC")} TO ${lastElement}`
                } else {
                    const [firstElement, ...restOfArray] = array_month2;
                    const lastElement = array_month2[array_month2.length - 1];
                    document.getElementById("date2").innerHTML = `${firstElement.replace("PREV_DEC","DEC")} TO ${lastElement}`
                }
            } else {
                console.log(array_value2.length)
                console.log(array_value2)
                array_month1 = array_month1.filter(month => month !== "PREV_DEC");
                array_month2 = array_month2.filter(month => month !== "PREV_DEC");
                array_value1 = array_value1.filter((x, y) => y !== array_value1.length - 2);
                array_value2 = array_value2.filter((x, y) => y !== array_value2.length - 2);
                csa_array_value = csa_array_value.filter((x, y) => y !== csa_array_value.length - 2);
                console.log(array_value2)
                let csa_rating = csa_array_value.filter((x, y, z) => y !== z.length - 1)

                console.log("Final_Month 1", array_month1)
                console.log("Final_Array 1", array_value1)

                console.log("Final_Month 2", array_month2)
                console.log("Final_Array 2", array_value2)

                console.log("CSA Final_Array", csa_array_value)

                let result_csa_rating = csa_rating.join(" and ");
                if (array_month1.length == 1) {
                    array_value1.unshift(0);
                    array_month1.unshift("DECEMBER");
                    const [firstElement, ...restOfArray] = array_month1;
                    const lastElement = array_month1[array_month1.length - 2];
                    document.getElementById("date1").innerHTML =
                        `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
                    document.getElementById("csa_rating").innerHTML = `${result_csa_rating} respectively`
                } else {
                    const [firstElement, ...restOfArray] = array_month1;
                    const lastElement = array_month1[array_month1.length - 2];
                    document.getElementById("date1").innerHTML =
                        `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
                }

                if (array_month2.length == 1) {
                    array_value2.unshift(0);
                    array_month2.unshift("DECEMBER");
                    const [firstElement, ...restOfArray] = array_month2;
                    const lastElement = array_month2[array_month2.length - 2];
                    document.getElementById("date2").innerHTML =
                        `${firstElement.replace("PREV_DEC","DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
                } else {
                    const [firstElement, ...restOfArray] = array_month2;
                    const lastElement = array_month2[array_month2.length - 2];
                    document.getElementById("date2").innerHTML =
                        `${firstElement.replace("PREV_DEC","DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
                    document.getElementById("csa_rating").innerHTML = `${result_csa_rating} respectively`
                }
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
                <a href="javascript:void(0);" onclick="window.print();">Print
                    as PDF</a>
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
