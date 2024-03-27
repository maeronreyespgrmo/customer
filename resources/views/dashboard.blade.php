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
                                <div class="col-lg-6">
   <!-- Left col -->
                                 <section class="connectedSortable">
    
                                    <!-- Custom tabs (Charts with tabs)-->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            <i class="fas fa-chart-pie mr-1"></i>
                                            Analytics
                                            </h3><br>
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

                                            <div id="London" class=" w3-container city">
                                                <canvas id="line_chart_css" width="800" height="600"></canvas>
                                            </div>

                                            <div id="Paris" class="col-lg-6 w3-container city" style="display:none">
                                                <canvas id="line_chart_pss" width="800" height="600"></canvas>
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
                                <!-- right col -->
                                </div>

                                <div class="col-lg-6">
   <!-- Left col -->
                                 <section class="connectedSortable">
    
                                    <!-- Custom tabs (Charts with tabs)-->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            <i class="fas fa-chart-pie mr-1"></i>
                                            Forecast
                                            </h3><br>
                                            <h3 class="card-title">
                                                <div class="w3-bar w3-white">
                                                    <button class="w3-bar-item w3-button" onclick="predictCity('London')">No of
                                                        CSS Per month</button>
                                                    <button class="w3-bar-item w3-button" onclick="predictCity('Paris')">No of
                                                        PSS Per month</button>

                                                </div>
                                            </h3>
                                        </div><!-- /.card-header -->
                                        <div class="card-body">

                                            <div id="London" class=" w3-container predictcity">
                                                <canvas id="prediction_chart_css" width="800" height="600"></canvas>
                                            </div>

                                            <div id="Paris" class="col-lg-6 w3-container predictcity" style="display:none">
                                                <canvas id="prediction_chart_pss" width="800" height="600"></canvas>
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
                                <!-- right col -->
                                </div>
                             
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
    <script src="/js/brain.js"></script>
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

        function prediction_chart_css() {
            let dd
            fetch('/prediction_css').then(res => {
                return res.json()
            }).then(res => {
                dd = Object.values(res[0])
                let arr = []
                res.map(x=>{
                    arr.push({input: ["2023"], output: { outcome: x.cc_id, name: x.office_name }})
                })
             
            // Create and configure the neural network
            const net = new brain.NeuralNetwork();
            net.train(arr);

            // Prepare input for prediction (replace with features for the current year)
            const inputForCurrentYear = [2025];

            // Make a prediction for the current year
            const outputForCurrentYear = net.run(inputForCurrentYear);

            // Sort predicted outcomes based on output value
            const sortedOutcomes = Object.keys(outputForCurrentYear).sort((a, b) => outputForCurrentYear[b] - outputForCurrentYear[a]);

            // Select top 1 to 5 outcomes for the current year, including names
            const topOutcomesForCurrentYear = sortedOutcomes.map((x,y) => ({
            name: arr[y].output.name,
            outcome: outputForCurrentYear[x]
            }));

            const cc_title = topOutcomesForCurrentYear.map(aa=> Object.keys(aa).filter(x=> x!="outcome").reduce((acc,keys)=>{
            acc[keys] = aa[keys]
            return acc
            },{}))

            const cc_value = topOutcomesForCurrentYear.map(aa=> Object.keys(aa).filter(x=> x!="name").reduce((acc,keys)=>{
            acc[keys] = aa[keys]
            return acc
            },{}))

            console.log("Prediction CSS",outputForCurrentYear)
            var data1 = {
            labels: cc_title.map(x=> {
            return Object.values(x)
            },{}).flat(),

                datasets: [{
                label: 'Top CSS for 2025',
                data: cc_value.map(x=> {
                return Object.values(x)
                },{}).flat(),
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

                var ctx3 = document.getElementById('prediction_chart_css').getContext('2d');
                var lineChart = new Chart(ctx3, {
                    type: 'line',
                    data: data1,
                    options: options
                });

            })
        }

        function prediction_chart_pss() {
            fetch('/prediction_pss').then(res => {
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

                var ctx2 = document.getElementById('prediction_chart_pss').getContext('2d');
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

        function predictCity(cityName) {
            var i;
            var x = document.getElementsByClassName("predictcity");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }

        chart_boxes()
        line_chart_css()
        line_chart_pss()
        prediction_chart_css()
        prediction_chart_pss()
    </script>
@endsection
