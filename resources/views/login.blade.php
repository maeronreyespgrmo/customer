<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customer Feedback System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/images/seal_laguna.png" />

    <link rel="stylesheet" type="text/css" href="/vendor/login/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/vendor/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/vendor/css-hamburgers/hamburgers.min.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/vendor/animsition/css/animsition.min.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/vendor/select2/select2.min.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/vendor/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" type="text/css" href="/vendor/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="/vendor/login/css/main.css">
    <link href="/vendor/vue/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/vendor/vue/css/vuetify.min.css" rel="stylesheet">

    <meta name="robots" content="noindex, follow">
    <style>
        #bgframe {
            animation: fade 2s;
        }

        @keyframes fade {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        [v-cloak] {
            display: none;
        }

        /* .v-snack__wrapper.theme--dark {
    background-color: #4CAF50;
    color: hsla(0,0%,100%,.87);
} */
    </style>
</head>

<body style="background-color: #666666;">
    <!-- Loader -->
    <!-- <div id="preloader">
<div id="status">
<div class="spinner">
<div class="double-bounce1"></div>
<div class="double-bounce2"></div>
</div>
</div>
</div> -->
    <!-- Loader -->
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div id="app" v-cloak>
                    <v-app id="inspire">
                        <v-snackbar v-model='snackbar' :color='snackbarcolor' top="top" style="margin-top:0">
                            @{{ snackbartext }}
                        </v-snackbar>
                        <div class="login100-form validate-form">

                            <span class="login100-form-title p-b-43">
                                Login to continue
                            </span>
                            <v-text-field label="Username" v-model="username"></v-text-field>
                            <v-text-field label="Password" @keyup="key_btn()" v-model="password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'"
                                @click:append="show1 = !show1"></v-text-field>

                            <div class="flex-sb-m w-full p-t-3 p-b-32">
                                <v-checkbox v-model="rememberme" label="Remember Me"></v-checkbox>
                            </div>
                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn" @click="login_btn()">
                                    Login
                                </button>
                            </div>
                        </div>
                </div>

                <div id="bgframe" class="login100-more"
                    style="background-image: url('/vendor/login/images/capitol.jpg');">
                </div>
            </div>
            </v-app>
        </div>
    </div>

    <script src="/vendor/login/vendor/jquery/jquery-3.2.1.min.js"></script>

    <script src="/vendor/login/vendor/animsition/js/animsition.min.js"></script>

    <script src="/vendor/login/vendor/bootstrap/js/popper.js"></script>
    <script src="/vendor/login/vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="/vendor/login/vendor/select2/select2.min.js"></script>

    <script src="/vendor/login/vendor/daterangepicker/moment.min.js"></script>
    <script src="/vendor/login/vendor/daterangepicker/daterangepicker.js"></script>

    <script src="/vendor/login/vendor/countdowntime/countdowntime.js"></script>

    <script src="/vendor/login/js/main.js"></script>


    <script src="/vendor/vue/js/vue.js"></script>
    <script src="/vendor/vue/js/Vuetify.js"></script>
    <script src="/vendor/assets/Vuetify/axios.min.js"></script>

    <script>
        let app = new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data: () => ({
                username: "",
                password: "",
                rememberme: false,
                show1: false,
                snackbar: false,
                snackbartext: "",
                snackbarcolor: "",
            }),
            created() {
                this.initialize()
            },
            methods: {
                initialize() {
                    this.username = localStorage.getItem('username')
                    this.password = localStorage.getItem('password')
                    if (this.username) {
                        this.rememberme = true
                    }
                },

                login_btn() {
                    if (this.rememberme) {
                        localStorage.setItem("username", this.username);
                        localStorage.setItem("password", this.password);
                    }

                    axios.post('/login_auth', {
                            username: this.username,
                            password: this.password
                        })
                        .then((response) => {
                            if (response.data == "success") {
                                this.snackbartext = "Success"
                                this.snackbarcolor = "success"
                                this.snackbar = true
                                location.href = "/dashboard/"
                            } else {
                                this.snackbartext = "Failed"
                                this.snackbarcolor = "error"
                                this.snackbar = true
                            }
                        }).catch(err => {
                            console.log(err)
                            this.snackbartext = "Database Server has been Turn off"
                            this.snackbarcolor = "red"
                            this.snackbar = true
                        })
                },
                key_btn() {
                    if (event.keyCode === 13) {
                        // Call your function here
                        this.login_btn()
                    }
                },
            }
        })
    </script>
</body>

</html>
