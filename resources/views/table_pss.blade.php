<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/images/seal_laguna.png" />
    <title>Customer Feedback System</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* tr:nth-child(even) {
            background-color: #f9f9f9;
        } */
    </style>
</head>

<body>
    <header>
        <table border=0 style="width: 100%;">
            <tr>
                <td width="15%">
                    <center> <img src="/images/seal_laguna.png" alt="" width="100" height="100"
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
                <td width="15%"><img src="/images/coa-logo.png" height="120" width="120" alt="Image"></td>
            </tr>
        </table>
    </header>
    <table>
        <tbody>
            <tr>
                <td>Pangalan ng Hospital: <b>{{ $results->hospital_name }}</b></td>
            </tr>
            <tr>
                <td>Date: <b>{{ $results->date }}</b></td>
            </tr>
            <tr>
                <td>Pangalan ng Pasyente:<b>{{ $results->patient_name }}</b></td>
            </tr>
            <tr>
                <td>Tirahan:<b>{{ $results->home_address }}</b></td>
            </tr>
            <tr>
                <td>Petsa ng Pagpahospital:<b>{{ $results->date_in }}</b></td>
            </tr>
            <tr>
                <td>Petsa ng Paglabas sa Hospital:<b>{{ $results->date_out }}</b></td>
            </tr>
            <tr>
                <td>Tagal ng paghihintay sa Emergency Room bago matingan ng doctor:
                    @if ($results->checked_doctor == '1')
                        <b>less than (1) hour</b>
                    @elseif($results->checked_doctor == '2')
                        <b>1 to 2 hours</b>
                    @elseif($results->checked_doctor == '3')
                        <b>3 to 4 hours</b>
                    @elseif($results->checked_doctor == '4')
                        <b>5 to 6 hours</b>
                    @elseif($results->checked_doctor == '5')
                        <b>7 to 8 hours</b>
                    @else
                        <b>Not Indicated</b>
                    @endif

                </td>
            </tr>
            <tr>
                <td>Tagal ng paghihintay sa Emergency Room bago madmit:

                    @if ($results->before_admit == '1')
                        <b>less than (1) hour</b>
                    @elseif($results->before_admit == '2')
                        <b>1 to 2 hours</b>
                    @elseif($results->before_admit == '3')
                        <b>3 to 4 hours</b>
                    @elseif($results->before_admit == '4')
                        <b>5 to 6 hours</b>
                    @elseif($results->before_admit == '5')
                        <b>7 to 8 hours</b>
                    @else
                        <b>Not Indicated</b>
                    @endif
                </td>
            </tr>
            <tr>
                <td><b>I. Environment of the Facility (Kapaligiran)</b></td>
            </tr>
            <tr>
                <td>A. Rooms are clean and orderly (Mayroong malinis at maayos na mga silid):
                    <b>{{ $results->radio1_a == 0 ? 'N/A' : $results->radio1_a }}</b>
                </td>
            </tr>
            <tr>
                <td>B. All linens including sheets covers are clean (Malinis ang mga sapin sa higaan at mga punda):
                    <b>{{ $results->radio1_b == 0 ? 'N/A' : $results->radio1_b }}</b>
                </td>
            </tr>
            <tr>
                <td>C. Linens are being replaced every day. (Napapalitan ang mga hospital linen araw araw):
                    <b>{{ $results->radio1_c == 0 ? 'N/A' : $results->radio1_c }}</b>
                </td>
            </tr>
            <tr>
                <td>D. Rooms and wards are quiet especially at night (Tahimik ang loob ng silid lalo na sa gabi):
                    <b>{{ $results->radio1_d == 0 ? 'N/A' : $results->radio1_d }}</b>
                </td>
            </tr>
            <tr>
                <td>E. Restrooms are clean (Malinis ang palikuran o CR):
                    <b>{{ $results->radio1_e == 0 ? 'N/A' : $results->radio1_e }}</b>
                </td>
            </tr>
            <tr>
                <td>F. Treatment areas or clinics are clean and organized (May malilinis na treatment area or klinika)
                    :<b>{{ $results->radio1_f == 0 ? 'N/A' : $results->radio1_f }}</b>
                </td>
            </tr>
            <tr>
                <td>G. With proper waiting areas (May maayos na lugar hintayan)
                    <b>{{ $results->radio1_g == 0 ? 'N/A' : $results->radio1_g }}</b>
                </td>
            </tr>
            <tr>
                <td><b>II. Nutrition and Dietary Service (Pagkain na isinilbi)</td>
            </tr>
            <tr>
                <td> a. Flavourful (Malasa): <b>{{ $results->radio2_a == 0 ? 'N/A' : $results->radio2_a }}</b></td>
            </tr>
            <tr>
                <td> b. Nutritous (Masustansiya): <b>{{ $results->radio2_b == 0 ? 'N/A' : $results->radio2_b }}</b>
                </td>
            </tr>
            <tr>
                <td> c. Served Properly (Maayos): <b>{{ $results->radio2_c == 0 ? 'N/A' : $results->radio2_c }}</b>
                </td>
            </tr>
            <tr>
                <td> d. Serve on time (Ibinibigay sa tamang oras):
                    <b>{{ $results->radio2_d == 0 ? 'N/A' : $results->radio2_d }}</b>
                </td>
            </tr>
            <tr>
                <td> e. Food containers are collected on time (Kinukuha ang pinalagyan ng pagkain sa tamang oras)
                    <b>{{ $results->radio2_e == 0 ? 'N/A' : $results->radio2_e }}</b>
                </td>
            </tr>
            <tr>
                <td><b>III. Medical Services (Serbisyo ng mga doctor)</td>
            </tr>
            <tr>
                <td> a. Provides great medical service (Magagaling o Mahuhusay)
                    <b>{{ $results->radio3_a == 0 ? 'N/A' : $results->radio3_a }}</b>
                </td>
            </tr>
            <tr>
                <td>b. Kind (Mababait): <b>{{ $results->radio3_b == 0 ? 'N/A' : $results->radio3_b }}</b></td>
            </tr>
            <tr>
                <td> c. Caring (Maalaga): <b>{{ $results->radio3_c == 0 ? 'N/A' : $results->radio3_c }}</b></td>
            </tr>
            <tr>
                <td> d. Explains the patient's condition clearly (Nagpapaliwanag ng tungkol sa aking kalagayan):
                    <b>{{ $results->radio3_d }}</b>
                </td>
            </tr>
            <tr>
                <td> e. Does patient's condition clearly (Nagpapaliwanag ng tungkol sa aking kalagayan):
                    <b>{{ $results->radio3_e == 0 ? 'N/A' : $results->radio3_e }}</b>
                </td>
            </tr>
            <tr>
                <td><b>IV. Nursing Service (Serbisyo ng mga Nars)</td>
            </tr>
            <tr>
                <td> a. Fast (Mabibilis): <b>{{ $results->radio4_a == 0 ? 'N/A' : $results->radio4_a }}</b></td>
            </tr>
            <tr>
                <td> b. Kind (Mabait): <b>{{ $results->radio4_b == 0 ? 'N/A' : $results->radio4_b }}</b></td>
            </tr>
            <tr>
                <td> c. Caring (Maalaga): <b>{{ $results->radio4_c == 0 ? 'N/A' : $results->radio4_c }}</b></td>
            </tr>
            <tr>
                <td> d. Medicine are always available (Laging available ang gamot): <b>{{ $results->radio4_d }}</b>
                </td>
            </tr>
            <tr>
                <td><b>V. Pharmacy Service (Serbisyo sa botika)</td>
            </tr>
            <tr>
                <td> a. Fast (Mabibilis): <b>{{ $results->radio5_a == 0 ? 'N/A' : $results->radio5_a }}</b></td>
            </tr>
            <tr>
                <td> b. Kind (Mababait):<b>{{ $results->radio5_b == 0 ? 'N/A' : $results->radio5_b }}</b></td>
            </tr>
            <tr>
                <td> c. Courteous (Magagalang): <b>{{ $results->radio5_c == 0 ? 'N/A' : $results->radio5_c }}</b></td>
            </tr>
            <tr>
                <td> d. Medicines are always available (May saapat at available na gamot):
                    <b>{{ $results->radio5_d == 0 ? 'N/A' : $results->radio5_d }}</b>
                </td>
            </tr>
            <tr>
                <td> e. Medical equipment and supplies always available (May sapat at available na kagamitang
                    medical
                    or medical supplies): <b>{{ $results->radio5_e == 0 ? 'N/A' : $results->radio5_e }}</b></td>
            </tr>
            <tr>
                <td><b>VI. Laboratory Service (Serbisyo nang Laboratoryo)</td>
            </tr>
            <tr>
                <td> a. Fast (Mabibilis): <b>{{ $results->radio6_a == 0 ? 'N/A' : $results->radio6_a }}</b></td>
            </tr>
            <tr>
                <td> b. Kind (Mababait): <b>{{ $results->radio6_b == 0 ? 'N/A' : $results->radio6_b }}</b></td>
            </tr>
            <tr>
                <td> c. Courteous (Magagalang): <b>{{ $results->radio6_c == 0 ? 'N/A' : $results->radio6_c }}</b></td>
            </tr>
            <tr>
                <td> d. Provides proper and clear explanation of the process that will be done (Nagpapaliwanag ng
                    kanyang ginagawang pamaraan): <b>{{ $results->radio6_d == 0 ? 'N/A' : $results->radio6_d }}</b>
                </td>
            </tr>
            <tr>
                <td> e. Laboratory results are released on time (Mabilis na naibibigay ang resulta sa mga laboratory
                    test): <b>{{ $results->radio6_a == 0 ? 'N/A' : $results->radio6_a }}</b></td>
            </tr>
            <tr>
                <td><b>VII. Imaging Service (Serbisyo Imaging o X-ray Department )</td>
            </tr>
            <tr>
                <td> a. Fast (Mabibilis): <b>{{ $results->radio7_a == 0 ? 'N/A' : $results->radio7_a }}</b></td>
            </tr>
            <tr>
                <td> b. Kind (Mababait): <b>{{ $results->radio7_b == 0 ? 'N/A' : $results->radio7_b }}</b></td>
            </tr>
            <tr>
                <td> c. Courteous (Magagalang): <b>{{ $results->radio7_c == 0 ? 'N/A' : $results->radio7_c }}</b></td>
            </tr>
            <tr>
                <td> d. Provides proper and clear explanation of the process that will be done (Nagpapaliwanag ng
                    kanyang ginagawang pamamaraan): <b>{{ $results->radio7_d == 0 ? 'N/A' : $results->radio7_d }}</b>
                </td>
            </tr>
            <tr>
                <td> e. Imaging X-ray results are released on time (Mabibilis na naiibigay ang resulta ng xray):
                    <b>{{ $results->radio7_e == 0 ? 'N/A' : $results->radio7_e }}</b>
                </td>
            </tr>
            <tr>
                <td><b>VIII. PhilHealth Section (Serbisyo ng Philhealth Seksyon)</td>
            </tr>
            <tr>
                <td> a. Fast (Mabibilis):<b>{{ $results->radio8_a == 0 ? 'N/A' : $results->radio8_a }}</b></td>
            </tr>
            <tr>
                <td> b. Kind (Mababait):<b>{{ $results->radio8_b == 0 ? 'N/A' : $results->radio8_b }}</b></td>
            </tr>
            <tr>
                <td> c. Courteous (Magagalang):<b>{{ $results->radio8_c == 0 ? 'N/A' : $results->radio8_c }}</b></td>
            </tr>
            <tr>
                <td> d. Clearly explains the coverage of the benefits (Maayos magpaliwanag ng mga
                    benepisyo):<b>{{ $results->radio8_d == 0 ? 'N/A' : $results->radio8_d }}</b></td>
            </tr>
            <tr>
                <td> e. Appropriate benefits are granted and processed accordingly (Nagbibigay at naisasaayos ang
                    tamang benepisyo):<b>{{ $results->radio8_e == 0 ? 'N/A' : $results->radio8_e }}</b></td>
            </tr>
            <tr>
                <td><b>IX. Medical Social Services Section (Serbisyo ng Social Services Seksyon)</td>
            </tr>
            <tr>
                <td> a. Fast (Mabibilis):<b>{{ $results->radio9_a == 0 ? 'N/A' : $results->radio9_a }}</b></td>
            </tr>
            <tr>
                <td> b. Kind (Mababait):<b>{{ $results->radio9_b == 0 ? 'N/A' : $results->radio9_b }}</b></td>
            </tr>
            <tr>
                <td> c. Corteous (Magagalang):<b>{{ $results->radio9_c == 0 ? 'N/A' : $results->radio9_c }}</b></td>
            </tr>
            <tr>
                <td> d. Clearly explains the coverage of the benefits
                    (Maayos):<b>{{ $results->radio9_d == 0 ? 'N/A' : $results->radio9_d }}</b></td>
            </tr>
            <tr>
                <td> e. Appropriate benefits are granted and processed accordingly (Naiibigay at naisaayos ang
                    benepisyo):<b>{{ $results->radio9_e == 0 ? 'N/A' : $results->radio9_e }}</b></td>
            </tr>
            <tr>
                <td><b>X. Billing Services (Serbisyo ng Billing Seksyon)</td>
            </tr>
            <tr>
                <td> a. Fast (Mabibilis):<b>{{ $results->radio10_a == 0 ? 'N/A' : $results->radio10_a }}</b></td>
            </tr>
            <tr>
                <td> b. Kind (Mababait):<b>{{ $results->radio10_b == 0 ? 'N/A' : $results->radio10_b }}</b></td>
            </tr>
            <tr>
                <td> c. Courteous (Magagalang):<b>{{ $results->radio10_c == 0 ? 'N/A' : $results->radio10_c }}</b></td>
            </tr>
            <tr>
                <td> d. Appropriate Philhealth benefits are accurately deducted from the patient's bill (Tamang
                    pagbawas ng benepisyo ng
                    Philhealth):<b>{{ $results->radio10_d == 0 ? 'N/A' : $results->radio10_d }}</b></td>
            </tr>
            <tr>
                <td> e. Statement of Accounts are accurately computed (Tamang tuos ng mga bayarin sa
                    gamutan):<b>{{ $results->radio10_e == 0 ? 'N/A' : $results->radio10_e }}</b></td>
            </tr>
            <tr>
                <td><b>XI. Medical Records (Serbisyo Medical Records Seksyon)</td>
            </tr>
            <tr>
                <td>a. Fast (Mabibilis):<b>{{ $results->radio11_a == 0 ? 'N/A' : $results->radio11_a }}</b></td>
            </tr>
            <tr>
                <td>b. Kind (Mababait):<b>{{ $results->radio11_b == 0 ? 'N/A' : $results->radio11_b }}</b></td>
            </tr>
            <tr>
                <td>c. Courteous (Magagalang):<b>{{ $results->radio11_c == 0 ? 'N/A' : $results->radio11_c }}</b></td>
            </tr>
            <tr>
                <td>d. Requested medical documents are relaeased on time (Mabilis na naibibigay ang mga dokumentong
                    hinihingi):<b>{{ $results->radio11_d == 0 ? 'N/A' : $results->radio11_d }}</b></td>
            </tr>
            <tr>
                <td><b>XII. Security Services (Mga Serbisyo ng mga Gwardiya)</td>
            </tr>
            <tr>
                <td>a. Fast (Mabibilis):<b>{{ $results->radio12_a == 0 ? 'N/A' : $results->radio12_a }}</b></td>
            </tr>
            <tr>
                <td>b. Kind (Mababait):<b>{{ $results->radio12_b == 0 ? 'N/A' : $results->radio12_b }}</b></td>
            </tr>
            <tr>
                <td>c. Courteous (Magagalang):<b>{{ $results->radio12_c == 0 ? 'N/A' : $results->radio12_c }}</b></td>
            </tr>
            <tr>
                <td>d. Deligently guards all entrances and exits (Mahigpit na binabantayan ang mga pumapasok at
                    lumalabas ng ospital):<b>{{ $results->radio12_d == 0 ? 'N/A' : $results->radio12_d }}</b></td>
            </tr>
            <tr>
                <td>e. Assist in the implementation of hospitals rules and policies (Tumutulong sa pagpatupad ng mga
                    alituntunin ng ospital):<b>{{ $results->radio12_e == 0 ? 'N/A' : $results->radio12_e }}</b></td>
            </tr>
            <tr>
                <td><b>XIII. Canteen Service (Serbisyo ng Kantina)</td>
            </tr>
            <tr>
                <td>a. Fast (Mabibilis):<b>{{ $results->radio13_a == 0 ? 'N/A' : $results->radio13_a }}</b></td>
            </tr>
            <tr>
                <td>b. Kind (Mababait):<b>{{ $results->radio13_b == 0 ? 'N/A' : $results->radio13_b }}</b></td>
            </tr>
            <tr>
                <td>c. Corteous (Magagalang):<b>{{ $results->radio13_c == 0 ? 'N/A' : $results->radio13_c }}</b></td>
            </tr>
            <tr>
                <td>d. Foods sold are nutritous and delicous (Masasarap at masustansya ang mga binebentang
                    pagkain):<b>{{ $results->radio13_d == 0 ? 'N/A' : $results->radio13_d }}</b>
                </td>
            </tr>
            <tr>
                <td>e. Foods sold are budget-friendly (Abot kaya ng presyo ng mga
                    pagkain):<b>{{ $results->radio13_e == 0 ? 'N/A' : $results->radio13_e }}</b> </td>
            </tr>

            <tr>
                <td><b>XIV. Ambulance Services (Serbisyo ng Ambulansiya)</td>
            </tr>
            <tr>
                <td>a. Fast (Mabibilis):<b>{{ $results->radio14_a == 0 ? 'N/A' : $results->radio14_a }}</b></td>
            </tr>
            <tr>
                <td>b. Kind (Mababait):<b>{{ $results->radio14_b == 0 ? 'N/A' : $results->radio14_b }}</b></td>
            </tr>
            <tr>
                <td>c. Corteous:<b>{{ $results->radio14_c == 0 ? 'N/A' : $results->radio14_c }}</b></td>
            </tr>
            <tr>
                <td>d. Patients are well-treated (Maayos na pagtrato sa
                    pasyente):<b>{{ $results->radio14_d == 0 ? 'N/A' : $results->radio14_d }}</b></td>
            </tr>
            <tr>
                <td>e. Overall efficiency of the ambulance driver, ambulance medical staff and the ambulance service
                    as a whole (Kahusayan ng ambulance driver, medical staff na kasama sa ambulansya at kabuuan ng
                    serbisyo):<b>{{ $results->radio14_e == 0 ? 'N/A' : $results->radio14_e }}</b></td>
            </tr>
            <tr>
                <td>Comments:<b>{{ $results->comments}}</b></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
