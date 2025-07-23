<!DOCTYPE html>
<html lang="en">
@if(app()->getLocale() == 'ar')  <html lang="en" dir="rtl"> @endif

    @include('backend.layouts.head')
    @yield('css')

    <body class="loading"
          data-layout-mode="horizontal"
          data-layout-color="light"
          data-layout-size="fluid"
          data-topbar-color="light"
          data-leftbar-position="fixed">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page" style="margin-top: 5px">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container">

                        {{-- <!-- start page title -->
                        @include('backend.layouts.page-title-box')
                        <!-- end page title --> --}}

                        {{--loader--}}
                        {{-- @include('loader') --}}
                        {{--loader--}}


                        @yield('content')

                    </div> <!-- container -->

                </div> <!-- content -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        @include('backend.layouts.script')

    </body>
</html>
