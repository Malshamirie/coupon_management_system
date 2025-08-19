<head>
  <meta charset="utf-8" />
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta
    content=" {{ app()->getLocale() == 'ar' ? App\Models\Setting::first()->website_name : App\Models\Setting::first()->website_name_en }}"
    name="description" />
  <meta content="Coderthemes" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset(App\Models\Setting::first()->logo) }}">


      <!-- Google Font: Cairo -->
      <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">


  @if (App::getLocale() == 'ar')
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app-rtl.min.css') }}" id="app-stylesheet" rel="stylesheet"
      type="text/css" />
  @else
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />
  @endif
  <!-- Icons Css -->
  <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('backend/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('backend/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css" />
  {{-- Google font --}}
  {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400&display=swap" rel="stylesheet"> --}}

  <!-- custom css -->
  <link href="{{ asset('backend/custom.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />

  @yield('css')
  @livewireStyles
</head>
