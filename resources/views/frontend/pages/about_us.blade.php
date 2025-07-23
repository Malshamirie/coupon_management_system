
@extends('frontend.layouts.master')

@section('meta_keywords')
    @if(app()->getLocale() == 'ar'){{$about_us->meta_keywords_ar}}@else{{$about_us->meta_keywords_en}}@endif
@endsection

@section('meta_description')
    @if(app()->getLocale() == 'ar'){{$about_us->meta_description_ar}}@else{{$about_us->meta_description_en}}@endif
@endsection

@section('title')
    {{ trans('back.about_us') }}
@endsection


@section('content')
<!-- Start Page Title Area -->
<div class="page-title-area style-four" style="padding-top: 30px; padding-bottom: 30px; background-color: #a9a9a9">
    <div class="container">
        <div class="page-title-content text-start">
            <h2 class=" text-dark" style="font-size: 32px">
                {{ trans('back.about_us') }}
            </h2>
        </div>
    </div>
</div>
<!-- End Page Title Area -->

<!-- End Page Title Area -->

<!-- Start About Area -->
<section class="about-area ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="about-image">
                    {{-- <img src="{{ asset($about_us->bg) }}" class="shadow" alt="image"> --}}
                    <img src="{{ asset($about_us->image_about_us) }}" class="shadow" alt="image">
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="about-content">
                    <span class="sub-title">{{ trans('back.about_us') }} </span>

                    <h2>@if(app()->getLocale() == 'ar'){{$about_us->company_name_ar}}@else{{$about_us->company_name_en}}@endif</h2>
                    <h6>@if(app()->getLocale() == 'ar'){{$about_us->short_about_ar}}@else{{$about_us->short_about_en}}@endif </h6>
                    <p>@if(app()->getLocale() == 'ar'){{$about_us->about_ar}}@else{{$about_us->about_en}}@endif</p>


                </div>
            </div>
        </div>
    </div>
</section>

<section class="whyUs py-5 mb-5" id="whyUs">
    <div class="container p-4">
        <div class="sec-header text-center mb-5">
            <h3 class="text-uppercase m-0 text-second" >لماذا تختارنا</h3>
        </div>

        <div class="row g-4 align-items-stretch mt-3">
          @foreach (App\Models\Info::all() as $info)
          <div class="col-md-4">
              <div class="service-card d-flex flex-column justify-content-center h-100">
                <div class="single-contact-info-box style-two">
                    <div class="icon">
                        <i class="{{ $info->icon }}"></i>
                    </div>
                      <h4>@if(app()->getLocale() == 'ar'){{$info->name_ar}}@else{{$info->name_en}}@endif</h4>
                  </div>
                  <p>@if(app()->getLocale() == 'ar'){{$info->body_ar}}@else{{$info->body_en}}@endif</p>
              </div>
          </div>
          @endforeach

      </div>

    </div>
  </section>
<!-- End About Area -->
@endsection
