@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.add_loyalty_campaign') }}
@endsection

@section('title')
  {{ __('back.add_loyalty_campaign') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.loyalty_campaigns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <!-- نوع البطاقة -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="loyalty_card_id">{{ __('back.card_type') }} <span class="text-danger">*</span></label>
                  <select name="loyalty_card_id" id="loyalty_card_id" class="form-control @error('loyalty_card_id') is-invalid @enderror" required>
                    <option value="">{{ __('back.select_card_type') }}</option>
                    @foreach ($loyaltyCards as $card)
                      <option value="{{ $card->id }}" {{ old('loyalty_card_id') == $card->id ? 'selected' : '' }}>
                        {{ $card->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('loyalty_card_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- الحاوية -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="container_id">{{ __('back.container') }} <span class="text-danger">*</span></label>
                  <select name="container_id" id="container_id" class="form-control @error('container_id') is-invalid @enderror" required>
                    <option value="">{{ __('back.select_container') }}</option>
                    @foreach ($containers as $container)
                      <option value="{{ $container->id }}" {{ old('container_id') == $container->id ? 'selected' : '' }}>
                        {{ $container->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('container_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- اسم الحملة -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="campaign_name">{{ __('back.campaign_name') }} <span class="text-danger">*</span></label>
                  <input type="text" name="campaign_name" id="campaign_name" class="form-control @error('campaign_name') is-invalid @enderror" 
                         value="{{ old('campaign_name') }}" required>
                  @error('campaign_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- اسم المدير -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="manager_name">{{ __('back.manager_name') }} <span class="text-danger">*</span></label>
                  <input type="text" name="manager_name" id="manager_name" class="form-control @error('manager_name') is-invalid @enderror" 
                         value="{{ old('manager_name') }}" required>
                  @error('manager_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- تاريخ البداية -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="start_date">{{ __('back.start_date') }} <span class="text-danger">*</span></label>
                  <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                         value="{{ old('start_date') }}" required>
                  @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- تاريخ النهاية -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="end_date">{{ __('back.end_date') }} <span class="text-danger">*</span></label>
                  <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                         value="{{ old('end_date') }}" required>
                  @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- طريقة الإرسال -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="sending_method">{{ __('back.sending_method') }} <span class="text-danger">*</span></label>
                  <select name="sending_method" id="sending_method" class="form-control @error('sending_method') is-invalid @enderror" required>
                    {{-- <option value="">{{ __('back.select_sending_method') }}</option> --}}
                    <option value="whatsapp" {{ old('sending_method') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                    {{-- <option value="email" {{ old('sending_method') == 'email' ? 'selected' : '' }}>Email</option> --}}
                  </select>
                  @error('sending_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- معرف قالب الواتساب -->
              <div class="col-md-6 whatsapp-fields" >
                <div class="form-group">
                  <label for="whatsapp_template_id">{{ __('back.whatsapp_template_id') }}</label>
                  <input type="text" name="whatsapp_template_id" id="whatsapp_template_id" class="form-control @error('whatsapp_template_id') is-invalid @enderror" 
                         value="{{ old('whatsapp_template_id') }}">
                  @error('whatsapp_template_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- رابط صورة الواتساب -->
              <div class="col-md-6 whatsapp-fields" >
                <div class="form-group">
                  <label for="whatsapp_image_url">{{ __('back.whatsapp_image_url') }}</label>
                  <input type="url" name="whatsapp_image_url" id="whatsapp_image_url" class="form-control @error('whatsapp_image_url') is-invalid @enderror" 
                         value="{{ old('whatsapp_image_url') }}" placeholder="https://example.com/image.jpg">
                  @error('whatsapp_image_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- قالب البريد الإلكتروني -->
              <div class="col-md-12 email-fields" style="display: none;">
                <div class="form-group">
                  <label for="email_template">{{ __('back.email_template') }}</label>
                  <textarea name="email_template" id="email_template" rows="5" class="form-control @error('email_template') is-invalid @enderror">{{ old('email_template') }}</textarea>
                  @error('email_template')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- الشروط الإضافية -->
              <div class="col-md-12">
                <div class="form-group">
                  <label for="additional_terms">{{ __('back.additional_terms') }}</label>
                  <textarea name="additional_terms" id="additional_terms" rows="3" class="form-control @error('additional_terms') is-invalid @enderror">{{ old('additional_terms') }}</textarea>
                  @error('additional_terms')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- شعار الصفحة -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="page_logo">{{ __('back.page_logo') }}</label>
                  <input type="file" name="page_logo" id="page_logo" class="form-control @error('page_logo') is-invalid @enderror" accept="image/*">
                  @error('page_logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- النص الرئيسي -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="main_text">{{ __('back.main_text') }}</label>
                  <textarea name="main_text" id="main_text" rows="3" class="form-control @error('main_text') is-invalid @enderror">{{ old('main_text') }}</textarea>
                  @error('main_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- النص الفرعي -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="sub_text">{{ __('back.sub_text') }}</label>
                  <textarea name="sub_text" id="sub_text" rows="3" class="form-control @error('sub_text') is-invalid @enderror">{{ old('sub_text') }}</textarea>
                  @error('sub_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- النص بعد النموذج -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="after_form_text">{{ __('back.after_form_text') }}</label>
                  <textarea name="after_form_text" id="after_form_text" rows="3" class="form-control @error('after_form_text') is-invalid @enderror">{{ old('after_form_text') }}</textarea>
                  @error('after_form_text')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- رابط إعادة التوجيه -->
              <div class="col-md-12">
                <div class="form-group">
                  <label for="redirect_url">{{ __('back.redirect_url') }}</label>
                  <input type="url" name="redirect_url" id="redirect_url" class="form-control @error('redirect_url') is-invalid @enderror" 
                         value="{{ old('redirect_url') }}" placeholder="https://example.com">
                  @error('redirect_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-12">
                <button type="submit" class="btn btn-primary">{{ __('back.save') }}</button>
                <a href="{{ route('admin.loyalty_campaigns.index') }}" class="btn btn-secondary">{{ __('back.cancel') }}</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

{{-- @section('js')
<script>
$(document).ready(function() {
    // إظهار/إخفاء الحقول حسب طريقة الإرسال
    $('#sending_method').change(function() {
        var method = $(this).val();
        
        if (method === 'whatsapp') {
            $('.whatsapp-fields').show();
            $('.email-fields').hide();
        } else if (method === 'email') {
            $('.whatsapp-fields').hide();
            $('.email-fields').show();
        } else {
            $('.whatsapp-fields').hide();
            $('.email-fields').hide();
        }
    });

    // تشغيل عند تحميل الصفحة
    $('#sending_method').trigger('change');
});
</script>
@endsection --}}
