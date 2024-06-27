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
                <td>Petsa: <b>{{ $results->date }}</b></td>
            </tr>
            <tr>
                <td>Uri ng Cliente:<b>{{ $results->client_type }}</b></td>
            </tr>
            <tr>
                <td>Name of Evaluatee:<b></b></td>
            </tr>
    
          

        </tbody>
    </table>
</body>

</html>
