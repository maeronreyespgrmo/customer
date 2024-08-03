<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Satisfaction Measurement</title>
<style>
body {
margin: 5px 15%;
width: 70%;
}
.full-page-table {
display: table;
width: 100%;
border-collapse: collapse;
}

.full-page-table th, .full-page-table td {
/* padding: 8px; */
text-align: left;
}

.full-page-table th {
background-color: #f2f2f2;
}

.full-page-table tbody {
display: table-row-group;
height: 100%;
}

.full-page-table tr {
display: table-row;
height: calc(100% / 6); /* Adjust the number to match the number of rows */
}

.centered-block {
width: 100%; /* Adjust width as needed */
margin:350px auto;
text-align: center;
display:block
}

.footer {
position: relative;
left: 0;
bottom: 0;
width: 100%;
color: white;
text-align: center;
}

@media print {
.footer {
position: relative;
left: 0;
bottom: 0;
width: 100%;
color: white;
text-align: center;
}

}


</style>
</head>
<body>

<table class="full-page-table">
<tbody>
<tr>
<td style="float:right"><img src="/images/arta.png" width="350" height="80"></td>
</tr>
</tbody>
</table>


<div class="centered-block"><h1>Client Satisfaction Measurement <br>Sample Report</h1></div>



<div class="footer">
<img src="/images/arta_footer.png"><br>
</div>


</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Satisfaction Measurement</title>
<style>
html, body {
    margin: 0;
padding: 0;
height: 100%;
width: 100%;
}
.centered-block {
width: 100%; /* Adjust width as needed */
margin:350px auto;
text-align: center;
display:block
}

.block-1 {
width: 100%; /* Adjust width as needed */
margin:70px 0px;
text-align: center;
}

@media print {

}


</style>
</head>
<body>


<table class="full-page-table">
<tbody>
<tr>
<td style="float:right"></td>
</tr>
</tbody>
</table>

<br>
<br>

<div class="centered-block">
<img src="/images/logo.png" width="100" height="100"/>
<div style="font-size: 20px;"><h1>Provincial Government of Laguna</h1></div>
<br>
<br>
<br>
<br>
<br>
<div class="block-1" style="font-size: 20px;"><h1>Harmonized CSM Report</h1></div>        
<div style="font-size: 16px;"><h1>2023(1st Edition)</h1></div>    
</div>  

</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Satisfaction Measurement</title>
<style>
html, body {
margin:80px;
padding: 0;
margin-top:0;
height: 100%;
width:90%;
border:1px red
}

.centered-block {
width: 100%; /* Adjust width as needed */
margin:350px auto;
text-align: center;
display:block
}

.block-1 {
width: 100%; /* Adjust width as needed */
margin:70px 0px;
text-align: center;
}

@media print {
html, body {
margin: 0;
padding: 0;
height: 100%;
width:100%;
}
}


</style>
</head>
<body>
<table class="maintable">
<thead>
<tr>
<th>
<div class="image-container">
<img src="/images/seal_laguna.png" alt="" width="60" height="60" align="right">
<div>
<p style="display:block">DISCLAIMER: ALL NUMBERS IN THIS SAMPLE HAVE BEEN RANDOMIZED AND ARE NOT REPRESENTATIVE OF THE AGENCY'S ACTUAL PERFORMANCE</p>
</div>
</div>
</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<div></div>
<div>I. Overview</div>
<br>
<div>The Anti-Red Tape Authority(ARTA) is a national government agency........................ R.A 11032 to monitor and ensure compliance with the national policy of .......... and ease of doing businesss in the philippnies.</div>
<br>
<div>As stated in the ARTA Memorandum Circular(M.C) No. 2022-02, government agencies shall provide the harmonized CSM survey to clients who have completed a transaction. Per 6.7.3 of ARTA M.C No. 2019-002, the client satisfaction measurement detailing the scope and period covered by the measurement, the methodology use, the results of the measurement, and the interpratation of the data shall be reported to the Authorithy.</div>
<br>
<div>II. Scope:</div>
<br>
<div>Arta conducted surveys throughout the uear from Jan, 2022 to Dec 2022</div>
<br>
<div>Arta surveyed every client that visited the main and regional offices, as well as those that contacted ARTA through email.</div>
<br>
<div>The survey used the standard harmonized CSM questionnaire. It asked clients demographical questions, three(3) Citizen's Charter question, and eight(8) question related to the following Service Quality Dimensions:</div>
<ol>
<li>Responsiveness</li>
<li>Reliabilty</li>
<li>Access and Facilities</li>
<li>Communication</li>
<li>Costs</li>
<li>Integrity</li>
<li>Assurance</li>
<li>Outcome</li>
</ol>
<table border=1 style="width:100%">
<thead>
<tr>
<th>External Services</th>
<th>Responses</th>
<th>Total Transactions</th>
</tr>
</thead>
<tbody>
@foreach($result_scope_external as $item)
<tr>
<td>{{$item->service_name}}</td>
<td>{{$item->responses}}</td>
<td></td>
</tr>
@endforeach

</tbody>
</table>
<br>
<center>
<table border=1 style="width:100%">
<thead>
<tr>
<th>Internal Services</th>
<th>Responses</th>
<th>Total Transactions</th>
</tr>
</thead>
<tbody>
<tr>
@foreach($result_scope_internal as $item)
<tr>
<td>{{$item->service_name}}</td>
<td>{{$item->responses}}</td>
<td></td>
</tr>
@endforeach
</tbody>
</table>
<br>
<div> In aggregate, 2816 people were able to answer the survey, among a population of 6,920. This resulted in a 41% response rate for 2022</div>
<br>
<div>Services that had no clients in 2022 are the following</div>

<div>III. Methodology:</div>
<br>
<div>For physical clients, survey were handed out and collected by ARTA personnel immediately at the end of the transaction. Survey and survey boxes were also available near the office exit.</div>
<div>For online clients, emails containing the CSM portal link were sent one(1) week after the last correspondence.</div>
<div>The 8 SQD questions were scored using a 5-point Likert Scale. The simple average of the question was used to get the Overall score. The interpratation of the results are as follows:</div>
<table border=1>
<thead>
<th>Scale</th>
<th>Average</th>
<th>Rating</th>
</thead>
<tbody>
<tr>
<td>1</td>
<td>1.00 - 1.49</td>
<td>Very Unsatisfied</td>
</tr>
<tr>
<td>2</td>
<td>1.50 - 2.49</td>
<td>Unsatisfied</td>
</tr>
<tr>
<td>3</td>
<td>2.50 - 3.49</td>
<td>Neither Unsatisfied nor Satisfied</td>
</tr>
<tr>
<td>4</td>
<td>3.50 - 4.49</td>
<td>Satisfied</td>
</tr>
<tr>
<td>5</td>
<td>4.50 - 5.49</td>
<td>Very Satisfied</td>
</tr>
</tbody>
</table>
</center>
<div>IV. Results of the harmonized CSM for FY 2022:</div>
<br>
<div>A. Count of CC and SQD results</div>
<br>
<div>While the majority of respondents know the existence of a Citizen's Charter(CC), 49% of clients were still unaware of the CC. 49% of Clients were still unaware of the CC.</div>
<br>
<div>Meanwhile, among those that knew the CC, 77% were able to see ARTA's CC. However, only 34% of clients were able to use it as a guide for their service.</div>
<br>
<table border=1 style="width:100%">
<thead>
<tr>
<th>External Services</th>
<th>Responses</th>
<th>Percentage</th>
</tr>
</thead>
<tbody>
<tr>
<td>CC1: Yes, aware before my transaction here</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<td>CC1: Yes, but aware only when I saw the CC of this Office</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<td>CC1: No not aware</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>CC2: Yes I saw the Citizens Charter </td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<td>CC2: No, I did not see the Citizens Charter</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>CC3: Yes, I was able to read</td>
<td>0</td>
<td>0</td>
</tr>
<tr>
<td>CC3: No, I was not able to read</td>
<td>0</td>
<td>0</td>
</tr>
</tbody>
</table>
<br>
<div>Meanwhile, most repondents were "Very Satisfied" with ARTA in terms of the service quality dimensions, recording score range of 4.55-4.72.</div>
<br>
<div>The data below shows the breakdown of the results per service quality dimension.</div>
<br>
<table border=1>
<thead>
<tr>
<th>Service Quality Dimensions</th>
<th>Strongly Disagree</th>
<th>Disagree</th>
<th>Neither Agree nor Disagree</th>
<th>Agree</th>
<th>Strongly Agree</th>
<th>Responses</th>
<th>Rating</th>
</tr>
</thead>
<tbody>
<tr>
<td>Respnsiveness</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

</tbody>
</table>

<div>B. Average score per service</div>
<br>
<div>Looking at the scores per service, respondents were either "Satisfied" or "Very Satisfied" with their transactions, recording a score range of 4.00 - 4.97. No service gamered a score of 3.99 or lower</div>
<br>
<div>As a result, ARTA recorded an Overall score of 4.55, which translated to "Very Satisfied"</div>
<br>
<div>The data below shows the Overall rating of each service surveyed</div>

<table style="width:100%" border=1>
<thead>
<tr>
<th>External Services</th>
<th>Overall Rating</th>
</tr>
</thead>
<tbody>
<td>&nbsp</td>
<td>&nbsp</td>
</tbody>
</table>
<table style="width:100%" border=1>
<thead>
<tr>
<th>Internal Services</th>
<th>Overall Rating</th>
</tr>
</thead>
<tbody>
<td>&nbsp</td>
<td>&nbsp</td>
</tbody>
</table>
</td>
</tr>

</tbody>

<tfoot>
<tr>
<td>

<footer>

</footer>

</td>
</tr>
</tfoot>
</table>

</body>
</html>