<!DOCTYPE html>
<html>
<script type="text/javascript">
// window.print();
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
margin: .5cm;
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
border-collapse: collapse;
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

<div class="container md-12 center-div" >
<header>
<center>
<table style="width: 60%;" border=0>
<tr>
<td width="15%">
<center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
align="left"> </center>
</td>
<td align="center" contenteditable="true" style="padding-bottom:0">
<p class="font-11">Republic of the Philippines</p>
<p style="font-size: 10pt; margin: 5px 0;"><b>Provincial Government of Laguna</b></p>
<p style="font-size: 10pt; margin: 5px 0;"><b>INTERNAL AUDIT SERVICES</b></p>
<p class="font-11">Pedro Guevara Street, Santa Cruz Laguna</p>
<p class="font-11">Email Address:audit@laguna.gov.ph
501-3413</p>
</td>
<td width="15%"><img src="data:image/png;base64,{{ $logo2 }}" height="90"
width="90" alt="Image" align="right"></td>
</tr>
</table>
</center>
</header>

<div>
<div contenteditable="true" style="padding-bottom:20px">{{ $date_today }}</div>
<div contenteditable="true"><b>{{ $manager_name }}</b></div>
<div contenteditable="true">{{ $position }}</div>
<div contenteditable="true" style="padding-bottom:10px">{{ $hospital_name }}</div>
<div contenteditable="true" style="padding-bottom:10px">{{ $manager_lastname }} :</div>
<br>
<div contenteditable="true" style="padding-bottom:10px;text-align:justify">This is to inform you of the
<b>{{ $mm_string }}</b> Patient
Satisfaction(PSAT)
result of {{ $hospital_name }}. The result revealed that your <b> {{ $total_respondents }} </b> patient
respondents were <b>{{ $overall_performance_remarks }}</b> with the kind of service they got from your
personnel. Accordingly,
{{ $hospital_name }} rating is <b>{{ $overall_performance_remarks }}</b> in its service performance
during the
said month.
</div>
<br>
<div contenteditable="true">The following were the detailed results culied from the retrieved responses:
</div>
<table class="custom-table" border=1 style="width: 100%;font-size: 10px;table:border-collapse">
<thead>
<tr>
<th>TYPE OF SERVICE (URI NG SERBISYO)</th>
<th>Average Rating</th>
</tr>
</thead>
<tr>
<td><b>I. Environment of the facility (Kapaligiran)</b></td>
<td align="right"><b>{{ number_format($total_avg1, 2) }}</b></td>
</tr>
<tr>
<td> a. Rooms are clean and orderly (Mayroong malinis at maayos na mga silid)</td>
<td>{{ number_format($radio1_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. All linens including sheets and covers are clean (Malinis ang mga sapin sa higaan)</td>
<td>{{ number_format($radio1_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Lines are being replaced every day (Napapalitan ang mga hospital linen araw araw)</td>
<td>{{ number_format($radio1_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Rooms and wards are quiet especially at night (Tahimik sa loob ng silid lalo na sa gabi)
</td>
<td>{{ number_format($radio1_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Restrooms are clean and organized (May malilinis na treatment area o klinika)</td>
<td>{{ number_format($radio1_e_avg, 2) }}</td>
</tr>
<tr>
<td> f. Treatment areas or clinics are clean and organized (May Malinis na treatment area o klinika)
</td>
<td>{{ number_format($radio1_f_avg, 2) }}</td>
</tr>
<tr>
<td> g. With proper waiting areas (May maayos an lugar hintayan)</td>
<td>{{ number_format($radio1_g_avg, 2) }}</td>
</tr>
<tr>
<td><b>II. Nutrition and Dietary Service (Pagkain na isinilbi)</td>
<td align="right"><b>{{ number_format($total_avg2, 2) }}</b></td>
</tr>
<tr>
<td> a. Flavourful (Malasa)</td>
<td>{{ number_format($radio2_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Nutritous (Masustansiya)</td>
<td>{{ number_format($radio2_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Served Properly (Maayos)</td>
<td>{{ number_format($radio2_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Serve on time (Ibinibigay sa tamang oras)</td>
<td>{{ number_format($radio2_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Food containers are collected on time (Kinukuha ang pinalagyan ng pagkain sa tamang oras)
</td>
<td>{{ number_format($radio2_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>III. Medical Services (Serbisyo ng mga doctor)</td>
<td align="right"><b>{{ number_format($total_avg3, 2) }}</b></td>
</tr>
<tr>
<td> a. Provides great medical service (Magagaling o Mahuhusay)</td>
<td>{{ number_format($radio3_a_avg, 2) }}</td>
</tr>
<tr>
<td>b. Kind (Mababait)</td>
<td>{{ number_format($radio3_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Caring (Maalaga)</td>
<td>{{ number_format($radio3_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Explains the patient's condition clearly (Nagpapaliwanag ng tungkol sa aking kalagayan)</td>
<td>{{ number_format($radio3_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Does patient's condition clearly (Nagpapaliwanag ng tungkol sa aking kalagayan)</td>
<td>{{ number_format($radio3_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>IV. Nursing Service (Serbisyo ng mga Nars)</td>
<td align="right"><b>{{ number_format($total_avg4, 2) }}</b></td>
</tr>
<tr>
<td> a. Fast (Mabibilis)</td>
<td>{{ number_format($radio4_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Kind (Mabait)</td>
<td>{{ number_format($radio4_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Caring (Maalaga)</td>
<td>{{ number_format($radio4_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Medicine are always available (Laging available ang gamot)/td>
<td>{{ number_format($radio4_d_avg, 2) }}</td>
</tr>
<tr>
<td><b>V. Pharmacy Service (Serbisyo sa botika)</td>
<td align="right"><b>{{ number_format($total_avg5, 2) }}</b></td>
</tr>
<tr>
<td> a. Fast (Mabibilis)</td>
<td>{{ number_format($radio5_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Kind (Mababait)</td>
<td>{{ number_format($radio5_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Courteous (Magagalang)</td>
<td>{{ number_format($radio5_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Medicines are always available (May saapat at available na gamot)</td>
<td>{{ number_format($radio5_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Medical equipment and supplies always available (May sapat at available na kagamitang
medical
or medical supplies)</td>
<td>{{ number_format($radio5_e_avg, 2) }}</td>
</tr>
<tr>
<th><b>VI. Laboratory Service (Serbisyo nang Laboratoryo)</th>
<td align="right"><b>{{ number_format($total_avg6, 2) }}</b></td>
</tr>
<tr>
<td> a. Fast (Mabibilis)</td>
<td>{{ number_format($radio6_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Kind (Mababait)</td>
<td>{{ number_format($radio6_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Courteous (Magagalang)</td>
<td>{{ number_format($radio6_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Provides proper and clear explanation of the process that will be done (Nagpapaliwanag ng
kanyang ginagawang pamaraan)</td>
<td>{{ number_format($radio6_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Laboratory results are released on time (Mabilis na naibibigay ang resulta sa mga laboratory
test)</td>
<td>{{ number_format($radio6_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>VII. Imaging Service (Serbisyo Imaging o X-ray Department )</td>
<td align="right"><b>{{ number_format($total_avg7, 2) }}</b></td>
</tr>
<tr>
<td> a. Fast (Mabibilis)</td>
<td>{{ number_format($radio7_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Kind (Mababait)</td>
<td>{{ number_format($radio7_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Courteous (Magagalang)</td>
<td>{{ number_format($radio7_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Provides proper and clear explanation of the process that will be done (Nagpapaliwanag ng
kanyang ginagawang pamamaraan)</td>
<td>{{ number_format($radio7_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Imaging X-ray results are released on time (Mabibilis na naiibigay ang resulta ng xray)</td>
<td>{{ number_format($radio7_e_avg, 2) }}</td>
</tr>

<tr>
<td><b>VIII. PhilHealth Section (Serbisyo ng Philhealth Seksyon)</td>
<td align="right"><b>{{ number_format($total_avg8, 2) }}</b></td>
</tr>
<tr>
<td> a. Fast (Mabibilis)</td>
<td>{{ number_format($radio8_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Kind (Mababait)</td>
<td>{{ number_format($radio8_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Courteous (Magagalang)</td>
<td>{{ number_format($radio8_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Clearly explains the coverage of the benefits (Maayos magpaliwanag ng mga benepisyo)</td>
<td>{{ number_format($radio8_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Appropriate benefits are granted and processed accordingly (Nagbibigay at naisasaayos ang
tamang benepisyo)</td>
<td>{{ number_format($radio8_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>IX. Medical Social Services Section (Serbisyo ng Social Services Seksyon)</td>
<td align="right"><b>{{ number_format($total_avg9, 2) }}</b></td>
</tr>
<tr>
<td> a. Fast (Mabibilis)</td>
<td>{{ number_format($radio9_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Kind (Mababait)</td>
<td>{{ number_format($radio9_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Corteous (Magagalang)</td>
<td>{{ number_format($radio9_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Clearly explains the coverage of the benefits (Maayos)</td>
<td>{{ number_format($radio9_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Appropriate benefits are granted and processed accordingly (Naiibigay at naisaayos ang
benepisyo)</td>
<td>{{ number_format($radio9_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>X. Billing Services (Serbisyo ng Billing Seksyon)</td>
<td align="right"><b>{{ number_format($total_avg10, 2) }}</b></td>
</tr>
<tr>
<td> a. Fast (Mabibilis)</td>
<td>{{ number_format($radio10_a_avg, 2) }}</td>
</tr>
<tr>
<td> b. Kind (Mababait)</td>
<td>{{ number_format($radio10_b_avg, 2) }}</td>
</tr>
<tr>
<td> c. Courteous (Magagalang)</td>
<td>{{ number_format($radio10_c_avg, 2) }}</td>
</tr>
<tr>
<td> d. Appropriate Philhealth benefits are accurately deducted from the patient's bill (Tamang
pagbawas ng benepisyo ng Philhealth)</td>
<td>{{ number_format($radio10_d_avg, 2) }}</td>
</tr>
<tr>
<td> e. Statement of Accounts are accurately computed (Tamang tuos ng mga bayarin sa gamutan)</td>
<td>{{ number_format($radio10_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>XI. Medical Records (Serbisyo Medical Records Seksyon)</td>
<td align="right"><b>{{ number_format($total_avg11, 2) }}</b></td>
</tr>
<tr>
<td>a. Fast (Mabibilis)</td>
<td>{{ number_format($radio11_a_avg, 2) }}</td>
</tr>
<tr>
<td>b. Kind (Mababait)</td>
<td>{{ number_format($radio11_b_avg, 2) }}</td>
</tr>
<tr>
<td>c. Courteous (Magagalang)</td>
<td>{{ number_format($radio11_c_avg, 2) }}</td>
</tr>
<tr>
<td>d. Requested medical documents are relaeased on time (Mabilis na naibibigay ang mga dokumentong
hinihingi)</td>
<td>{{ number_format($radio11_d_avg, 2) }}</td>
</tr>




</table>
</div>
<center>

</center>
<div class="page-break"></div>
</body>

</html>
<br>
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
margin: .5cm;
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
border-collapse: collapse;
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

<div class="container md-12" >
<header>
<center>
<table style="width: 60%;" border=0>
<tr>
<td width="15%">
<center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
align="left"> </center>
</td>
<td align="center" contenteditable="true" style="padding-bottom:0">
<p class="font-11">Republic of the Philippines</p>
<p style="font-size: 10pt; margin: 5px 0;"><b>Provincial Government of Laguna</b></p>
<p style="font-size: 10pt; margin: 5px 0;"><b>INTERNAL AUDIT SERVICES</b></p>
<p class="font-11">Pedro Guevara Street, Santa Cruz Laguna</p>
<p class="font-11">Email Address:audit@laguna.gov.ph
501-3413</p>
</td>
<td width="15%"><img src="data:image/png;base64,{{ $logo2 }}" height="90"
width="90" alt="Image" align="right"></td>
</tr>
</table>
</center>
</header>

<div>
<table class="custom-table table-bordered" border=1 style="width: 100%;font-size: 10px;table:border-collapse">
<thead>
<tr>
<th>TYPE OF SERVICE (URI NG SERBISYO)</th>
<th>Average Rating</th>
</tr>
</thead>
<tbody>
<tr>
<td><b>XII. Security Services (Mga Serbisyo ng mga Gwardiya)</td>
<td><b>{{ number_format($total_avg12, 2) }}</td>
</tr>
<tr>
<td>a. Fast (Mabibilis)</td>
<td>{{ number_format($radio12_a_avg, 2) }}</td>
</tr>
<tr>
<td>b. Kind (Mababait)</td>
<td>{{ number_format($radio12_b_avg, 2) }}</td>
</tr>
<tr>
<td>c. Courteous (Magagalang)</td>
<td>{{ number_format($radio12_c_avg, 2) }}</td>
</tr>
<tr>
<td>d. Deligently guards all entrances and exits (Mahigpit na binabantayan ang mga pumapasok at
lumalabas ng ospital)</td>
<td>{{ number_format($radio12_d_avg, 2) }}</td>
</tr>
<tr>
<td>e. Assist in the implementation of hospitals rules and policies (Tumutulong sa pagpatupad ng mga
alituntunin ng ospital)</td>
<td>{{ number_format($radio12_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>XIII. Canteen Service (Serbisyo ng Kantina)</td>
<td align="right"><b>{{ number_format($total_avg13, 2) }}</b></td>
</tr>
<tr>
<td>a. Fast (Mabibilis)</td>
<td>{{ number_format($radio13_a_avg, 2) }}</td>
</tr>
<tr>
<td>b. Kind (Mababait)</td>
<td>{{ number_format($radio13_b_avg, 2) }}</td>
</tr>
<tr>
<td>c. Corteous (Magagalang)</td>
<td>{{ number_format($radio13_c_avg, 2) }}</td>
</tr>
<tr>
<td>d. Foods sold are nutritous and delicous (Masasarap at masustansya ang mga binebentang pagkain)
</td>
<td>{{ number_format($radio13_d_avg, 2) }}</td>
</tr>
<tr>
<td>e. Foods sold are budget-friendly (Abot kaya ng presyo ng mga pagkain) </td>
<td>{{ number_format($radio13_e_avg, 2) }}</td>
</tr>

<tr>
<td><b>XIV. Ambulance Services (Serbisyo ng Ambulansiya)</td>
<td align="right"><b>{{ number_format($total_avg14, 2) }}</td>
</tr>
<tr>
<td>a. Fast (Mabibilis)</td>
<td>{{ number_format($radio14_a_avg, 2) }}</td>
</tr>
<tr>
<td>b. Kind (Mababait)</td>
<td>{{ number_format($radio14_b_avg, 2) }}</td>
</tr>
<tr>
<td>c. Corteous</td>
<td>{{ number_format($radio14_c_avg, 2) }}</td>
</tr>
<tr>
<td>d. Patients are well-treated (Maayos na pagtrato sa pasyente)</td>
<td>{{ number_format($radio14_d_avg, 2) }}</td>
</tr>
<tr>
<td>e. Overall efficiency of the ambulance driver, ambulance medical staff and the ambulance service
as a whole (Kahusayan ng ambulance driver, medical staff na kasama sa ambulansya at kabuuan ng
serbisyo)</td>
<td>{{ number_format($radio14_e_avg, 2) }}</td>
</tr>
<tr>
<td><b>OVERALL AVERAGE FOR THE MONTH</td>
<td align="right"><b>{{ number_format($overall_average, 2) }}</td>
</tr>
<tr>
<td colspan=2 style="text-align: center;"><b>Comments and Suggestions</b></td>
</tr>
@foreach ($comments as $comment_key => $comments_item)
@if($comment_key == 0)
@foreach ($comments_item as $key => $item)
<tr>
<td colspan=2> {{ $key + 1 }} . {{ $item }}</td>
</tr>
@endforeach
@endif
@endforeach
</tbody>
</table>
<br>
</div>
<center>

</center>
<div class="page-break"></div>
</body>

</html>
<br>
@foreach ($comments as $comment_key => $comments_item)
@if($comment_key > 0)
<!DOCTYPE html>
<html>
<script type="text/javascript">
// window.print();
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
margin: .5cm;
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
border-collapse: collapse;
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

<div class="container md-12" >
<header>
<center>
<table style="width: 60%;" border=0>
<tr>
<td width="15%">
<center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
align="left"> </center>
</td>
<td align="center" contenteditable="true" style="padding-bottom:0">
<p class="font-11">Republic of the Philippines</p>
<p style="font-size: 10pt; margin: 5px 0;"><b>Provincial Government of Laguna</b></p>
<p style="font-size: 10pt; margin: 5px 0;"><b>INTERNAL AUDIT SERVICES</b></p>
<p class="font-11">Pedro Guevara Street, Santa Cruz Laguna</p>
<p class="font-11">Email Address:audit@laguna.gov.ph
501-3413</p>
</td>
<td width="15%"><img src="data:image/png;base64,{{ $logo2 }}" height="90"
width="90" alt="Image" align="right"></td>
</tr>
</table>
</center>
</header>

<div>

<table class="custom-table" border=1 style="width: 100%;">

<tr>
<td colspan=2><b>Comments and Suggestion</b></td>
</tr>
@foreach ($comments_item as $key => $item)
<tr>
<td colspan=2> {{ $key + 1 }} . {{ $item }}</td>
</tr>
@endforeach
</table>
</div>
<div class="page-break"></div>
</body>

</html>
@endif
@endforeach
<br>
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
margin: .5cm;
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
border-collapse: collapse;
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

<div class="container md-12" >
<header>
<center>
<table style="width: 60%;" border=0>
<tr>
<td width="15%">
<center> <img src="/images/seal_laguna.png" alt="" width="80" height="80"
align="left"> </center>
</td>
<td align="center" contenteditable="true" style="padding-bottom:0">
<p class="font-11">Republic of the Philippines</p>
<p style="font-size: 10pt; margin: 5px 0;"><b>Provincial Government of Laguna</b></p>
<p style="font-size: 10pt; margin: 5px 0;"><b>INTERNAL AUDIT SERVICES</b></p>
<p class="font-11">Pedro Guevara Street, Santa Cruz Laguna</p>
<p class="font-11">Email Address:audit@laguna.gov.ph
501-3413</p>
</td>
<td width="15%"><img src="data:image/png;base64,{{ $logo2 }}" height="90"
width="90" alt="Image" align="right"></td>
</tr>
</table>
</center>
</header>

<div>
<!-- <table class="custom-table table-bordered" border=1 style="width: 100%;">
<tr>
<td colspan=2><b>Comments and Suggestion</b></td>
</tr>
@foreach ($comments_item as $key => $item)
<tr>
<td colspan=2> {{ $key + 1 }} . {{ $item }}</td>
</tr>
@endforeach
</table> -->
<br>

@if ($key + 1 <= 50)
@php
$labels = ['less than (1) hour', '1 to 2 hours', '3 to 4 hours', '5 to 6 hours', '7 to 8 hours'];
$ch1_label_max = isset($labels[$highest_chart1_index]) ? $labels[$highest_chart1_index] : 'Not Indicated';
$ch1_label_min = isset($labels[$lowest_chart1_index]) ? $labels[$lowest_chart1_index] : 'Not Indicated';
$ch2_label_max = isset($labels[$highest_chart2_index]) ? $labels[$highest_chart2_index] : 'Not Indicated';
$ch2_label_min = isset($labels[$lowest_chart2_index]) ? $labels[$lowest_chart2_index] : 'Not Indicated';
@endphp
<table>
<tr>
<td>
<div style="">
<table class="custom-table" border=0 style="width: 100%;">
<thead>
    <tr>
        <th colspan="2">Count based on Place of Residency</th>
    </tr>
</thead>
<tbody>
    @foreach ($municipality as $itemss)
        <tr>
            @if ($itemss['home_count'] != 0)
                @if ($itemss['home_address'] == 'QUEZON')
                    <td><b>QUEZON PROVINCE</b></td>
                @elseif($itemss['home_address'] == 'BATANGAS')
                    <td><b>BATANGAS PROVINCE</b></td>
                @else
                    <td><b>{{ $itemss['home_address'] }}</b></td>
                @endif
                <td>{{ $itemss['home_count'] }}
                </td>
                <td>
                    ({{ number_format(($itemss['home_count'] / $municipality_total) * 100, 2, '.', '') }}%)
                </td>
            @endif

            {{-- <td>{{ $item[0]->home_address }}</td> --}}
        </tr>
    @endforeach
</tbody>
</table>
</div>
</td>
<td>
<div style="font-size: 12pt">
<div contenteditable="true" id="municipality" style="font-size: 8pt">Based on
the place of residency,
@foreach ($municipality as $key => $item_cc)
    @if (number_format(($item_cc['home_count'] / $municipality_total) * 100, 2, '.', '') != 0)
        <b>{{ $item_cc['home_count'] }}</b>
        <b>{{ number_format(($item_cc['home_count'] / $municipality_total) * 100, 2, '.', '') }}%</b>
        were from
        @if ($item_cc['home_address'] == 'QUEZON')
            <b>QUEZON PROVINCE</b>
        @elseif($item_cc['home_address'] == 'BATANGAS')
            <b>BATANGAS PROVINCE</b>
        @else
            <b>{{ $item_cc['home_address'] }}</b>
        @endif
    @endif

    @if ($loop->last)
        .
    @else
        @if (number_format(($item_cc['home_count'] / $municipality_total) * 100, 2, '.', '') != 0)
            and
        @endif
    @endif

    @if ($loop->last)
    @endif
@endforeach
</div>
</div>
</td>
</tr>
<tr>
<td>
<div style="font-size: 7pt">
<div contenteditable="true"><b>Figure 1-Waiting Time for Medical Intervention</b>
</div>
<div contenteditable="true">
@if ($chart_settings == 'pie')
    <div id="chart1"></div>
@else
    <div style="width:500px;height:300px"><canvas id="myChart1"></canvas>
    </div>
@endif
</div>
<div style="padding-bottom:20px"contenteditable="true">Figure 1-Waiting Time
for Medical
Intervention show
that
<b> {{ $chart1_total[0] }}%</b>of the clients were attended in <b>less than
    (1)
    hour</b>,
<b> {{ $chart1[1] }}%</b>
of the clients were attended in <b>1 to 2 hours</b>, <b>
    {{ $chart1_total[2] }} %</b>
of the clients were attended in <b>3 to 4 hours</b>, <b>
    {{ $chart1_total[3] }} %</b>
of the clients were attended in <b>5 to 6 hours</b>, <b>
    {{ $chart1_total[4] }} %</b>
of the clients were attended in <b>7 to 8 hours</b> and <b>
    {{ $chart1_total[5] }}
    %</b>
of the clients were attended in <b>Not Indicated</b> of the total population
</div>
</div>
</td>
<td>
<div style="font-size: 7pt">
<div>




<div contenteditable="true"><b>Figure 2-Waiting Time for Admission </b></div>
<div>
    @if ($chart_settings == 'pie')
        <div id="chart2"></div>
    @else
        <div style="width:500px;height:300px"><canvas id="myChart2"></canvas>
        </div>
    @endif


</div>

<div contenteditable="true">Figure 2-Waiting Time for Admission shows that
    <b>{{ $chart2_total[0] }}%</b>of
    the
    clients were attended in <b>less than (1)
        hour</b>,
    <b>{{ $chart2_total[1] }}% </b>
    of the clients were attended in <b>1 to 2 hours</b>,
    <b>{{ $chart2_total[2] }}%
    </b>
    of the clients were attended in <b>3 to 4 hours</b>,
    <b>{{ $chart2_total[3] }}%
    </b>
    of the clients were attended in <b>5 to 6 hours</b>,
    <b>{{ $chart2_total[4] }}%
    </b>
    of the clients were attended in <b>7 to 8 hours</b> and
    <b>{{ $chart2_total[5] }}%
    </b>
    of the clients were attended in <b>Not Indicated</b> of the total
    population.
</div>
</div>
</div>
</td>
</table>
@endif

<div contenteditable="true" style="font-size:14px">
        <div>It is recommended that the facility shall:</div>
        <br>
        <!-- ul>li*5 -->
        <ul>
            <li>Religiously conduct PSS in every service encounter and improve customer participation by increasing the
                number of respondents not just enough the pen-and-paper format but also with the online PSS;</li>
            <li>
                study and evaluate the comments and suggestions raised by the respondents in order to further improve
                the delivery of service such as:
                <br>
                -Reminding all hospitals personnel to interact with the patients and their relatives in courteous and
                respectful manners at all times, especially those in the areas mentioned by the respondents;
                <br>
                -Providing patients with clear and concise orientation of hospital rules and policies in order to
                properly set their expectations on hospital with clear and concise orientation of hospital rules and
                policies in order to properly set their expectations on hospitals house rules, like visiting hours,
                hospital services, services available, etc;
                <br>
                -Considering the possibility of increasing the hospital bed capacity of hospital, as well as the
                acquisition of necessary medical furniture and equipment in areas where they are lacking; and
                <br>
                -Making sure that repairs and maintenance checks are done regularly.
            </li>

            <li>
                @if ($degree_satisfaction_remarks == 'Very Satisfied')
                    maintain the <b>{{ $overall_performance_remarks }}</b> service rating of the hospital to by making
                    the clients <b>Very Satisfied</b> in the next cycles;
                @else
                    improve the <b>{{ $overall_performance_remarks }}</b> service rating of the hospital to by making
                    the clients <b>Very Satisfied</b> in the next cycles;
                @endif
            </li>
            <li>
                @if ($degree_satisfaction_remarks == 'Not Satisfied')
                    encourage the personnel with their effort of providing satisfactory services to the customers during
                    the departmental meeting
                @else
                    recognize the personnel with their effort of providing satisfactory services to the customers during
                    the departmental meeting
                @endif
                and
            </li>
            <li>always remind your respondent to approximately rate the service/s they availed from the hospital to
                avoid invalidation of responses</li>
        </ul>
        <div>
            Thank you very much for you cooperation. Let us continue the Serbisyong Tama!
        </div>
        <div style="height:100px;"></div>
        <table border=0 style="width:100%;font-size:14px">
            <tr>

                <td colspan="4">
                    <div class="signature-1">
                        <div>
                            &nbsp;
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>

                        <div>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            &nbsp;
                        </div>
                        <br>
                        <div>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            &nbsp;
                        </div>
                    </div>
                </td>
            
                <td colspan="3">
                    <div class="signature-1">
                        <div style="padding-bottom:80px;">
                            Respectfully,
                        </div>


                        <div>
                            <b>Ms.Maria A.Lim</b>
                        </div>
                        <br>
                        <div>
                            Internal Auditor IV
                        </div>
                    </div>
                </td>
                <td colspan="3">

                <div>
                &nbsp;
                </div>
                </td>
                <td colspan="3">

                <div>
                &nbsp;
                </div>
                </td>
                <td colspan="3">

                <div>
                &nbsp;
                </div>
                </td>
                <td colspan="3">
                    <div class="signature-2">
                        <div style="padding-bottom:80px;">
                            Noted by:
                        </div>


                        <div>
                            <b>Atty. Dulce H. Rebanal</b>
                        </div>
                        <br>
                        <div>
                            Provincial Administrator
                        </div>
                    </div>
                </td>
            </tr>
        </table>


</div>
<div class="page-break"></div>

</body>
</html>


<script src="../../../../../js/apexcharts.min.js"></script>
<script src="../../../../../js/chart.js"></script>
<script>
let chart_settings = @json($chart_settings);
var color_pallete = ['#34ace0', '#e67e22', '#c0392b', '#f1c40f', '#e74c3c', '#8e44ad'];

if (chart_settings == 'pie') {
var options1 = {
chart: {
type: 'pie',
width: '320px',
height: '320px',
},

series: @json($chart1),
labels: ['>1hr', '1-2hours', '3-4hours', '5-6hours', '7-8hours', 'Not Indicated'],
dataLabels: {
formatter: function(val, opts, wew) {
console.log("ew", opts)
return `${(val).toFixed(0)}%` // Round the value to remove decimal places
},

},
legend: {
position: 'left',
fontSize: "8px",
formatter: function(seriesName, opts) {
var total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
var seriesIndex = opts.seriesIndex;
var data = opts.w.globals.series[seriesIndex];
var percentage = ((data / total) * 100).toFixed(2) + "%";
// return seriesName + " (" + percentage + ")";
return seriesName;
}
},
colors: color_pallete,
fill: {
colors: color_pallete
},
markers: {
colors: color_pallete
}

}

var options2 = {
chart: {
type: 'pie',
width: '320px',
height: '320px',
},
labels: ['>1hr', '1-2hours', '3-4hours', '5-6hours', '7-8hours', 'Not Indicated'],
series: @json($chart2),
dataLabels: {

formatter: function(val, opts, wew) {
console.log("ew", opts)
return `${(val).toFixed(0)}%`
}
},
legend: {
position: 'left',
fontSize: "8px",
formatter: function(seriesName, opts) {
var total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
var seriesIndex = opts.seriesIndex;
var data = opts.w.globals.series[seriesIndex];
var percentage = ((data / total) * 100).toFixed(2) + "%";
// return seriesName + " (" + percentage + ")";
return seriesName;
}
},
colors: color_pallete,
fill: {
colors: color_pallete
},
markers: {
colors: color_pallete
}

}

let chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
let chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
chart1.render();
chart2.render();
} else {
// Get the canvas element
var ctx1 = document.getElementById('myChart1').getContext('2d');
var ctx2 = document.getElementById('myChart2').getContext('2d');
// Create the chart
var myChart = new Chart(ctx1, {
type: chart_settings,
data: {
labels: ['>1hr', '1-2hours', '3-4hours', '5-6hours', '7-8hours', 'Not Indicated'],
datasets: [{
label: 'Figure 1-Waiting Time for Medical Intervention',
data: @json($chart1),
backgroundColor: [
'rgba(255, 99, 132, 0.2)',
'rgb(44, 62, 80)',
'rgb(52, 152, 219)',
'rgb(26, 188, 156)',
'rgb(46, 204, 113)',
'rgb(155, 89, 182)',
],
borderColor: [
'rgba(255, 99, 132, 1)',
'rgb(44, 62, 80)',
'rgb(52, 152, 219)',
'rgb(26, 188, 156)',
'rgb(46, 204, 113)',
'rgb(155, 89, 182)',
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
font: {
family: 'Arial, sans-serif',
size: 8,
weight: 'bold'
},
color: '#333' // Text color
}
}
}
}
});


var myChart2 = new Chart(ctx2, {
type: chart_settings,
data: {
labels: ['>1hr', '1-2hours', '3-4hours', '5-6hours', '7-8hours', 'Not Indicated'],
datasets: [{
label: 'Figure 2-Waiting Time for Admission',
data: @json($chart2),
backgroundColor: [
'rgba(255, 99, 132, 0.2)',
'rgb(44, 62, 80)',
'rgb(52, 152, 219)',
'rgb(26, 188, 156)',
'rgb(46, 204, 113)',
'rgb(155, 89, 182)',
],
borderColor: [
'rgba(255, 99, 132, 1)',
'rgb(44, 62, 80)',
'rgb(52, 152, 219)',
'rgb(26, 188, 156)',
'rgb(46, 204, 113)',
'rgb(155, 89, 182)',
],
borderWidth: 1,
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
font: {
family: 'Arial, sans-serif',
size: 8,
weight: 'bold'
},
color: '#333' // Text color
}
}
}
}
});
}
</script>
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
</style>
<link rel="stylesheet" href="../../../../../css/webfonts/fontawesome.all.min.css">
<div class="floatingButtonWrap">
    <div class="floatingButtonInner">
        <a href="#" class="floatingButton">
            <i class="fa fa-print icon-default"></i>
        </a>
        <ul class="floatingMenu">
            <!-- <li>
                <a href="#" onclick="window.print()">Print as PDF</a>
            </li> -->
            <li>
                <a href="/wordpss/{{ $date_today }}/{{ $date }}/{{ $hospital_name }}">Print as Word
                    Doc</a>
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