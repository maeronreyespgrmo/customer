<!DOCTYPE html>
<html>

<script type="text/javascript">
// window.print();
// alert('dd');
</script>
<style type="text/css">

body {
font-family: "Nunito", Serif;
font-size: 12pt;
}

p {
margin: 0px;
}

.logo {
height: 120px;
width: 120px;
}

th {
text-align: left;
}

.header-text {
color: #002060;
}

@page {
    size: Legal;
    margin: 10cm 2cm;
}
.container {
width: 8.5in;
height: 13in;
border: none !important;
padding: none !important;
}

.indent {
margin-left: 150px;
}

.c-8 {
width: 12.5%;
}

.c-4 {
width: 25%;
}


.container1 {
width: 8.5in;
height: 13in;
border: solid 2px #eee;
padding: 25px;
}

.justify {
text-align: justify !important;
}

br {
display: block;

}


.center-div{
display: block;
padding: 20px;
margin: 0 auto;
}
.custom-table {
font-size: 8px;
/* Change the font size as per your preference */
}

@media print {
/* br {
display: none;

} */

.page-break {
page-break-after: always;
}

.custom-table {
font-size: 8px;
/* Change the font size as per your preference */
}

.container {
width: 8.5in;
height: 13in;
border: none !important;
padding: none !important;
}

.indent {
margin-left: 150px;
}

footer {
position: fixed;
bottom: 0;
left: 0px;
right: 0px;
}
}


</style>

<body>

<div class="container center-div">
<header>
<center>
    <table style="width: 60%;">
        <tr>
            <td width="15%">
                <center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
                        align="left"> </center>
            </td>
            <td align="center">
                <p contenteditable="true" class="font-11">Republic of the Philippines</p>
                <p contenteditable="true" style="font-size: 11pt"><b>INTERNAL AUDIT SERVICES</b></p>
                <p contenteditable="true" style="font-size: 11pt"><b>PROVINCIAL GOVERNMENT OF LAGUNA</b></p>
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

<div>
<p contenteditable="true">{{ $date_issued }}</p>
<br>
<p contenteditable="true"><b>{{ $manager }}</b></p>
<p contenteditable="true">{{ $office_name }}</p>
<br>
<p contenteditable="true">Dear {{ $manager_lastname }}</p>
<br>
<span contenteditable="true" style="text-align:justify">
This is to inform you of the <b>{{ $current_month }} Customer Satisfaction(CSAT)</b> result of the
department. The result revealed that your <b>{{ $total_respondents_words }} ({{ $total_respondents }})  clients</b> were
<b>{{ $degree_satisfaction_remarks }}</b> with the kind of service they got from your personnel.
@if($invalidated > 0)
<b>{{ $invalidated_words }} ({{ $invalidated }}) accomplished</b> CSQ were invalidated as the requested service were not clearly
identified on the form.
@endif
Accordingly, the <b>{{ $office_name }}</b> was
<b>{{ $overall_performance_remarks }}</b> in its service performance during the said month.</span>
<br>
<br>
<p>The following were the detailed results culled from the retrieved Customer Satisfaction
Questionnaire(CSQ) responses:</p><br>
<table class="custom-table table-bordered" border=1 style="width: 100%;font-size:14px;">
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
<td>{{ $item->total_respondents}}</td>
<td>{{ number_format((float)$item->delivery_service, 2) }}</td>
<td>{{ number_format((float)$item->communications, 2)}}</td>
<td>{{ number_format((float)$item->quality_staff, 2)}}</td>
<td>{{ number_format((float)$item->quality_work, 2) }}</td>
<td>{{ number_format((float)$item->problem_solving, 2) }}</td>
<td>{{ number_format((float)$item->average, 2) }}</td>
</tr>
@endforeach

@if (count($results) === 1)
<tr>
<td>Overall Result</td>
<td>{{ $total_respondents }}</td>
<td>{{ number_format((float)$overall_delivery_service, 2) }}</td>
<td>{{ number_format((float)$overall_communications, 2) }}</td>
<td>{{ number_format((float)$overall_quality_staff, 2) }}</td>
<td>{{ number_format((float)$overall_quality_work, 2) }}</td>
<td>{{ number_format((float)$overall_problem_solving, 2) }}</td>
<!-- <td>{{ number_format((float)$overall_average, 2) }}</td> -->
<td>@php
    $roundedNumber = floor($overall_average * 100) / 100;

// Format the rounded number with two decimal places
echo$formattedNumber = number_format($roundedNumber, 2, '.', '');  
@endphp</td>
</tr>

<tr style="text-align:center">
<td colspan="8"><b>Comments and Suggestions were lifted from CSQ verbatim</b></td>
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
<div class="page-break"></div>
</body>

</html>

<br>
@foreach ($results as $key => $result_item)
@if ($key === 0)
@else
<!DOCTYPE html>
<html>
<script type="text/javascript">
// window.print();
// alert('dd');
</script>
<style type="text/css">

body {
font-family: "Nunito", Serif;
font-size: 12pt;
}

p {
margin: 0px;
}

.logo {
height: 120px;
width: 120px;
}

th {
text-align: left;
}

.header-text {
color: #002060;
}

@page {
    size: Legal;
    margin: 10cm 2cm;
}
.container {
width: 8.5in;
height: 13in;
border: none !important;
padding: none !important;
}

.indent {
margin-left: 150px;
}

.c-8 {
width: 12.5%;
}

.c-4 {
width: 25%;
}


.container1 {
width: 8.5in;
height: 13in;
border: solid 2px #eee;
padding: 25px;
}

.justify {
text-align: justify !important;
}

br {
display: block;

}


.center-div{
display: block;
padding: 20px;
margin: 20px auto;
}
.custom-table {
font-size: 8px;
/* Change the font size as per your preference */
}

@media print {
/* br {
display: none;

} */

.page-break {
page-break-after: always;
}

.custom-table {
font-size: 8px;
/* Change the font size as per your preference */
}

.container {
width: 8.5in;
height: 13in;
border: none !important;
padding: none !important;
}

.indent {
margin-left: 150px;
}

footer {
position: fixed;
bottom: 0;
left: 0px;
right: 0px;
}
}


</style>

<body>

<div class="container md-4" >
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
                <p contenteditable="true" style="font-size: 11pt"><b>INTERNAL AUDIT SERVICES</b></p>
                <p contenteditable="true" style="font-size: 11pt"><b>PROVINCIAL GOVERNMENT OF LAGUNA</b></p>
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
<div>

<table class="custom-table table-bordered" border=1 style="width: 100%;font-size:14px;">
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
                            <td>{{ $item->total_respondents}}</td>
                            <td>{{ number_format((float)$item->delivery_service, 2) }}</td>
                            <td>{{ number_format((float)$item->communications, 2)}}</td>
                            <td>{{ number_format((float)$item->quality_staff, 2)}}</td>
                            <td>{{ number_format((float)$item->quality_work, 2) }}</td>
                            <td>{{ number_format((float)$item->problem_solving, 2) }}</td>
                            <td>{{ number_format((float)$item->average, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Overall Result</td>
                        <td>{{ $total_respondents }}</td>
                        <td>{{ number_format($overall_delivery_service, 2) }}</td>
                        <td>{{ number_format($overall_communications, 2) }}</td>
                        <td>{{ number_format($overall_quality_staff, 2) }}</td>
                        <td>{{ number_format($overall_quality_work, 2) }}</td>
                        <td>{{ number_format($overall_problem_solving, 2) }}</td>
                        <td>
                            @php
                            $roundedNumber = floor($overall_average * 100) / 100;

                            // Format the rounded number with two decimal places
                            echo$formattedNumber = number_format($roundedNumber, 2, '.', '');
                            @endphp
                        </td>
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
<div class="page-break"></div>
</body>

</html>
@endif
@endforeach


<!DOCTYPE html>
<html>
<script type="text/javascript">
// window.print();
// alert('dd');
</script>
<style type="text/css">

body {
font-family: "Nunito", Serif;
font-size: 12pt;
}

p {
margin: 0px;
}

.logo {
height: 120px;
width: 120px;
}

th {
text-align: left;
}

.header-text {
color: #002060;
}

@page {
    size: Legal;
    margin: 10cm 2cm;
}
.container {
width: 8.5in;
height: 13in;
border: none !important;
padding: none !important;
}

.indent {
margin-left: 150px;
}

.c-8 {
width: 12.5%;
}

.c-4 {
width: 25%;
}


.container1 {
width: 8.5in;
height: 13in;
border: solid 2px #eee;
padding: 25px;
}

.justify {
text-align: justify !important;
}

br {
display: block;

}


.center-div{
display: block;
padding: 20px;
margin: 0 auto;
}
.custom-table {
font-size: 8px;
/* Change the font size as per your preference */
}

@media print {
/* br {
display: none;

} */

.page-break {
page-break-after: always;
}

.custom-table {
font-size: 8px;
/* Change the font size as per your preference */
}

.container {
width: 8.5in;
height: 13in;
border: none !important;
padding: none !important;
}

.indent {
margin-left: 150px;
}

footer {
position: fixed;
bottom: 0;
left: 0px;
right: 0px;
}
}


</style>

<body>

<div class="container" >
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
                <p contenteditable="true" style="font-size: 11pt"><b>INTERNAL AUDIT SERVICES</b></p>
                <p contenteditable="true" style="font-size: 11pt"><b>PROVINCIAL GOVERNMENT OF LAGUNA</b></p>
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

<div>
<div>
            <p><b>Analytics</b></p>
            <table>
                <tr>
                    <td>
                        <p><b>Figure of 1: No of Respondents</b></p>
                        <div style="width:400px;height:150px"><canvas id="myChart1"></canvas></div>

                    </td>
                    <td>
                        <div contenteditable="true"><b>Figure 1 - No of Respondents</b>, presents the number of
                            client-respondents
                            for <span id="date1"></span>. It is good that the department has conducted its CSS this
                            {{ $current_month }} with

                            @if ($total_respondents <= 1)
                            {{ $total_respondents_words }} ({{ $total_respondents }}) respondent
                            @else
                            {{ $total_respondents_words }} ({{ $total_respondents }}) respondents
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
                <div style="width:400px;height:150px"><canvas id="myChart2"></canvas></div>
            </td>
            <td>
                <div contenteditable="true"><b>Figure 2 - CSAT Ratings</b>, displays the graphical comparison of the
                    department's ratings of <span id="date2"></span> {{ $office_name }} rating is
                    <span id="csa_rating"></span></div>
            </td>
            </tr>
            </table>

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

                @if($invalidated > 0)
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
                @endif
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
                            <br>
                            <br>
                            <br>
                            <br>
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
                            <br>
                            <br>
                            <br>
                            <br>
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
</div>
<center>
<footer>
<img src="data:image/png;base64,{{ $logo3 }}" height="50" width="100" alt="Image">
</footer>
</center>
<div class="page-break"></div>
<script src="../../../../../js/chart.js"></script>
    <script>
    let array_value1 = Object.values(@json($chart1[0]));
        let array_month1 = Object.keys(@json($chart1[0])).map(x => x.toUpperCase());

        let array_value2 = Object.values(@json($chart2[0]));
        let array_month2 = Object.keys(@json($chart2[0]));

        let csa_array_value = Object.values(@json($chart2[0]));

        let yearString = {{ $yearString }}
        let prevyearString = {{ $yearString }} - 1

        console.log("Original_Month 1",array_month1)
        console.log("Original_Array 1",array_value1)

        console.log("Original_Month 2",array_month2)
        console.log("Original_Array 2",array_value2)

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

        console.log("Splice_Month 1",array_month1)
        console.log("Splice_Array 1",array_value1)

        console.log("Splice_Month 2",array_month2)
        console.log("Splice_Array 2",array_value2)

        if(value1 == 01){
            console.log(array_value2)

        array_month1 = array_month1.filter(month => month !== "TOTAL").reverse();
        array_month2 = array_month2.filter(month => month !== "AVERAGE").reverse();
        array_value1 = array_value1.filter((x,y) => y !== 2).reverse();
        array_value2 = array_value2.filter((x,y) => y !== 2).reverse();

        array_month1[0] = `DEC ${prevyearString}`;
        array_month2[0] = `DEC ${prevyearString}`;
        array_month1[1] = `JAN ${yearString}`;
        array_month2[1] = `JAN ${yearString}`;

        if (array_month1.length == 1) {
            array_value1.unshift(0);
            array_month1.unshift("DECEMBER");
            const [firstElement, ...restOfArray] = array_month1;
            const lastElement = array_month1[array_month1.length - 1];
            document.getElementById("date1").innerHTML = `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} TO ${lastElement}`
        } else {
            const [firstElement, ...restOfArray] = array_month1;
            const lastElement = array_month1[array_month1.length - 1];
            document.getElementById("date1").innerHTML = `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} TO ${lastElement}`
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
        }
        else{
        console.log(array_value2.length)
        console.log(array_value2)
        array_month1 = array_month1.filter(month => month !== "PREV_DEC");
        array_month2 = array_month2.filter(month => month !== "PREV_DEC");
        array_value1 = array_value1.filter((x,y) => y !== array_value1.length-2);
        array_value2 = array_value2.filter((x,y) => y !== array_value2.length-2);
        csa_array_value = csa_array_value.filter((x,y) => y !== csa_array_value.length-2);
        console.log(array_value2)
        let csa_rating = csa_array_value.filter((x,y,z)=> y!== z.length-1)

        console.log("Final_Month 1",array_month1)
        console.log("Final_Array 1",array_value1)

        console.log("Final_Month 2",array_month2)
        console.log("Final_Array 2",array_value2)
        
        console.log("CSA Final_Array",csa_array_value)

        let result_csa_rating = csa_rating.join(" and ");
        if (array_month1.length == 1) {
            array_value1.unshift(0);
            array_month1.unshift("DECEMBER");
            const [firstElement, ...restOfArray] = array_month1;
            const lastElement = array_month1[array_month1.length - 2];
            document.getElementById("date1").innerHTML = `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
            document.getElementById("csa_rating").innerHTML = `${result_csa_rating} respectively`
        } else {
            const [firstElement, ...restOfArray] = array_month1;
            const lastElement = array_month1[array_month1.length - 2];
            document.getElementById("date1").innerHTML = `${firstElement.replace(`PREV_DEC ${prevyearString}`,"DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
        }

        if (array_month2.length == 1) {
            array_value2.unshift(0);
            array_month2.unshift("DECEMBER");
            const [firstElement, ...restOfArray] = array_month2;
            const lastElement = array_month2[array_month2.length - 2];
            document.getElementById("date2").innerHTML = `${firstElement.replace("PREV_DEC","DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
        } else {
            const [firstElement, ...restOfArray] = array_month2;
            const lastElement = array_month2[array_month2.length - 2];
            document.getElementById("date2").innerHTML = `${firstElement.replace("PREV_DEC","DEC")} ${prevyearString} TO ${lastElement} ${yearString}`
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
