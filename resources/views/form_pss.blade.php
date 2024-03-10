<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback System</title>
    <link rel="icon" type="image/png" href="/images/seal_laguna.png" />
    <link href="/vendor/vue/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/vendor/vue/css/vuetify.min.css" rel="stylesheet">
    <style>
        [v-cloak] {
            display: none;
        }

        @media (min-width: 1000px) {

            /* Add your styles here */
            body {
                font-size: 14px;
            }
        }

        #scrollToTop {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 30px;
            font-size: 14px;
        }

        * {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <!-- <div class="loader_bg">
    <div class="loader"></div>
</div> -->
    <div id="app" v-cloak>
        <v-app id="inspire">
            <v-progress-linear v-if="isLoading" color="purple" :value="loadingProgress" height="10">
            </v-progress-linear>
            <v-snackbar v-model='snackbar' :color='snackbarcolor' top="top" style="margin-top:0;z-index:9000">
                @{{ snackbartext }}
            </v-snackbar>
            <div id="cont" style="background-color: rgb(228 219 241);">
                <v-container>
                    <v-toolbar dark prominent src="/images/capitol.jpg">

                        <v-spacer></v-spacer>

                    </v-toolbar>

                    <br>
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-card class="mx-auto header text-center" max-width="1200" min-width="auto" outlined rounded
                            raised>
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td width="15%">
                                                <center> <img src="/images/seal_laguna.png" alt=""
                                                        width="100" height="100" align="left"> </center>
                                            </td>
                                            <td align="center">
                                                <p class="font-11">Republic of the Philippines</p>
                                                <p style="font-size: 12pt"><b>PROVINCIAL GOVERNMENT OF LAGUNA</b></p>
                                                <p class="font-11">Pedro Guevara Street, Sta Cruz Laguna</p>
                                                <p class="font-11">PATIENT SATISFACTION SURVEY</p>
                                            </td>
                                            <td width="15%"><img src="/images/coa-logo.png" height="120"
                                                    width="120" alt="Image"></td>
                                        </tr>
                                    </table>
                                </v-list-item-content>
                            </v-list-item>
                        </v-card>
                        <br>

                        <div v-if="currentStep === 1">
                            <v-card class="mx-auto" max-width="1200" outlined class="justify-center" rounded raised>
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">Details</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-combobox v-model="hospital_name" :items="hospital_items"
                                                label="Pumili ng Hospital" :rules="nameRules"
                                                :disabled="isDisabled"></v-combobox>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-menu v-model="menu" :close-on-content-click="false"
                                                :nudge-right="40" transition="scale-transition" offset-y
                                                min-width="auto">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field :disabled="isDisabled" v-model="dates" label="Date"
                                                        append-icon="mdi-calendar" readonly v-bind="attrs"
                                                        :rules="nameRules" required v-on="on"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="dates" @input="menu=false"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                        <v-col cols="12">
                                            <div>Invalidated?</div>
                                                <v-radio-group
                                                v-model="invalidated"
                                                row
                                                :rules="nameRules"
                                                @change="toggleVisibility()"
                                                required
                                                >
                                                <v-radio
                                                label="Yes"
                                                value="yes"
                                                ></v-radio>
                                                <v-radio
                                                label="No"
                                                value="no"
                                                ></v-radio>
                                                </v-radio-group>
                                            </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card v-show="isVisible" max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">PANUTO</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12"> Alinsabay sa naganap na ebalwasyon ng aming serbisyo sa
                                            mga
                                            panlalawigan pagamutan ng laguna, mangyaring sagutan ang mga sumusunod na
                                            katanungan at lagyan ng tsek sa tapat ng iyong mga sagot. Ang batayan ng
                                            score o
                                            rating ay ang mga sumusunod:</v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>N/A-Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card v-show="isVisible" max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">PRIVACY NOTICE:</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <!-- <v-col cols="12"><b>PRIVACY NOTICE:</b></v-col> -->
                                        <br>
                                        <v-col cols="12">Sa pagsagot nitong form, pinahahatulutan mo ang
                                            Panlalawigan
                                            Pagmutan ng Laguna sa pag processo ng iyong personal na impormasyon na
                                            naayon sa
                                            layunin ng questionairre na eto.</v-col>
                                        <v-col cols="12">
                                            <v-text-field :disabled="isDisabled" v-model="patient_name"
                                                label="Pangalan ng Pasyente" required dense :rules="nameRules"
                                                required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field :disabled="isDisabled" v-model="home_address" label="Tirahan"
                                                required dense :rules="nameRules" required></v-text-field>
                                        </v-col>
                                        {{-- <v-col cols="12">
                                            <v-autocomplete v-model="home_address" :search-input.sync="home_address"
                                                :items="home_address_items" @update:search-input="home_address_btn"
                                                label="Pumili ng Municipalidad" :rules="nameRules"></v-autocomplete>
                                        </v-col> --}}
                                        <v-col cols="12">
                                            <v-menu v-model="menu_date_in" :close-on-content-click="false"
                                                :nudge-right="40" transition="scale-transition" offset-y
                                                min-width="auto">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field :disabled="isDisabled" v-model="date_in"
                                                        label="Date" append-icon="mdi-calendar" readonly
                                                        v-bind="attrs" :rules="nameRules" required
                                                        v-on="on"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="date_in"
                                                    @input="menu_date_in = false"></v-date-picker>
                                            </v-menu>

                                        </v-col>
                                        <v-col cols="12">
                                            <v-menu v-model="menu_date_out" :close-on-content-click="false"
                                                :nudge-right="40" transition="scale-transition" offset-y
                                                min-width="auto">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field :disabled="isDisabled" v-model="date_out"
                                                        label="Date" append-icon="mdi-calendar" readonly
                                                        v-bind="attrs" :rules="nameRules" required
                                                        v-on="on"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="date_out"
                                                    @input="menu_date_out = false"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                        <v-col cols="12"><b>Tagal ng paghihintay sa Emergency Room bago matingan
                                                ng
                                                doctor:</b></v-col>

                                        <v-col cols="12">
                                            <v-radio-group v-model="selectedOptions_1" :disabled="isDisabled"
                                                :rules="nameRules">
                                                <v-radio v-for="(option, index) in options_1" :label="option.label"
                                                    :value="option.value"></v-radio>
                                            </v-radio-group>

                                        </v-col>
                                        <v-col cols="12"><b>Tagal ng paghihintay sa Emergency Room bago
                                                madmit:</b>
                                        </v-col>
                                        <v-col cols="12">

                                            <v-radio-group v-model="selectedOptions_2" :disabled="isDisabled"
                                                :rules="nameRules">
                                                <v-radio v-for="(option, index) in options_2" :label="option.label"
                                                    :value="option.value"></v-radio>
                                            </v-radio-group>
                                        </v-col>

                                        <v-col cols="12">
                                            Check All Fields?
                                            <v-radio-group
                                            v-model="checkradioall_0"
                                            row
                                            @change="toggleCheckall(0)"
                                            required
                                            >
                                            <v-radio
                                            label="1"
                                            value="1"
                                            ></v-radio>
                                            <v-radio
                                            label="2"
                                            value="2"
                                            ></v-radio>
                                            <v-radio
                                            label="3"
                                            value="3"
                                            ></v-radio>
                                            <v-radio
                                            label="4"
                                            value="4"
                                            ></v-radio>
                                            <v-radio
                                            label="N/A"
                                            value="0"
                                            ></v-radio>
                                            </v-radio-group>
                                        </v-col>


                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 2">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">I. Environment of the
                                            Facility (Kapaligiran)</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12"> Ang nasabing Panlalawigan Ospital ng Laguna
                                            ay:</v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>N/A-Hindi Angkop:</b></v-col>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_1"
                                        row
                                        @change="toggleCheckall(1)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Rooms are clean and orderly (Mayroong malinis at maayos na mga
                                                    silid)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio1_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. All linens including sheets covers are clean (Malinis ang mga
                                                    sapin
                                                    sa higaan at mga punda)</b>
                                            </v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio1_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Linens are being replaced every day. (Napapalitan ang mga
                                                    hospital
                                                    linen araw araw)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio1_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Rooms and wards are quiet especially at night (Tahimik ang loob
                                                    ng
                                                    silid lalo na sa gabi)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio1_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Restrooms are clean (Malinis ang palikuran o CR)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio1_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>F. Treatment areas or clinics are clean and organized (May
                                                    malilinis
                                                    na treatment area or klinika)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio1_f" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>G. With proper waiting areas (May maayos na lugar
                                                    hintayan)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio1_g" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 3">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">II. Nutrition and Dietary Service
                                            (Pagkain na isinisilbi)</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang isinisilbing pagkain sa Panlalawigan Ospital
                                            ay:</v-col>
                                        <br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>N/A-Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_2"
                                        row
                                        @change="toggleCheckall(2)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Flavourful (Malasa)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio2_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Nutritious (Masustansya)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio2_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Served properly (Maayos)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio2_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Served on Time (Ibinigay sa tamang oras)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio2_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Food Containers (Kinuha ang pinaglagyan ng pagkain sa tamang
                                                    oras)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio2_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 4">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">III. Medical Services (SERBISYO NG
                                            MGA
                                            DOCTOR)</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang mga doktor na tumingin at nag-asikaso sa akin
                                            ay:</v-col>
                                        <br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>N/A-Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_3"
                                        row
                                        @change="toggleCheckall(3)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Provides great medical service (Magagaling o
                                                    Mahuhusay)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio3_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio3_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Caring (Maalaga)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio3_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Nagbibigay ng tamang gamot sa itinakdang oras</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio3_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Nagbibigay oras ng pagbisita sa akin araw-araw</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio3_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 5">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">IV. Nurseing Service (SERBISYO NG MGA
                                            NARS)</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang mga NARS o attending nurse ng Panlalawigan Ospital
                                            ay:
                                        </v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>N/A-Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_4"
                                        row
                                        @change="toggleCheckall(4)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio4_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind(Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio4_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Caring (Maalaga)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio4_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Nagbibigay ng Tamang gamot sa itinakdang oras</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio4_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 6">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">V. PHARMACY SERVICE (SERBISYO NG
                                            BOTIKA)</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang botika ng Panlalawigang Ospital at ang mga tauhan
                                            nito
                                            ay:</v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>N/A-Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_5"
                                        row
                                        @change="toggleCheckall(5)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio5_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio5_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio5_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Medicines are always available (Maging sapat at available na
                                                    mga
                                                    gamot)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio5_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Medical Equipment and supplies are always available (May sapat
                                                    at
                                                    available na kagamitang medical or medical)
                                                    supplies</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio5_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 7">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">VI. LABORATORY SERVICES (SERBISYO
                                            LABORATORYO)</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang laboratoryo ng Panlalawigang Ospital at mga tauhan
                                            ay:
                                        </v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>N/A-Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_6"
                                        row
                                        @change="toggleCheckall(6)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio6_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio6_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio6_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Provides proper and clear explanation of the process that will
                                                    be
                                                    done (Nagpapaliwanag ng kanyang ginagawang pamamaraan)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio6_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Laboratory results are released on time (Mabilis na maibibigay
                                                    ang
                                                    resulta sa mga laboratory test)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio6_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 8">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">VII. SERBISYO NG IMAGING O XRAY
                                            DEPARTMENT</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang botika ng Panlalawigan Ospital at ang mga tauhan nito
                                            ay:
                                        </v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_7"
                                        row
                                        @change="toggleCheckall(7)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>

                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio7_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio7_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio7_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Provides help and assistance in aligning the body properly for
                                                    the
                                                    xray (Tumutulong o inaasistehan ako sa tamang pagposisyon sa
                                                    x-ray)</b>
                                            </v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio7_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Imaging/ Xray results are released on time (Mabilis na
                                                    naibibigay
                                                    ang resulta ng x-ray)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio7_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 9">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">VIII. Philhealth Section (SERBISYO NG
                                            PHILHEALTH SEKSYON)</b>
                                    </v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang PHILHEALTH seksyon ng Panlalawigan Ospital at ang mga
                                            tauhan ay:</v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_8"
                                        row
                                        @change="toggleCheckall(8)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio8_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio8_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio8_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Clearly explains the coverage of the benefits (Maayos
                                                    magpaliwanag
                                                    ng mga benepisyo)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio8_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Appropriate benefits are granted and processed accordingly
                                                    (Naiibigay at naisaayos ang tamang benepisyo)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio8_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 10">

                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">IX. MEDICAL SOCIAL SERVICES SECTION
                                            (SERBISYO NG SOCIAL SERVICES
                                            SEKSYON)</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang Social Services ng Panlalawigan Ospital at mga tauhan
                                            ay:
                                        </v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_9"
                                        row
                                        @change="toggleCheckall(9)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio9_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio9_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous(Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio9_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Clearly explains the coverage of the benefits (Maayos
                                                    magpaliwanag
                                                    ng mga benepisyo)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio9_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Appropriate benefits are granted and processed accordingly
                                                    (Nagbibigay at naisasaayos ng mga benepisyo)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio9_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 11">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">

                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">X. BILLING SERVICES (SERBISYO NG
                                            BILLING
                                            SEKSYON)</b>
                                    </v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang isinisilbing pagkain sa Panlalawigan Ospital
                                            ay:</v-col>
                                        <br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_10"
                                        row
                                        @change="toggleCheckall(10)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio10_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b>
                                            </v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio10_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio10_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Appropriate Philhealth Benefits are accurately deducted from
                                                    the
                                                    patient's bill (Tamang pagbawas ng benepisyo ng
                                                    Philhealth)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio10_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Statement of Accounts are accurately computed (Tamang tuos ng
                                                    mga
                                                    bayarin sa gamutan)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio10_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>


                        <div v-if="currentStep === 12">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">XI. SERBISYO NG MEDICAL RECORDS
                                            SEKSYON</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang sekyon ng Medical Records at mga tauhan
                                            ay:</v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_11"
                                        row
                                        @change="toggleCheckall(11)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio11_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio11_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio11_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Requested medical documents are released on time (Mabilis na
                                                    naibibigay ang mga dokumentong hinihingi)</b></v-col>
                                            <v-col>
                                                <v-radio-group :disabled="isDisabled" v-model="radio11_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                        </div>

                        <div v-if="currentStep === 13">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">XII. SERBISYO NG MGA GUWARDYA</b>
                                    </v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang mga guwardya ng Panlalawigan Ospital ay:</v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_12"
                                        row
                                        @change="toggleCheckall(12)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio12_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio12_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio12_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Diligently guards all entrances and exits (Mahigpit na
                                                    binabantayan
                                                    ang mga pumapasok at lumalabas ng ospital)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio12_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Assists in the Implementation of the hospital rules and
                                                    policies
                                                    (Tumutulong sa pagpapatupad ng mga alituntunin)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio12_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <div v-if="currentStep === 14">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">XIII. SERBISYO NG KANTINA O
                                            CANTEEN.</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang kantina ng Panlalawigan Ospital at mga tauhan ay:
                                        </v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_13"
                                        row
                                        @change="toggleCheckall(13)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio13_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio13_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous(Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio13_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Foods sold are nutritious and delicous (Masasarap at
                                                    masustansya
                                                    ang mga binebentang pagkain)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio13_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Foods sold are budget-friedly (Abot kaya ang presyo ng mga
                                                    pagkain)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio13_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>


                        <div v-if="currentStep === 15">
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">XIV. SERBISYO NG AMBULANSIYA</b>
                                    </v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">Ang mga ambulansya ng Panlalawigan Ospital at mga tauhan
                                            ay:
                                        </v-col><br>
                                        <v-col cols="4"><b>1- Hindi Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>2- Bahagyang Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>3- Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>4- Labis na Nasiyahan:</b></v-col>
                                        <v-col cols="4"><b>0- Hindi Angkop:</b></v-col>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item-content three-line>
                                    <v-col cols="12">
                                        Check All Fields?
                                        <v-radio-group
                                        v-model="checkradioall_14"
                                        row
                                        @change="toggleCheckall(14)"
                                        required
                                        >
                                        <v-radio
                                        label="1"
                                        value="1"
                                        ></v-radio>
                                        <v-radio
                                        label="2"
                                        value="2"
                                        ></v-radio>
                                        <v-radio
                                        label="3"
                                        value="3"
                                        ></v-radio>
                                        <v-radio
                                        label="4"
                                        value="4"
                                        ></v-radio>
                                        <v-radio
                                        label="N/A"
                                        value="0"
                                        ></v-radio>
                                        </v-radio-group>
                                    </v-col>

                                </v-list-item-content>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>A. Fast (Mabibilis)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio14_a" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>B. Kind (Mababait)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio14_b" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>C. Courteous (Magagalang)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio14_c" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>D. Patients are well-treated (Maayos na pagtrato sa
                                                    pasyente)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio14_d" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>E. Overall efficiency of the ambulance driver, ambulance medical
                                                    staff, and the ambulance service as a whole (Kahusayan ng ambulansya
                                                    driver, medical staff na kasama sa
                                                    ambulansya at kabuuan ng serbisyo)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio14_e" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
                                                    <v-radio label="N/A" value="0"></v-radio>
                                                </v-radio-group>
                                                <b>Very Satisfied</b>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>

                            <br>
                        </div>

                        <div v-if="currentStep === 16">

                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>Karagdagang Komento o Mungkahi</b></v-col>
                                            <v-col>
                                                <v-textarea :disabled="isDisabled" v-model="comments"
                                                    name="input-7-1" filled label="Karagdagan Komento o Mungkahi"
                                                    auto-grow value="" :rules="nameRules"
                                                    required></v-textarea>
                                            </v-col>
                                        </v-col>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>
                        <center>
                            <v-btn width="500" color="primary " @click="previousStep" v-if="currentStep > 1"
                                x-large>←
                                Previous</v-btn>

                            <v-btn  v-show="isVisible == true" width="500" color="primary " @click="nextStep" :disabled="!valid"
                                v-if="currentStep < totalSteps" x-large>Next →</v-btn>

                            <v-btn width="500" @click="clear_btn()" color="primary "
                                v-if="currentStep == totalSteps" x-large>Clear
                                Form</v-btn>
                            <v-btn  width="500" color="primary" @click="save_btn()" :disabled="!valid"
                                v-if="currentStep == totalSteps" x-large>Submit ↑</v-btn>

                            <v-btn v-show="isVisible == false" width="1000" color="primary"  @click="save_btn()"
                            x-large>Submit ↑</v-btn>
                        </center>
            </div>
            </v-form>
            <!-- </v-layout> -->
            </v-container>
    </div>
    </v-app>
    </div>
    <button id="scrollToTop">^</button>
</body>
<script src="/vendor/vue/js/vue.js"></script>
<script src="/vendor/vue/js/Vuetify.js"></script>
<script src="/vendor/assets/Vuetify/axios.min.js"></script>
<script>
    // Get the button element
    var scrollToTopBtn = document.getElementById("scrollToTop");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };

    // Smooth scroll to the top of the document
    function scrollToTopAnimated() {
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;

        if (currentScroll > 0) {
            window.requestAnimationFrame(scrollToTopAnimated);
            window.scrollTo(0, currentScroll - (currentScroll / 10));
        }
    }

    scrollToTopBtn.addEventListener("click", function() {
        scrollToTopAnimated();
    });

    window.onload = function() {
        scrollToTopAnimated();
    }
</script>
<script src="/js/form_pss.js"></script>
<!-- <script src="/vendor/AdminLTE3/plugins/jquery/jquery.min.js"></script> -->
<!-- <script>
    setTimeout(function() {
        $('.loader_bg').fadeToggle();
    }, 1500);
</script> -->

</html>
