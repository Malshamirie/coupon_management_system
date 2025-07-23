<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{trans('back.login')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content=" {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('logo.ico')}}">

    @if (App::getLocale() == 'ar')
        <!-- Bootstrap Css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/assets/css/app-rtl.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @else
        <!-- Bootstrap Css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('backend/assets/css/app.min.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />
    @endif


    <link href="{{asset('backend/assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />

    {{-- Google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400&display=swap" rel="stylesheet">

    <!-- custom css -->
    <link href="{{asset('backend/custom.css')}}" id="app-stylesheet" rel="stylesheet" type="text/css" />

    <style>
        @yield('css')
    </style>

</head>

<body class="authentication-bg20" style="background-image: url({{asset('backend/bg.jpg')}}) " >

    <div class="account-pages mt-5 mb-5">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="text-center">
                        <a href="/" class="logo text-center">
                            <img  src="{{ asset('logo.png') }}" width="250"  alt=" {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}">
                        </a>
                        <h4 class=" mt-2 mb-2">
                            {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}
                        </h4>
                    </div>

                    @include('flash-message')
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-3">
                                <h4 class="text-uppercase mt-0"> {{trans('back.employee_login')}}</h4>
                            </div>

                            <form method="post" action="{{ route('employee_login_post') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="emailaddress"> {{trans('back.Email')}}</label>
                                    <input class="form-control" type="email" name="email" id="email" required autofocus placeholder="{{trans('back.Email')}}" value="{{old('email')}}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">{{trans('back.password')}}</label>
                                    <input class="form-control" type="password" name="password" required autocomplete="current-password"   id="password" placeholder="{{trans('back.password')}}">
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-purple btn-block" type="submit"> {{trans('back.Login')}}</button>
                                </div>

                            </form>

                            <div class="text-center mt-2">
                                {{trans('auth.programming_development')}}
                                <a href="https://mazoonsoft.com" target="_blank"> {{trans('auth.mazoonsoft')}}</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>

