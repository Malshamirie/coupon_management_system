<!DOCTYPE html>
<html lang="en">

    @include('backend.layouts.head')
    <body data-layout="horizontal" data-topbar="light">

        <div id="wrapper">

            <div class="content-page"  style="margin-top: -80px">
                <div class="content">
                    <div class="container">
                        @include('flash-message')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

    @include('backend.layouts.script')

    @include('sweetalert::alert')

    </body>
</html>
