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
                <td>Pangalan ng Opisina: <b>{{ $results->office_name }}</b></td>
            </tr>
            <tr>
                <td>Date: <b>{{ $results->date }}</b></td>
            </tr>
            <tr>
                <td>Name of Evaluator:<b>{{ $results->name_evaluator }}</b></td>
            </tr>
            <tr>
                <td>Name of Evaluatee:<b>{{ $results->name_evaluatee }}</b></td>
            </tr>
            @if($results->invalidated == "no")
            <tr>
                <td>Requested Service:<b>{{ $results->service_name }}</b></td>
            </tr>
            @endif

            <tr>
                <td>Invalidated:<b>{{ $results->invalidated }}</b></td>
            </tr>

            @if($results->invalidated == "no")
            <tr>
                <td><b>Delivery Serbisyo</b></td>
            </tr>
            <tr>
                <td>1.How satisfied are you overall with the service you received? <b>{{ $results->radio_1 }}</b>
                </td>
            </tr>
            <tr>
                <td>2.How satisfied are you with the speed in which the service was delivered?
                    <b>{{ $results->radio_2 }}</b>
                </td>
            </tr>
            <tr>
                <td>3.How satisfied are you with the ease of contacting the person you needed?
                    <b>{{ $results->radio_3 }}</b>
                </td>
            </tr>
            <tr>
                <td>4.How satisfied are you with the clarity of information or advice provided?
                    <b>{{ $results->radio_4 }}</b>
                </td>
            </tr>
            <tr>
                <td>5.How satisfied are you with the time taken to respond to enquiries? <b>{{ $results->radio_5 }}</b>
                </td>
            </tr>
            <tr>
                <td><b>Quality of Staff (Kalidad ng Empleyado)</b></td>
            </tr>
            <tr>
                <td>6.How satisfied are you with the relevant knowledge of the staff you dealt directly with?
                    <b>{{ $results->radio_6 }}</b>
                </td>
            </tr>
            <tr>
                <td>7.How satisfied are you with the courtesy of the staff? <b>{{ $results->radio_7 }}</b></td>
            </tr>
            <tr>
                <td>8.How satisfied are you with the helpfulness of the staff? <b>{{ $results->radio_8 }}</b></td>
            </tr>
            <tr>
                <td>9.How satisfied are you that the staff showed interest in you as an individual/treated you as a
                    valued customer? <b>{{ $results->radio_9 }}</b></td>
            </tr>
            <tr>
                <td><b>Quality of Work (Kalidad ng Trabaho)</b></td>
            </tr>
            <tr>
                <td>10.How satisfied are you with the quality of work/service by the staff you dealt directly with
                    in
                    terms of accuracy and completeness? <b>{{ $results->radio_10 }}</b></td>
            </tr>
            <tr>
                <td>11.How satisfied are you with the works undertaken?
                    <b>{{ $results->radio_11 }}</b>
                </td>
            </tr>
            <tr>
                <td>
                    <b>
                        Problem Solving (Pagbibigay ng Solusyon)
                    </b>
                </td>
            </tr>

            <tr>
                <td>
                    12.How satisfied are you with the way problems were resolved?
                    <b>{{ $results->radio_12 }}</b>
                </td>
            </tr>

            <tr>
                <td>
                    <b>
                        Comments
                    </b>
                </td>
            </tr>

            <tr>
                <td>
                    <b>{{ $results->comments }}</b>
                </td>
            </tr>
            @endif
          

        </tbody>
    </table>
</body>

</html>
