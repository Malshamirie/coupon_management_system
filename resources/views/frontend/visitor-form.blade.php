

@extends('frontend.layouts.master')
@section('page_title')
    {{trans('back.home')}}
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/css/intlTelInput.css">
  <style>
    .iti {
    width: 100%;
}
  </style>
@endsection

@section('content')
    <!-- Start Blog Area -->
<div class="blog-area ptb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 m-auto">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3">
                            @csrf
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="phoneNumber" class="mb-1">رقم الجوال</label>
                                    <div class="w-100">
                                        <input id="phone" type="tel" class="form-control w-100" name="phone" autocomplete="tel" required dir="ltr" style="direction: ltr">
                                    </div>
                                        {{-- <input id="phone" type="tel" class="form-control" name="phone" placeholder="500 000 000" autocomplete="tel" style="direction: ltr"> --}}
                                    @error('phone') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                                <div id="result"></div>

                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary w-100" id="submit"> تحقق </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@include('frontend.visitor-form-js')
@endsection
