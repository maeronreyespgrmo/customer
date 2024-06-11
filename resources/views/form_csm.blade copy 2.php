<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Satisfaction System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="/vendor/vue/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/vendor/vue/css/vuetify.min.css" rel="stylesheet">
    <style>
        .text-justify {
            text-align: justify;
        }
        .table thead i {
            font-size: 50px;
        }
        .table thead p {
            font-size: 11px;
        }
        .table thead {
            text-align: center;
        }
        .table thead td {
            vertical-align: text-top;
        }
        .cwf {
            width: 100px;
        }
        .table .form-check-input {
            font-size: 30px;
            margin: 0;
        }
        .table tbody .text-center {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div id="app" v-cloak>
<v-app id="inspire">
    <div class="container">
            <div class="row mt-5">
                <div class="col col-lg-12">
                    <h4 class="text-center">TULUNGAN MO KAMI MAS MAPABUTI ANG AMING MGA PROSESO AT SERBISYO!</h4>
                    <p class="text-justify">
                        Ang Client Satisfaction Measurement (CSM) ay naglalayong masubaybayan ang karanasan ng taumbayan hinggil sa kanilang pakikitransaksyon sa mga tanggapan ng gobyerno. Makatutulong ang inyong kasagutan ukol sa inyong naging karanasan sa kakatapos lamang na transaksyon, upang mas mapabuti at lalong mapahusay ang aming serbisyo publiko. Ang personal na impormasyon na iyong ibabahagi ay mananatiling kumpidensyal. Maaari ring piliin na hindi sagutan ang sarbey na ito.
                    </p>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col col-lg-3">
                <v-select :disabled="isDisabled" v-model="office_name"
                :items="office_items" label="Pumili ng Opisina" :rules="nameRules"
                        required @change="service_dropdown"></v-select>
            </div>

    </div>  
            <div class="row mb-3">
                <div class="col col-lg-12">
                    <div class="row g-1 align-items-center">
                        <div class="col-auto">
                            <label class="col-form-label">Uri ng Kliyente: </label>
                        </div>
                        <div class="col-auto">
                            <v-radio-group
                            v-model="client_type"
                            row
                            required
                            >
                            <v-radio
                            label="Mamamayan"
                            value="Mamamayan"
                            ></v-radio>
                            <v-radio
                            label="Negosyo"
                            value="Negosyo"
                            ></v-radio>
                            <v-radio
                            label="Gobyerno (Empleyado o Ahensya)"
                            value="Gobyerno (Empleyado o Ahensya)"
                            ></v-radio>
                            </v-radio-group>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-12">
                    <div class="row g-3 align-items-center">
                        <!-- <div class="col-auto">
                            <label class="col-form-label">Petsa: </label>
                        </div> -->
                        <div class="col-auto me-3">
                            <div class="form-check form-check-inline">
                            <v-menu v-model="menu" :close-on-content-click="false"
                                                :nudge-right="40" transition="scale-transition" offset-y
                                                min-width="auto">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field :disabled="isDisabled" v-model="dates" label="Petsa"
                                                        append-icon="mdi-calendar" readonly v-bind="attrs"
                                                        :rules="nameRules" required v-on="on"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="dates" @input="menu = false"></v-date-picker>
                                            </v-menu>
                            </div>
                        </div>
                        <div class="col-auto">
                            <label class="col-form-label">Kasarian: </label>
                        </div>
                        <div class="col-auto me-3">
                            <v-radio-group
                            v-model="gender"
                            row
                            required
                            >
                            <v-radio
                            label="Lalaki"
                            value="1"
                            ></v-radio>
                            <v-radio
                            label="Babae"
                            value="2"
                            ></v-radio>
                            </v-radio-group>
                        </div>
                        <div class="col-auto me-3">
                            <label class="col-form-label">Edad: </label>
                        </div>
                        <div class="col-auto me-3">
                            <div class="form-check form-check-inline">
                                <input class="form-control" type="number">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col col-lg-12">
                    <label class="col-form-label">URI NG TRANSAKSYON/SERBISYO: </label>
                    <v-checkbox
                    v-model="services"
                    v-for="(item,index) in checkbox_data"
                    :key="item.name"
                    :label="item.name"
                    :value="item.name"
                    :rules="[v => !!v || 'Please select at least one service']"
                    required
                    ></v-checkbox>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-12">
                    <p class="text-justify">
                        PANUTO: Lagyan ng <b>tsek (✔)</b> ang iyong sagot sa mga sumusunod na katanungan tungkol sa Citizen’s Charter (CC). Ito ay isang opisyal na dokumento na naglalaman ng mga serbisyo sa isang ahensya/opisina ng gobyerno, makikita rito ang mga kinakailangan na dokumento, kaukulang bayarin, at pangkabuuang oras ng pagproseso.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-12">
                    <label class="col-form-label">CC1 &emsp; Alin sa mga sumusunod ang naglalarawan sa iyong kaalaman sa CC?</label>
                    
                    <div class="form-check ms-5">
                    <v-radio-group
                            v-model="gender"
                            column
                            required
                            >
                            <v-radio
                            label="1.Alam ko ang CC at nakita ko ito sa napuntahang opisina."
                            value="1"
                            ></v-radio>
                            <v-radio
                            label="2.Alam ko ang CC pero hindi ko ito nakita sa napuntahang opisina."
                            value="2"
                            ></v-radio>
                            <v-radio
                            label="3.Alam ko ang CC pero hindi ko ito nakita sa napuntahang opisina."
                            value="3"
                            ></v-radio>
                            <v-radio
                            label="4.Alam ko ang CC pero hindi ko ito nakita sa napuntahang opisina.(Lagyan ng tsek ang ‘N/A’ sa CC2 at CC3 kapag ito ang iyong sagot)"
                            value="4"
                            ></v-radio>
                            </v-radio-group>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-12">
                    <label class="col-form-label">CC2 &emsp; Kung alam ang CC (Nag-tsek sa opsyon 1~3 sa CC1), masasabi mo ba na ang CC nang napuntahang opisina ay…</label>
                    <div class="form-check ms-5">
                    <v-radio-group
                            v-model="cc3"
                            column
                            required
                            >
                            <v-radio
                            label="1. Madaling makita"
                            value="1"
                            ></v-radio>
                            <v-radio
                            label="2. Medyo madaling makita"
                            value="2"
                            ></v-radio>
                            <v-radio
                            label="3. Mahirap makita"
                            value="3"
                            ></v-radio>
                            <v-radio
                            label="4. Hindi makita"
                            value="4"
                            ></v-radio>
                            <v-radio
                            label="5. N/A"
                            value="5"
                            ></v-radio>
                            </v-radio-group>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-lg-12">
                    <label class="col-form-label">CC3 &emsp; Kung alam ang CC (Nag-tsek sa opsyon 1~3 sa CC1), gaano nakatulong ang CC sa transaksyon mo?</label>
                    <div class="form-check ms-5">
                    <v-radio-group
                            v-model="cc3"
                            column
                            required
                            >
                            <v-radio
                            label="1. Sobrang nakatulong"
                            value="1"
                            ></v-radio>
                            <v-radio
                            label="2. Nakatulong naman"
                            value="2"
                            ></v-radio>
                            <v-radio
                            label="3. Hindi nakatulong"
                            value="3"
                            ></v-radio>
                            <v-radio
                            label="4. N/A"
                            value="4"
                            ></v-radio>
                            </v-radio-group>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col col-lg-12">
                    <p class="text-justify">
                        PANUTO: Para sa SQD 0~8, lagyan ng <b>tsek (✔)</b> ang hanay na pinakaangkop sa iyong sagot.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td></td>
                                <td class="cwf">
                                    <i class="bi-emoji-angry"></i>
                                    <p>Lubos na hindi sumasangayon</p>
                                </td>
                                <td class="cwf">
                                    <i class="bi-emoji-frown"></i>
                                    <p>Hindi sumasangayon</p>
                                </td>
                                <td class="cwf">
                                    <i class="bi-emoji-neutral"></i>
                                    <p>Walang kinikilingan</p>
                                </td>
                                <td class="cwf">
                                    <i class="bi-emoji-smile"></i>
                                    <p>Sumasangayon</p>
                                </td>
                                <td class="cwf">
                                    <i class="bi-emoji-heart-eyes"></i>
                                    <p>Labis na sumasangayon</p>
                                </td>
                                <td class="cwf">
                                    <h3>N/A</h3>
                                    <p>Not Applicable</p>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <b>SQD0.</b> Nasiyahan ako sa serbisyo na aking natanggap sa napuntahan na tanggapan.
                                </td>
                                <td colspan=6>
                                               
                                                <v-radio-group row v-model="selectedOption1">
                                                <v-radio label="  " value="A"></v-radio>
                                                <v-radio label="  " value="B"></v-radio>
                                                <v-radio label="  " value="B"></v-radio>
                                                <v-radio label="  " value="B"></v-radio>
                                                <v-radio label="  " value="B"></v-radio>
                                                </v-radio-group>
                                                </td>
                                <!-- <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td> -->
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD1.</b> Makatwiran ang oras na aking ginugol para sa pagproseso ng aking transaksyon.
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD2.</b> Ang opisina ay sumusunod sa mga kinakailangang dokumento at mga hakbang batay sa impormasyong ibinigay.
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD3.</b> Ang mga hakbang sa pagproseso, kasama na ang pagbayad ay madali at simple lamang.
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD4.</b> Mabilis at madali akong nakahanap ng impormasyon tungkol sa aking transaksyon mula sa opisina o sa website nito.
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD5.</b> Nagbayad ako ng makatwirang halaga para sa aking transaksyon. <i>(Kung ang sebisyo ay ibinigay ng libre, maglagay ng tsek sa hanay ng N/A.)</i>
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD6.</b> Pakiramdam ko ay patas ang opisina sa lahat, o “walang palakasan”, sa aking transaksyon.
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD7.</b> Magalang akong trinato ng mga tauhan, at (kung sakali ako ay humingi ng tulong) alam ko na sila ay handang tumulong sa akin. 
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>SQD8.</b> Nakuha ko ang kinakailangan ko mula sa tanggapan ng gobyerno, kung tinanggihan man, ito ay sapat na ipinaliwanag sa akin. 
                                </td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                                <td class="text-center"><input class="form-check-input" type="radio"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col col-lg-12">
                    <label class="col-form-label">
                        Mga suhestiyon kung paano pa mapapabuti pa ang aming mga serbisyo (opsyonal):
                    </label>
                    <textarea class="form-control"></textarea>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col col-lg-12">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                          <label class="col-form-label">Email</label>
                        </div>
                        <div class="col-auto">
                          <input type="email" id="inputPassword6" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col col-lg-12">
                    <h4 class="text-center">MARAMING SALAMAT!</h4>
                </div>
            </div>
        </div>
    </div>
    </v-app>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/vendor/vue/js/vue.js"></script>
    <script src="/vendor/vue/js/Vuetify.js"></script>
    <script src="/vendor/assets/Vuetify/axios.min.js"></script>
    <script src="/js/form_csm.js"></script>
</body>
</html>