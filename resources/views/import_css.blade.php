@extends('layouts.master')

@section('page_title', $page['title'])

@section('page_name', $page['name'])

@section('page_css')

    <link href="/vendor/vue/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/vendor/vue/css/vuetify.min.css" rel="stylesheet">
    <style>
        .v-pagination {
            align-items: center;
            display: inline-flex;
            list-style-type: none;
            justify-content: center;
            margin: 0;
            max-width: 100%;
            width: 100%;
            margin-left: 80px;
            margin-right: 80px;
        }

        [v-cloak]>* {
            display: none;
        }

        [v-cloak]::before {
            content: "loading...";
        }

        .theme--light.v-application {
            background: #fff;
            color: rgba(0, 0, 0, .87);
            height: 100px;
        }
    </style>

@section('content')
    <div id="app" v-cloak>
        <v-app id="inspire">
            <v-snackbar v-model='snackbar' :color='snackbarcolor' top="top" style="margin-top:0;z-index:9000">
                @{{ snackbartext }}
            </v-snackbar>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
<h3 class="card-title">Title</h3>
<div class="card-tools"> --}}
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                            <i class="fas fa-minus"></i>
                                                            </button> -->
                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                                            <i class="fas fa-times"></i>
                                                            </button> -->
                        {{-- </div>
</div> --}}
                        {{-- <div class="card-body"> --}}
                        <v-dialog v-model="dialog1" max-width="900" style='z-index:20001;'>
                            <v-card>
                                <v-card-title class="text-h5">
                                    Import File
                                </v-card-title>
                                <v-card-text>
                                    <v-col cols="12">
                                        <input type="file" id="inputFile" @change="upload" />
                                    </v-col>
                                </v-card-text>



                                <v-card-actions>
                                    <v-spacer></v-spacer>

                                    <v-btn color="green darken-1" text @click="dialog1 = false">
                                        Cancel
                                    </v-btn>

                                    <v-btn color="green darken-1" :disabled="isButtonDisabled" text @click="save_btn()">
                                        Ok
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-data-table :headers="headers" :items="data" sort-by="id" class="elevation-1"
                            :loading="loader" :loading-text="loader_text">
                            <template v-slot:top>
                                <v-toolbar flat :style="{ padding: '15px' }">

                                    <v-col cols="4">
                                        <v-select v-model="selectedOffice" :items="selectedItemOffice"
                                            label="Select Office">
                                        </v-select>
                                    </v-col>

                                    <v-col cols="4">
                                        <v-text-field v-model="search" label="Search" single-line>
                                        </v-text-field>
                                    </v-col>

                                    <v-btn color="primary" @click="search_btn">Search</v-btn>


                                    <v-spacer></v-spacer>
                                    <v-dialog v-model="dialog" max-width="800px" style='z-index:20001;'>
                                        <template v-slot:activator="{ on, attrs }">
                                            <!-- <v-btn
                                                            color="primary"
                                                            dark
                                                            class="mb-2"
                                                            >
                                                            Import
                                                            </v-btn> -->
                                            &nbsp;
                                            <v-btn color="primary" dark class="mb-2" @click.stop="dialog1 = true">
                                                <v-icon>mdi-import</v-icon>
                                                Import File
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="text-h5">@{{ formTitle }}</span>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-container>
                                                    <v-form ref="form" v-model="valid" lazy-validation>
                                                        <v-row>
                                                            <v-col cols="12">
                                                                <v-text-field v-model="editedItem.service_name"
                                                                    :rules="nameRules" label="Service Name" required>
                                                                </v-text-field>
                                                            </v-col>

                                                        </v-row>
                                                </v-container>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <!-- <v-btn
                                                            color="blue darken-1"
                                                            text
                                                            @click="close"
                                                            >
                                                            Cancel
                                                            </v-btn>
                                                            <v-btn
                                                            color="blue darken-1"
                                                            text
                                                            @click="save"
                                                            >
                                                            Save
                                                            </v-btn> -->
                                            </v-card-actions>
                                            </v-form>
                                        </v-card>
                                    </v-dialog>
                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                        <v-card>
                                            <v-card-title class="text-h5">Are you sure you want to delete this item?
                                            </v-card-title>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                                <v-btn color="blue darken-1" :disabled="isButtonDisabled" text
                                                    @click="deleteItemConfirm">OK</v-btn>
                                                <v-spacer></v-spacer>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-toolbar>
                            </template>
                            <template v-slot:item.status="{ item }">

                                <v-chip :color="getColor(item.status)" dark>
                                    @{{ item.status }}
                                </v-chip>

                            </template>
                            <template v-slot:item.actions="{ item }">

                                <v-btn small class="success" @click="editItem(item)">
                                    <v-icon>mdi-account-search</v-icon>
                                    View
                                </v-btn>
                                <!-- <v-btn small class="warning" @click="editItem(item)">Edit</v-btn>
                                                            <v-btn small class="error" @click="deleteItem(item)">Delete</v-btn> -->

                            </template>
                            <template v-slot:item.comment_status="{ item }">
                                <v-btn class="ma-2" color="red" dark>
                                    <v-icon small>
                                        mdi-heart
                                    </v-icon>
                                </v-btn>

                            </template>
                        </v-data-table>

                        <v-row class="text-center px-4 align-center" wrap>
                            <v-col class="text-truncate" cols="12" md="2">
                                <!-- Total @{{ totalRecords }} records -->
                            </v-col>
                            <v-col cols="12" md="6">
                                {{-- <v-pagination v-if="data.length > 0" v-model="page" @input="next" :length="pageCount">
                                </v-pagination> --}}
                            </v-col>
                        </v-row>

                        {{-- </div> --}}
                        {{-- <div class="card-footer">
                            Footer
                        </div> --}}
                    </div>
                </div>
            </div>
        </v-app>
    </div>
@endsection
<script src="/vendor/vue/js/vue.js"></script>
<script src="/vendor/vue/js/Vuetify.js"></script>
<script src="/vendor/assets/Vuetify/axios.min.js"></script>
@section('page_script')
    <script type="text/javascript" src="/js/xlsx.full.min.js"></script>
    <script type="text/javascript" src="/js/import_css_script.js"></script>
@endsection
