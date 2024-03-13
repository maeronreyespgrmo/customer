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

        body {
            background-color: rgb(228 219 241);
            margin: 0;
        }

        /* Styles for the scroll to top button */
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

        @media (max-width: 600px) {
            .others_remarks {
                position: absolute;
                background-color: green;
                top: 35em;
                left: 7em;
            }

        }

        @media (max-width: 1000px) {
            .others_remarks {
                position: absolute;
                top: 1em;
                left: 7em;
            }

        }

        .others_remarks {
            position: absolute;
            top: 17em;
            left: 7em;
        }

        .v-application--wrap {
            flex: 1 1 auto;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            display: flex;
            flex-direction: column;
            min-height: 0vh;
            max-width: 100%;
            position: relative;
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
            <div style="background-color: rgb(228 219 241);">
                <v-container>
                    <v-toolbar dark prominent src="/images/capitol.jpg">


                        <!-- <v-toolbar-title>Vuetify</v-toolbar-title> -->

                        <v-spacer></v-spacer>

                    </v-toolbar>
                    <br>
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-card class="mx-auto text-center" max-width="1200" outlined rounded raised>

                            <table style="width: 100%;">
                                <tr>
                                    <td width="15%">
                                        <center> <img src="/images/seal_laguna.png" alt="" width="100"
                                                height="100" align="left"> </center>
                                    </td>
                                    <td align="center">
                                        <p class="font-11">Republic of the Philippines</p>
                                        <p class="font-11">INTERNAL AUDIT SERVICES</p>
                                        <p style="font-size: 12pt"><b>PROVINCIAL GOVERNMENT OF
                                                LAGUNA</b></p>
                                        <p class="font-11">Pedro Guevara Street, Santa Cruz
                                            Laguna</p>
                                        <p class="font-11">CUSTOMER SATISFACTION QUESTIONAIRRE
                                        </p>
                                    </td>
                                    <td width="15%"><img src="/images/coa-logo.png" height="120" width="120"
                                            alt="Image"></td>
                                </tr>
                            </table>

                            </v-list-item-content>
                            </v-list-item>
                        </v-card>
                        <br>
                        <div v-if="currentStep === 1">
                            <v-card class="mx-auto" max-width="1200" outlined rounded raised class="justify-center">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">Details</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-select :disabled="isDisabled" v-model="office_name"
                                                :items="office_items" label="Pumili ng Opisina" :rules="nameRules"
                                                required @change="service_dropdown"></v-select>
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
                                                <v-date-picker v-model="dates" @input="menu = false"></v-date-picker>
                                            </v-menu>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field :disabled="isDisabled" v-model="name_evaluator"
                                                label="Name of Evaluator" dense></v-text-field>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-text-field :disabled="isDisabled" v-model="name_evaluatee"
                                                label="Name of Evaluatee" dense></v-text-field>
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
                                    <v-col cols='12'><b class="white--text">I. Requested Service / Hilling na
                                            Serbisyo</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <!-- <v-col><b>I. Requested Service / Hilling na Serbisyo</b></v-col><br> -->
                                        <v-col cols="12">
                                            {{-- <v-radio-group :disabled="isDisabled" v-model="services" column
                                                :rules="nameRules" required>
                                                <v-radio label="Option 1" v-for="(item,index) in checkbox_data"
                                                    :key="index" :label="item.name"
                                                    :value="item.name">
                                                </v-radio>
                                            </v-radio-group>--}}
                                            <v-checkbox
                                            v-model="services"
                                            v-for="(item,index) in checkbox_data"
                                            :key="item.name"
                                            :label="item.name"
                                            :value="item.name"
                                            :rules="[v => !!v || 'Please select at least one service']"
                                            required
                                            ></v-checkbox>
                                            <v-text-field :disabled="isDisabled" v-model="others_remarks"
                                                label=""></v-text-field>
                                                Check All Fields?
                                                <v-radio-group
                                                v-model="checkradioall"
                                                row
                                                @change="toggleCheckall()"
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

                                    <v-col cols='12'><b class="white--text">Privacy Notice</b></v-col>
                                </v-sheet>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <!-- <v-col><b>Privacy Notice</b></v-col><br> -->
                                        <v-col cols="12">
                                            By accomplishing this form you give PGL the right to process your personal
                                            information in accordance to the purpose of this questionaire.
                                        </v-col>
                                        <v-col cols="12">
                                            II. Using the scores from 1 to 4, please rate the servicing office personnel
                                            based on the following:<br>
                                            (Gamit a/ng score na 1 to 4, mangyari po bigyan ng puntos ang empleyadong
                                            nagbigay serbisyo):<br>
                                        </v-col>
                                        <v-col cols="6">
                                            1 – Not Satisfied (Hindi Nasiyahan)<br>
                                            3 – Satisfied/Nasiyahan
                                        </v-col>
                                        <v-col cols="6">
                                            2 – Slightly Satisfied/Bahagyang Nasiyahan<br>
                                            4 - Very Satisfied/Labis na Nasiyahan
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">Delivery(Serbisyo)</b></v-col>
                                </v-sheet>

                                <v-list-item>
                                    <v-col><b>Scoring Scale:
                                            1 = Not Satisfied, 2 = Slightly Satisfied, 3 = Satisfied, 4 = Very Satisfied
                                        </b>
                                    </v-col>
                                </v-list-item>

                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>1.How satisfied are you overall with the service you received?
                                                    (Sa pangkalahatan, gaano kayo nasiyahan/kontento sa serbisyong
                                                    natanggap?)</b></v-col>

                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_1" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                            <v-col><b>2.How satisfied are you with the speed in which the service was
                                                    delivered?
                                                    (Gaano kayo nasiyahan/kontento sa bilis ng serbisyong
                                                    natanggap?)</b>
                                            </v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_2" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">

                                <v-sheet class="d-flex" color="indigo" height="50">
                                    <v-col cols='12'><b class="white--text">Communications
                                            (Komunikasyon)</b></v-col>
                                </v-sheet>

                                <v-list-item>
                                    <v-col><b>Scoring Scale:
                                            1 = Not Satisfied, 2 = Slightly Satisfied, 3 = Satisfied, 4 = Very Satisfied
                                        </b>
                                    </v-col>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>3.How satisfied are you with the ease of contacting the person you
                                                    needed?
                                                    (Gaano kayo nasiyahan/kontento sa bilis ng pagkakatagpo sa taong
                                                    kailangan?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_3" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                            <v-col><b>4.How satisfied are you with the clarity of information or advice
                                                    provided?
                                                    (Gaano kayo nasiyahan/kontento sa linaw ng impormasyon o payong
                                                    natanggap?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_4" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                            <v-col><b>5.How satisfied are you with the time taken to respond to
                                                    enquiries?
                                                    (Gaano kayo nasiyahan/kontento sa maagap na pagtugon sa
                                                    katanungan/kailangan?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_5" column
                                                    max-width="1200" :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                    <v-col cols='12'><b class="white--text">Quality of Staff (Kalidad ng
                                            Empleyado)</b></v-col>
                                </v-sheet>

                                <v-list-item>
                                    <v-col><b>Scoring Scale:
                                            1 = Not Satisfied, 2 = Slightly Satisfied, 3 = Satisfied, 4 = Very Satisfied
                                        </b>
                                    </v-col>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>6.How satisfied are you with the relevant knowledge of the staff
                                                    you
                                                    dealt directly with?
                                                    (Gaano kayo nasiyahan/kontento sa pagtugon ng empleyado batay sa
                                                    kanyang
                                                    kaalaman?</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_6" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                            <v-col><b>7.How satisfied are you with the courtesy of the staff?
                                                    (Gaano kayo nasiyahan/kontento sa pakikitungo ng
                                                    empleyado?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_7" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                            <v-col><b>8.How satisfied are you with the helpfulness of the staff?
                                                    (Gaano kayo nasiyahan/kontento sa pagtulong ng
                                                    empleyado?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_8" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                            <v-col><b>9.How satisfied are you that the staff showed interest in you as
                                                    an
                                                    individual/treated
                                                    you as a valued customer?
                                                    (Gaano kayo nasiyahan/kontento sa serbisyong ibinigay ng empleyado
                                                    batay
                                                    sa
                                                    pagpapahalagang natanggap bilang kustomer?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_9" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                    <v-col cols='12'><b class="white--text">Quality of Work (Kalidad ng
                                            Trabaho)</b>
                                    </v-col>
                                </v-sheet>

                                <v-list-item>
                                    <v-col><b>Scoring Scale:
                                            1 = Not Satisfied, 2 = Slightly Satisfied, 3 = Satisfied, 4 = Very Satisfied
                                        </b>
                                    </v-col>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>10.How satisfied are you with the quality of work/service by the
                                                    staff
                                                    you dealt directly with in terms of accuracy and completeness?
                                                    (Gaano
                                                    kayo nasiyahan/kontento sa trabaho/serbisyo ng empleyado batay sa
                                                    kawastuhan at pagkakumpleto?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_10" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                            <v-col><b>11.How satisfied are you with the works undertaken? (Gaano kayo
                                                    nasiyahan/kontento sa trabaho/serbisyong natanggap?)</b></v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_11" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                    <v-col cols='12'><b class="white--text">Problem Solving (Pagbibigay ng
                                            Solusyon)</b></v-col>
                                </v-sheet>

                                <v-list-item>
                                    <v-col><b>Scoring Scale:
                                            1 = Not Satisfied, 2 = Slightly Satisfied, 3 = Satisfied, 4 = Very Satisfied
                                        </b>
                                    </v-col>
                                </v-list-item>
                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>12.How satisfied are you with the way problems were resolved?</b>
                                            </v-col>
                                            <v-col>
                                                <b>Not Satisfied</b>
                                                <v-radio-group :disabled="isDisabled" v-model="radio_12" column
                                                    :rules="nameRules" required>
                                                    <v-radio label="1" value="1"></v-radio>
                                                    <v-radio label="2" value="2"></v-radio>
                                                    <v-radio label="3" value="3"></v-radio>
                                                    <v-radio label="4" value="4"></v-radio>
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
                                    <v-col cols='12'><b class="white--text">Comments/Suggestion
                                            (Komento/Mungkahi)</b></v-col>
                                </v-sheet>

                            </v-card>
                            <br>
                            <v-card max-width="1200" outlined rounded raised class="mx-auto">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-col cols="12">
                                            <v-col><b>Please let us know if you have any further comments to your
                                                    responses,
                                                    or any suggestions on how we could improve our services.</b></v-col>
                                            <v-col>
                                                <v-textarea :disabled="isDisabled" name="input-7-1" filled
                                                    label="Your Suggestions" v-model="comments" auto-grow
                                                    :rules="nameRules" required>
                                                </v-textarea>
                                            </v-col>
                                        </v-col>

                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                            <br>
                        </div>

                        <center>
                            <v-btn width="500" color="primary" @click="previousStep" v-if="currentStep > 1"
                                x-large>←
                                Previous</v-btn>

                            <v-btn v-show="isVisible == true" width="500" color="primary" :disabled="!valid" @click="nextStep"
                                :disabled="!valid" v-if="currentStep < totalSteps" x-large>Next →</v-btn>

                            <v-btn width="500" @click="clear_btn()" color="primary "
                                v-if="currentStep == totalSteps" x-large>Clear
                                Form</v-btn>

                            <v-btn width="500" color="primary" :disabled="!valid" @click="save_btn()"
                                v-if="currentStep == totalSteps" x-large>Submit ↑</v-btn>

                            <v-btn :disabled="!valid" v-show="isVisible == false" width="1000" color="primary"  @click="save_btn()"
                             x-large>Submit ↑</v-btn>

                        </center>



            </div>

            </v-container>


    </div>
    <div>

    </div>

    </v-app>
    </div>

    <button id="scrollToTop">^</button>
</body>
<script src="/vendor/vue/js/vue.js"></script>
<script src="/vendor/vue/js/Vuetify.js"></script>
<script src="/vendor/assets/Vuetify/axios.min.js"></script>
{{-- ONNSCROLL --}}
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
<script src="/js/form_css.js?v=2"></script>
<!-- <script src="/vendor/AdminLTE3/plugins/jquery/jquery.min.js"></script>
<script>
    setTimeout(function() {
        $('.loader_bg').fadeToggle();
    }, 1500);
</script> -->

</html>
