@extends('layouts.master')

@section('page_title', $page['title'])

@section('page_name', $page['name'])

@section('page_css')

@section('page_script')

@endsection

@section('content')

    <style>
        button {
            padding: 10px 20px;
            background-color: #f0f0f0;
            cursor: pointer;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        /* .box {
                                      animation: upAndDown 2.5s;
                                    }

                                    @keyframes upAndDown {
                                      0%, 100% {
                                        transform: translateY(0);
                                      }
                                      50% {
                                        transform: translateY(-20px);
                                      }
                                    } */
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Title</h3>
                    <!-- <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                          <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                          <i class="fas fa-times"></i>
                                        </button>
                                    </div> -->
                </div>
                <div class="card-body">
                    <section class="content">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-4 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-info box">
                                        <div class="inner">
                                            <h3>
                                                <div id="total_survey">0</div>
                                            </h3>

                                            <p>Overall of Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-4 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success box">
                                        <div class="inner">
                                            <h3>
                                                <div id="count_css">0</div>
                                            </h3>

                                            <p>Total of CSS</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-4 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-warning box">
                                        <div class="inner">
                                            <h3>
                                                <div id="count_pss">0</div>
                                            </h3>

                                            <p>Total of PSS</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                        </div>
                                        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                                    </div>
                                </div>
                                <!-- ./col -->
                                <!-- <div class="col-lg-3 col-6">
                                    <div class="small-box bg-danger">
                                    <div class="inner">
                                    <h3>65</h3>

                                    <p>Unique Visitors</p>
                                    </div>
                                    <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                    </div> -->
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->
                            <!-- Main row -->
                            <div class="row">
                                <!-- Left col -->
                                <section class="col-lg-12 connectedSortable">
                                    <!-- Custom tabs (Charts with tabs)-->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <div class="w3-bar w3-white">
                                                    <button class="w3-bar-item w3-button" onclick="openCity('London')">No of
                                                        CSS Per month</button>
                                                    <button class="w3-bar-item w3-button" onclick="openCity('Paris')">No of
                                                        PSS Per month</button>

                                                </div>
                                            </h3>
                                        </div><!-- /.card-header -->
                                        <div class="card-body">

                                            <div id="London" class="w3-container city">
                                                <canvas id="line_chart_css" width="1200" height="1000"></canvas>
                                            </div>

                                            <div id="Paris" class="w3-container city" style="display:none">
                                                <canvas id="line_chart_pss" width="1200" height="1000"></canvas>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.card -->

                                    <!-- DIRECT CHAT -->
                                    <!-- <div class="card direct-chat direct-chat-primary">
                                    <div class="card-header">
                                    <h3 class="card-title">Chart 2</h3>

                                    </div>

                                    <div class="card-footer">

                                    </div>

                                    </div> -->
                                </section>
                                <!-- /.Left col -->
                                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                                <section class="col-lg-5 connectedSortable">

                                    <!-- Map card -->
                                    <!-- <div class="card">
                                    <div class="card-header border-0">
                                    <h3 class="card-title">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Chart 3
                                    </h3>
                                    </div>
                                    <div class="card-body">
                                    <div id="world-map" style="height: 500px; width: 100%;">
                                    <div class="chart-container" style="position: relative; height:500px;">
                                    <canvas id="myChart3"></canvas>
                                    </div>
                                    </div>
                                    </div>
                                    </div> -->
                                    <!-- /.card -->

                                </section>
                                <!-- right col -->
                            </div>
                            <!-- /.row (main row) -->
                        </div><!-- /.container-fluid -->
                    </section>
                </div>
                <!-- <div class="card-footer">
                                    Footer
                                    </div> -->
            </div>
        </div>
    </div>
    <script src="/js/chart.js"></script>
    <script>
        function chart_boxes() {
            fetch('/count_chart').then(res => {
                return res.json()
            }).then(res => {
                console.log(res[0])
                document.getElementById('total_survey').textContent = res[0].total_survey
                document.getElementById('count_css').textContent = res[0].count_form_css
                document.getElementById('count_pss').textContent = res[0].count_form_pss


                // Get the counter element
                const counterElementCSS = document.getElementById('count_css');
                const counterElementPSS = document.getElementById('count_pss');
                const counterElementOVERALL = document.getElementById('total_survey');

                // Define the target number
                const targetNumberCSS = res[0].count_form_css;
                const targetNumberPSS = res[0].count_form_pss;
                const targetNumberOVERALL = res[0].total_survey;

                function countToTargetNumberCSS() {
                    let currentNumberCSS = parseInt(counterElementCSS.textContent);
                    if (currentNumberCSS === targetNumberCSS) {
                        clearInterval(countIntervalCSS);
                        return;
                    }
                    currentNumberCSS++;
                    counterElementCSS.textContent = currentNumberCSS.toString();
                }

                function countToTargetNumberPSS() {
                    let currentNumberPSS = parseInt(counterElementPSS.textContent);
                    if (currentNumberPSS === targetNumberPSS) {
                        clearInterval(countIntervalPSS);
                        return;
                    }
                    currentNumberPSS++;
                    counterElementPSS.textContent = currentNumberPSS.toString();
                }

                function countToTargetNumberOVERALL() {
                    let currentNumberOVERALL = parseInt(counterElementOVERALL.textContent);
                    if (currentNumberOVERALL === targetNumberOVERALL) {
                        clearInterval(countIntervalOVERALL);
                        return;
                    }
                    currentNumberOVERALL++;
                    counterElementOVERALL.textContent = currentNumberOVERALL.toString();
                }
                const countIntervalCSS = setInterval(countToTargetNumberCSS, 5000);
                const countIntervalPSS = setInterval(countToTargetNumberPSS, 5000);
                const countIntervalOVERALL = setInterval(countToTargetNumberOVERALL, 5000);



            })
        }

        function line_chart_css() {
            let dd
            fetch('/monthly_css').then(res => {
                return res.json()
            }).then(res => {
                dd = Object.values(res[0])
                console.log(dd)
                var data1 = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'Total of CSS per month',
                        data: dd,
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 2,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(0, 123, 255, 1)',
                        fill: false
                    }]
                };

                var options = {
                    responsive: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                };

                var ctx1 = document.getElementById('line_chart_css').getContext('2d');
                var lineChart = new Chart(ctx1, {
                    type: 'line',
                    data: data1,
                    options: options
                });

            })
        }


        function line_chart_pss() {
            fetch('/monthly_pss').then(res => {
                return res.json()
            }).then(res => {
                dd = Object.values(res[0])
                console.log(dd)
                var data2 = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'Total of PSS per month',
                        data: dd,
                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 2,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(0, 123, 255, 1)',
                        fill: false
                    }]
                };

                var options = {
                    responsive: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                };

                var ctx2 = document.getElementById('line_chart_pss').getContext('2d');
                var lineChart = new Chart(ctx2, {
                    type: 'line',
                    data: data2,
                    options: options
                });

            })
        }

        function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }



        chart_boxes()
        line_chart_css()
        line_chart_pss()
    </script>
@endsection
