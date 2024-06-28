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
                <td>Edad: <b>{{ $results->age }}</b></td>
            </tr>
            <tr>
                <td>URI NG TRANSAKSYON/SERBISYO: <b>{{ $results->service_name }}</b></td>
            </tr>
            <tr>
            <td>CC1: <b>{{ $results->cc1 }}</b>
                <br>
                <input type="radio" id="age1" name="age" {{ $results->cc1 == 1 ? "checked" : ""}}>
                <label for="cc1_1">1. Alam ko ang CC at nakita ko ito sa napuntang opisina</label><br>
                <input type="radio" id="age2" name="age" {{ $results->cc1 == 2 ? "checked" : ""}}>
                <label for="cc1_2">2. Alam ko ang CC pero hindi ko ito nakita sa napuntahang opisina</label><br>  
                <input type="radio" id="age3" name="age" {{ $results->cc1 == 3 ? "checked" : ""}}>
                <label for="cc3_3">3. Alam ko ang CC pero hindi ko ito nakita sa napuntahang opisina</label><br>
                <input type="radio" id="age3" name="age" {{ $results->cc1 == 4 ? "checked" : ""}}>
                <label for="cc3_4">4. Alam ko ang CC pero hindi ko ito nakita sa napuntahang opisina(Lagyan ng tsek ang 'N/A' sa CC2 at CC3 kapag ito ang iyong sagot)</label><br>
            </td>
            </tr>
            <tr>
                
            <td>CC2: <b>{{ $results->cc2 }}</b>
            <br>
                <input type="radio" name="age" {{ $results->cc2 == 1 ? "checked" : ""}}>
                <label for="cc2_1">1. Madaling Makita</label><br>
                <input type="radio" name="age" {{ $results->cc2 == 2 ? "checked" : ""}}>
                <label for="cc2_2">2. Medyo madaling makita</label><br>  
                <input type="radio" name="age" {{ $results->cc2 == 3 ? "checked" : ""}}>
                <label for="cc2_3">3. Mahirap makita</label><br>
                <input type="radio" name="age" {{ $results->cc2 == 4 ? "checked" : ""}}>
                <label for="cc2_4">4. Hindi Makita</label><br>
                <input type="radio" name="age" {{ $results->cc2 == 5 ? "checked" : ""}}>
                <label for="cc2_4">5. N/A</label><br>
            </td>
            </tr>
            <tr>
                <td>CC3: <b>{{ $results->cc3 }}</b>
                <input type="radio" {{ $results->cc3 == 1 ? "checked" : ""}}>
                <label for="cc3_1">1. Sobrang nakakatulong</label><br>
                <input type="radio" {{ $results->cc3 == 2 ? "checked" : ""}}>
                <label for="cc3_2">2. Nakakatulong naman</label><br>
                <input type="radio" {{ $results->cc3 == 3 ? "checked" : ""}}>
                <label for="cc3_3">3. Hindi nakakatulong </label><br>
                <input type="radio" {{ $results->cc3 == 4 ? "checked" : ""}}>
                <label for="cc3_4">4. N/A</label><br>
                </td>
            </tr>
            <tr>
                <td>SQD0: Nasiyahan ako sa serbisyo na aking natanggap sa napuntahan na tanggapan. <b>{{ $results->sqd1 }}</b>
                    @if($results->sqd0 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd0 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd0 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd0 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd0 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>
            <tr>
                <td>SQD1: Makatwiran ang oras na aking ginugol para sa pagproseso ng aking transaksyon. <b>{{ $results->sqd1 }}</b>
                    @if($results->sqd1 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd1 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd1 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd1 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd1 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>
            <tr>
                <td>SQD2: Ang opisina ay sumusunod sa mga kinakailangang dokumento at mga hakbang batay sa impormasyong ibinigay. <b>{{ $results->sqd2 }}</b>
                    @if($results->sqd2 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd2 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd2 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd2 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd2 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>
            <tr>
                <td>SQD3: Ang mga hakbang sa pagproseso, kasama na ang pagbayad ay madali at simple lamang.<b>{{ $results->sqd3 }}</b>
                    @if($results->sqd3 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd3 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd3 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd3 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd3 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>
            <tr>
                <td>SQD4: Mabilis at madali akong nakahanap ng impormasyon tungkol sa aking transaksyon mula sa opisina o sa website nito. <b>{{ $results->sqd4 }}</b>
                    @if($results->sqd4 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd4 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd4 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd4 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd4 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>

            <tr>
                <td>SQD5: Nagbayad ako ng makatwirang halaga para sa aking transaksyon. (Kung ang sebisyo ay ibinigay ng libre, maglagay ng tsek sa hanay ng N/A.) <b>{{ $results->sqd5 }}</b>
                    @if($results->sqd5 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd5 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd5 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd5 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd5 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>

            <tr>
                <td>SQD6: Pakiramdam ko ay patas ang opisina sa lahat, o “walang palakasan”, sa aking transaksyon.<b>{{ $results->sqd6 }}</b>
                    @if($results->sqd6 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd6 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd6 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd6 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd6 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>
            
            <tr>
                <td>SQD7: Magalang akong trinato ng mga tauhan, at (kung sakali ako ay humingi ng tulong) alam ko na sila ay handang tumulong sa akin.<b>{{ $results->sqd7 }}</b>
                    @if($results->sqd7 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd7 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd7 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd7 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd7 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>
                
            <tr>
                <td>SQD8: Nakuha ko ang kinakailangan ko mula sa tanggapan ng gobyerno, kung tinanggihan man, ito ay sapat na ipinaliwanag sa akin.<b>{{ $results->sqd8 }}</b>
                @if($results->sqd8 == 1)
                        <b>Lubos na hindi sumasangayon</b>
                    @elseif($results->sqd8 == 2)
                        <b>Hindi sumasangayon</b>
                    @elseif($results->sqd8 == 3)
                        <b>Walang kinikilingan</b>
                    @elseif($results->sqd8 == 4)
                        <b>Sumasangayon</b>
                    @elseif($results->sqd8 == 5)
                        <b>Labis na sumasangayon</b>
                    @else
                        <b>Not Applicable</b>
                    @endif
                </td>
            </tr>

            <tr>
                <td>Comments: <b>{{ $results->comments }}</b></td>
            </tr>

            <tr>
                <td>Email: <b>{{ $results->email }}</b></td>
            </tr>

        </tbody>
    </table>
</body>

</html>
