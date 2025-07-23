@extends('frontend.layouts.master')
@section('meta_keywords')
    @if(app()->getLocale() == 'ar') {{ App\Models\Setting::first()->meta_keywords_ar }}@else{{ App\Models\Setting::first()->meta_keywords_en }}@endif
@endsection

@section('meta_description')
    @if(app()->getLocale() == 'ar'){{ App\Models\Setting::first()->meta_description_ar }}@else{{ App\Models\Setting::first()->meta_description_en }} @endif
@endsection


@section('title')
    {{ trans('back.contact_us') }}
@endsection
@section('content')
    <!-- Start Page Title Area -->
    <div class="page-title-area style-four" style="padding-top: 30px; padding-bottom: 30px; background-color: #a9a9a9">
        <div class="container">
            <div class="page-title-content text-start">
                <h2 class=" text-dark" style="font-size: 32px">
                    {{ trans('back.contact_us') }}
                </h2>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start Contact Info Area -->
    <section class="contact-info-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-contact-info-box style-two">
                        <div class="icon">
                            <i class='far fa-envelope'></i>
                        </div>

                        <h3>{{ trans('back.email') }}</h3>
                        <p><a href="mailto:{{ $contact_us->email }}">{{ $contact_us->email }}</a></p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-contact-info-box style-two">
                        <div class="icon">
                            <i class='fas fa-map-marker-alt'></i>
                        </div>

                        <h3>{{ trans('back.location') }}</h3>
                        <p><a href="{{ $contact_us->map }}" target="_blank">@if(app()->getLocale() == 'ar'){{$contact_us->address_ar}}@else{{$contact_us->address_en}}@endif</a></p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
                    <div class="single-contact-info-box style-two">
                        <div class="icon">
                            <i class='fas fa-phone-volume'></i>
                        </div>
                        <h3>{{ trans('back.phone') }}</h3>
                        <p><a href="tel:1234567890">{{ $contact_us->phone }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Info Area -->


     <!-- Start Contact Area -->
     <section class="contact-area pb-100">
        <div class="container">
            <div class="section-title">
                <h2>{{ trans('back.drop_Message_for_any_query') }}</h2>
            </div>

            <div class="contact-form">
                <form action="{{route('send_messages')}}" method="post" id="">
                    @csrf
                    <div class="row" id="contactForm">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name" placeholder="{{ trans('back.name') }}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email" placeholder="{{ trans('back.email') }}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <input type="text" name="phone_number" id="phone_number" required data-error="Please enter your number" class="form-control" placeholder="{{ trans('back.phone') }}">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>



                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <textarea name="message" class="form-control" id="message" cols="30" rows="5" required data-error="Write your message" placeholder="Your Message">{{ trans('back.message') }}</textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">{{ trans('back.send_message') }}</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </section>
    <!-- End Contact Area -->


    <div id="map">
        {!! $contact_us->map !!}
    </div>
@endsection
