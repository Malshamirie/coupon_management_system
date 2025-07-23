<!doctype html>
<html lang="en" data-theme-mode="purple">

<head>

    <meta charset="utf-8" />
    <title>404 Error | RS </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.ico')}}">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{asset('backend/assets/css/preloader.min.css')}}" type="text/css" />

    <link href="{{asset('backend/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />


</head>

<body data-topbar="dark">

<!-- <body data-layout="horizontal"> -->

<div class="my-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5 pt-5">
                    <h1 class="error-title mt-5"><span>404!</span></h1>
                    <h4 class="text-uppercase mt-5">Sorry, page not found</h4>
                    <div class="mt-5 text-center">
                        {{-- <a class="btn btn-primary waves-effect waves-light" href="{{route('dashboard.index')}}">Back to Home</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container -->
</div>
<!-- end content -->


<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- JAVASCRIPT -->
<script src="{{asset('backend/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/feather-icons/feather.min.js')}}"></script>
<!-- pace js -->
<script src="{{asset('backend/assets/libs/pace-js/pace.min.js')}}"></script>

</body>
</html>
