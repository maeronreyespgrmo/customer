@extends('layouts.master')

@section('page_title', $page['title'])

@section('page_name', $page['name'])

@section('page_css')

    <link href="/vendor/vue/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/vendor/vue/css/vuetify.min.css" rel="stylesheet">
    <style>
        .theme--light.v-application {
            background: #fff;
            color: rgba(0, 0, 0, .87);
            height: 150px;
            padding: 20px;
        }
    </style>
@section('content')
    <div id="app">
        <v-app id="inspire">
            <v-snackbar v-model='snackbar' :color='snackbarcolor' top="top" style="margin-top:0;z-index:9000">
                @{{ snackbartext }}
            </v-snackbar>
            <div>
                <v-row>
                    <v-col cols="6">
                        <v-combobox v-model="chart_css" :items="items_css" label="Chart Type CSS"></v-combobox>
                    </v-col>
                    <v-col cols="6">
                        <v-combobox v-model="chart_pss" :items="items_pss" label="Chart Type PSS"></v-combobox>
                    </v-col>
                </v-row>
                <v-btn @click="save_btn" color="primary">Save</v-btn>
            </div>




        </v-app>
    </div>
@endsection
<script src="/vendor/vue/js/vue.js"></script>
<script src="/vendor/vue/js/Vuetify.js"></script>
<script src="/vendor/assets/Vuetify/axios.min.js"></script>
@section('page_script')
    <script type="text/javascript" src="/js/chart_settings_script.js"></script>
@endsection
