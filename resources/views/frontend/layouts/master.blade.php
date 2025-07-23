<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    @include('frontend.layouts.head')

<body dir="rtl">

<!-- لودر -->
{{-- <div class="loader-wrapper">
    <div class="spinner-border" role="status" style="width: 85px; height: 85px; color: #d4b1f5">
        <span class="sr-only">Loading...</span>
    </div>
</div> --}}

<!-- Start Top Header Area -->
{{-- @include('frontend.layouts.top-header') --}}
<!-- End Top Header Area -->

<!-- Start Navbar Area -->
{{-- @include('frontend.layouts.navbar') --}}
<!-- End Navbar Area -->


    @yield('content')


<!-- Start Footer Area -->
@include('frontend.layouts.footer')
<!-- End Footer Area -->

    <div class="go-top business-color"><i class="fas fa-chevron-up"></i></div>

    @include('frontend.layouts.script')

</body>
</html>
