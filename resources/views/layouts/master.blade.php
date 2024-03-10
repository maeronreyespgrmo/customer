<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>{{ config('app.name') }} | @yield('page_title')</title>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="/images/seal_laguna.png" />
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="/vendor/AdminLTE3/plugins/fontawesome-free/css/all.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="/vendor/AdminLTE3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!--DATATABLES-->
<link rel="stylesheet" href="/vendor/AdminLTE3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/vendor/AdminLTE3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="/vendor/AdminLTE3/dist/css/adminlte.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* #splash {
position:absolute;
max-width: 10vw;  
height: auto;
line-height: 50px;
margin: 0 auto;  
box-sizing: border-box;
text-align: center;
z-index: 1;
width: 100%;
background-color:black;
}

#splash img {
width: 100%;
height: auto;
} */
/* .preloader{ 
background-color:white;
}
.preloader img{
display: block;
margin-left: auto;
margin-right: auto;
margin-top:auto;
margin-bottom:auto;
} */
[class*=sidebar-dark-] {
    /* background-color: #000000; */
background-color:#192a56;
}
[class*=sidebar-dark-] .sidebar a {
    color: white
}
/* .loader_bg{
    position: fixed;
    z-index: 999999;
    background: #fff;
    width: 100%;
    height: 100%;
}
.loader{
    border: 0 soild transparent;
    border-radius: 50%;
    width: 150px;
    height: 150px;
    margin-top:-50px;
    position: absolute;
    top: calc(50vh - 70px);
    left: calc(50vw - 70px);
}
.loader:before, .loader:after{
    content: '';
    border: 1em solid #aa17f4;
    border-radius: 50%;
    width: inherit;
    height: inherit;
    position: absolute;
    top: 0;
    left: 0;
    animation: loader 2s linear infinite;
    opacity: 0;
}
.loader:before{
    animation-delay: .5s;
}
@keyframes loader{
    0%{
        transform: scale(0);
        opacity: 0;
    }
    50%{
        opacity: 1;
    }
    100%{
        transform: scale(1);
        opacity: 0;
    }
}

*{
    margin: 0;
    padding: 0;
} */

</style>
@yield('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<!--   
<div class="preloader">
    <img src="/vendor/AdminLTE3/dist/img/loader.gif" alt="AdminLTELogo"  width="300" height="200">
  </div>  -->
  <!-- <div class="loader_bg">
    <div class="loader"></div>
</div> -->

<!-- Site wrapper -->
<div class="wrapper">
@include('layouts.header')
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>@yield('page_name')</h1>
        </div>
        @include('layouts.crumb')
    </div>
</div>
</section>

<!-- Main content -->
<section class="content">
<div class="container-fluid">
    @yield('content')
</div>
</section>
</div>

@include('layouts.footer')

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-black"></aside>
</div>

<!-- jQuery -->
<script src="/vendor/AdminLTE3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/vendor/AdminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="/vendor/AdminLTE3/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/AdminLTE3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/vendor/AdminLTE3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/vendor/AdminLTE3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- overlayScrollbars -->
<script src="/vendor/AdminLTE3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/vendor/AdminLTE3/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="/vendor/AdminLTE3/dist/js/demo.js"></script> --}}

<script>
// setTimeout(function(){        
// $('.preloader').fadeOut();
// }, 3000);
// let currentURL = window.location.href;
// let link = currentURL.split("/")
// console.log("link",currentURL.split("/"));

// setTimeout(function(){
// $('.loader_bg').fadeToggle();
// }, 1500);
</script>
@yield('page_script')

</body>

</html>
