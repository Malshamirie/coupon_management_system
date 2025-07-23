@extends('backend.layouts.master')

@section('page_title', __('back.add_campaign'))
@section('title', __('back.add_campaign'))

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"> الرئيسية </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.campaigns.index') }}"> الحملات </a>
            </li>
            <li class="breadcrumb-item active"> اضافة حملة </li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- بيانات الحملة --}}
                <h5>{{ __('back.campaign_data') }}</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">{{ __('back.name') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    

                    <div class="col-md-4 mb-3">
                        <label for="start_date" class="form-label">{{ __('back.start_date') }} <span
                                class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="end_date" class="form-label">{{ __('back.end_date') }} <span
                                class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="manager_name" class="form-label">{{ __('back.manager_name') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" name="manager_name" id="manager_name" class="form-control"
                            value="{{ old('manager_name') }}" required>
                        @error('manager_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="coupon_type" class="form-label">{{ __('back.coupon_type') }} <span
                                class="text-danger">*</span></label>
                        <select name="coupon_type" id="coupon_type" class="form-select" required>
                            <option value="" disabled selected>{{ __('back.select_coupon_type') }}</option>
                            <option value="fixed" {{ old('coupon_type') == 'fixed' ? 'selected' : '' }}>
                                {{ __('back.fixed_value') }}</option>
                            <option value="percentage" {{ old('coupon_type') == 'percentage' ? 'selected' : '' }}>
                                {{ __('back.percentage') }}</option>
                            <option value="cashback" {{ old('coupon_type') == 'cashback' ? 'selected' : '' }}>
                                {{ __('back.cashback') }}</option>
                            <option value="second_invoice_discount"
                                {{ old('coupon_type') == 'second_invoice_discount' ? 'selected' : '' }}>
                                {{ __('back.second_invoice_discount') }}</option>
                        </select>
                        @error('coupon_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="search_method" class="form-label">{{ __('back.search_method') }} <span
                                class="text-danger">*</span></label>
                        <select name="search_method" id="search_method" class="form-select" required>
                            <option value="" disabled selected>{{ __('back.select_search_method') }}</option>
                            <option value="phone" {{ old('search_method') == 'phone' ? 'selected' : '' }}>
                                {{ __('back.phone') }}</option>
                            <option value="email" {{ old('search_method') == 'email' ? 'selected' : '' }}>
                                {{ __('back.email') }}</option>
                        </select>
                        @error('search_method')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="email_domain_div" style="display: none;">
                        <label for="email_domain" class="form-label">{{ __('back.email_domain') }}</label>
                        <input type="text" name="email_domain" id="email_domain" class="form-control"
                            value="{{ old('email_domain') }}" placeholder="{{ __('back.email_domain_placeholder') }}">
                        @error('email_domain')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="otp_required_div" style="display: none;">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="otp_required" value="1" id="otp_required"
                                class="form-check-input" {{ old('otp_required') ? 'checked' : '' }}>
                            <label for="otp_required" class="form-check-label">{{ __('back.otp_required') }}</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3" id="whatsapp_template_div" style="display: none;">
                        <label for="id_template" class="form-label">معرف قالب الواتساب (WhatsApp Template ID)</label>
                        <input type="text" name="id_template" id="id_template" class="form-control"
                            value="{{ old('id_template') }}">
                        @error('id_template')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3" id="whatsapp_image_div" style="display: none;">
                        <label for="whatsapp_image_url" class="form-label">رابط صورة الواتساب</label>
                        <input type="text" name="whatsapp_image_url" id="whatsapp_image_url" class="form-control"
                            value="{{ old('whatsapp_image_url') }}">
                        @error('whatsapp_image_url')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                </div>

                <hr>

                {{-- بيانات المستفيد --}}
                <h5>{{ __('back.beneficiary_data') }}</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="beneficiary" class="form-label">{{ __('back.beneficiary') }}</label>
                        <input type="text" name="beneficiary" id="beneficiary" class="form-control"
                            value="{{ old('beneficiary') }}">
                        @error('beneficiary')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="beneficiary_manager" class="form-label">{{ __('back.beneficiary_manager') }}</label>
                        <input type="text" name="beneficiary_manager" id="beneficiary_manager" class="form-control"
                            value="{{ old('beneficiary_manager') }}">
                        @error('beneficiary_manager')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="beneficiary_contact" class="form-label">{{ __('back.beneficiary_contact') }}</label>
                        <input type="text" name="beneficiary_contact" id="beneficiary_contact" class="form-control"
                            value="{{ old('beneficiary_contact') }}">
                        @error('beneficiary_contact')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="terms" class="form-label">{{ __('back.additional_terms') }}</label>
                        <textarea name="terms" id="terms" rows="4" class="form-control">{{ old('terms') }}</textarea>
                        @error('terms')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr>

                {{-- بيانات واجهة المستخدم --}}
                <h5>{{ __('back.ui_data') }}</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="logo" class="form-label">{{ __('back.logo') }}</label>
                        <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                        @error('logo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="main_text" class="form-label">{{ __('back.main_text') }}</label>
                        <input type="text" name="main_text" id="main_text" value="{{ old('main_text') }}"
                            class="form-control">
                        @error('main_text')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="sub_text" class="form-label">{{ __('back.sub_text') }}</label>
                        <input name="sub_text" id="sub_text" value="{{ old('sub_text') }}" class="form-control">
                        @error('sub_text')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="footer_text" class="form-label">{{ __('back.footer_text') }}</label>
                        <input name="footer_text" id="footer_text" value="{{ old('footer_text') }}"
                            class="form-control">
                        @error('footer_text')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="redirect" class="form-label">{{ __('back.redirect_url') }}</label>
                        <input type="url" name="redirect" id="redirect" class="form-control"
                            value="{{ old('redirect') }}" placeholder="https://example.com">
                        @error('redirect')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="container_id" class="form-label">{{ __('back.container') }} <span
                                class="text-danger">*</span></label>
                        <select name="container_id" id="container_id" class="form-select" required>
                            <option value="" disabled selected>{{ __('back.select_container') }}</option>
                            @foreach ($containers as $container)
                                <option value="{{ $container->id }}"
                                    {{ old('container_id') == $container->id ? 'selected' : '' }}>
                                    {{ $container->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('container_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary">{{ __('back.save') }}</button>
                    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary">{{ __('back.cancel') }}</a>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            function toggleEmailFields() {
                const searchMethod = $('#search_method').val();

                if (searchMethod === 'email') {
                    $('#email_domain_div').show();
                    $('#otp_required_div').show();
                    // إخفاء حقول الواتساب عند اختيار الإيميل
                    $('#whatsapp_template_div').hide();
                    $('#whatsapp_image_div').hide();

                    $('#id_template').val('');
                    $('#whatsapp_image_url').val('');
                } else if (searchMethod === 'phone') {
                    // إخفاء حقول الإيميل
                    $('#email_domain_div').hide();
                    $('#otp_required_div').hide();

                    // إظهار حقول الواتساب
                    $('#whatsapp_template_div').show();
                    $('#whatsapp_image_div').show();
                } else {
                    // إذا لم يختار شيء أو اختيار غير معروف، أخفي كل الحقول الإضافية
                    $('#email_domain_div').hide();
                    $('#otp_required_div').hide();
                    $('#whatsapp_template_div').hide();
                    $('#whatsapp_image_div').hide();

                    $('#email_domain').val('');
                    $('#otp_required').prop('checked', false);
                    $('#id_template').val('');
                    $('#whatsapp_image_url').val('');
                }
            }

            // عند تحميل الصفحة
            toggleEmailFields();

            // عند تغيير الاختيار
            $('#search_method').change(function() {
                toggleEmailFields();
            });
        });
    </script>

@endsection
