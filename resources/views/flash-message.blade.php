@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block ">
        <button type="button" class="close" data-dismiss="alert" style="float: left;">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block text-center ">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block ">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block ">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif

{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger">--}}
{{--        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>--}}
{{--        Please check the form below for errors--}}
{{--    </div>--}}
{{--@endif--}}


@if ($errors->any())
    <div class="alert alert-danger text-center ">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        يرجى التحقق من الأخطاء التالية :
        <ul style="padding: 10px 20px 0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

