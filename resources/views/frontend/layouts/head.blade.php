<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="keywords" content="@yield('meta_keywords')" />
    <meta name="description" content="@yield('meta_description')" />
    <title>@yield('page_title')</title>
    <link rel="icon" type="{{ asset(App\Models\Setting::first()->logo) }}" href="{{ asset(App\Models\Setting::first()->logo) }}">


        <!-- Arabic CSS files -->
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/bootstrap.rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/magnific-popup.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/odometer.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/rangeSlider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/showMoreItems-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/meanmenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/ar/assets/css/responsive.css') }}">
    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/css/intlTelInput.css"> --}}

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/custom.css') }}">
    @livewireStyles
    @yield('css')
</head>
