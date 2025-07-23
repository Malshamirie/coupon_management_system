@extends('backend.layouts.master')

@section('page_title')
{{ __('back.edit_loyalty_campaign') }}
@endsection

@section('title')
{{ __('back.edit_loyalty_campaign') }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="campaign-form" action="{{ route('admin.loyalty_campaigns.update', $loyaltyCampaign->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- إعدادات الحملة -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-primary">{{ __('back.campaign_settings') }}</h4>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="loyalty_card_id">{{ __('back.card_type') }} <span class="text-danger">*</span></label>
                                <select name="loyalty_card_id" id="loyalty_card_id" class="form-control" required>
                                    <option value="">{{ __('back.select_card_type') }}</option>
                                    @foreach($loyaltyCards as $card)
                                        <option value="{{ $card->id }}" {{ old('loyalty_card_id', $loyaltyCampaign->loyalty_card_id) == $card->id ? 'selected' : '' }}>
                                            {{ $card->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="loyalty_card_id_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="container_id">{{ __('back.select_container') }} <span class="text-danger">*</span></label>
                                <select name="container_id" id="container_id" class="form-control" required>
                                    <option value="">{{ __('back.select_container') }}</option>
                                    @foreach($containers as $container)
                                        <option value="{{ $container->id }}" {{ old('container_id', $loyaltyCampaign->container_id) == $container->id ? 'selected' : '' }}>
                                            {{ $container->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="container_id_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="campaign_name">{{ __('back.campaign_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="campaign_name" id="campaign_name" class="form-control" 
                                       value="{{ old('campaign_name', $loyaltyCampaign->campaign_name) }}" required 
                                       
                                       title="{{ __('back.campaign_name_pattern') }}">
                                <small class="form-text text-muted">{{ __('back.campaign_name_help') }}</small>
                                <div class="invalid-feedback" id="campaign_name_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="card_name">{{ __('back.card_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="card_name" id="card_name" class="form-control" 
                                       value="{{ old('card_name', $loyaltyCampaign->card_name) }}" required>
                                <div class="invalid-feedback" id="card_name_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">{{ __('back.start_date') }} <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control" 
                                       value="{{ old('start_date', $loyaltyCampaign->start_date->format('Y-m-d')) }}" required>
                                <div class="invalid-feedback" id="start_date_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">{{ __('back.end_date') }} <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date" class="form-control" 
                                       value="{{ old('end_date', $loyaltyCampaign->end_date->format('Y-m-d')) }}" required>
                                <div class="invalid-feedback" id="end_date_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="manager_name">{{ __('back.manager_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="manager_name" id="manager_name" class="form-control" 
                                       value="{{ old('manager_name', $loyaltyCampaign->manager_name) }}" required>
                                <div class="invalid-feedback" id="manager_name_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- إعدادات رحلة العميل -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-primary">{{ __('back.customer_journey_settings') }}</h4>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sending_method">{{ __('back.sending_method') }} <span class="text-danger">*</span></label>
                                <select name="sending_method" id="sending_method" class="form-control" required>
                                    <option value="">{{ __('back.select') }}</option>
                                    <option value="whatsapp" {{ old('sending_method', $loyaltyCampaign->sending_method) == 'whatsapp' ? 'selected' : '' }}>{{ __('back.whatsapp') }}</option>
                                    <option value="email" {{ old('sending_method', $loyaltyCampaign->sending_method) == 'email' ? 'selected' : '' }}>{{ __('back.email') }}</option>
                                </select>
                                <div class="invalid-feedback" id="sending_method_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 whatsapp-fields" style="display: {{ $loyaltyCampaign->sending_method == 'whatsapp' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="whatsapp_template_id">{{ __('back.whatsapp_template_id') }}</label>
                                <input type="text" name="whatsapp_template_id" id="whatsapp_template_id" class="form-control" 
                                       value="{{ old('whatsapp_template_id', $loyaltyCampaign->whatsapp_template_id) }}">
                                <div class="invalid-feedback" id="whatsapp_template_id_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 whatsapp-fields" style="display: {{ $loyaltyCampaign->sending_method == 'whatsapp' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="whatsapp_image_url">{{ __('back.whatsapp_image_url') }}</label>
                                <input type="url" name="whatsapp_image_url" id="whatsapp_image_url" class="form-control" 
                                       value="{{ old('whatsapp_image_url', $loyaltyCampaign->whatsapp_image_url) }}">
                                <div class="invalid-feedback" id="whatsapp_image_url_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 email-fields" style="display: {{ $loyaltyCampaign->sending_method == 'email' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="email_template">{{ __('back.email_template') }}</label>
                                <textarea name="email_template" id="email_template" class="form-control" rows="4">{{ old('email_template', $loyaltyCampaign->email_template) }}</textarea>
                                <div class="invalid-feedback" id="email_template_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional_terms">{{ __('back.additional_terms') }}</label>
                                <textarea name="additional_terms" id="additional_terms" class="form-control" rows="4">{{ old('additional_terms', $loyaltyCampaign->additional_terms) }}</textarea>
                                <div class="invalid-feedback" id="additional_terms_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- بيانات واجهة المستخدم -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-primary">{{ __('back.ui_data') }}</h4>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="page_logo">{{ __('back.page_logo') }}</label>
                                <input type="file" name="page_logo" id="page_logo" class="form-control" 
                                       accept="image/*">
                                <small class="form-text text-muted">{{ __('back.max_size_2mb') }}</small>
                                @if($loyaltyCampaign->page_logo)
                                    <div class="mt-2">
                                        <img src="{{ $loyaltyCampaign->page_logo_url }}" alt="Current Logo" class="img-thumbnail" style="max-width: 100px;">
                                    </div>
                                @endif
                                <div class="invalid-feedback" id="page_logo_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="redirect_url">{{ __('back.redirect_url') }}</label>
                                <input type="url" name="redirect_url" id="redirect_url" class="form-control" 
                                       value="{{ old('redirect_url', $loyaltyCampaign->redirect_url) }}">
                                <div class="invalid-feedback" id="redirect_url_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="main_text">{{ __('back.main_text') }}</label>
                                <textarea name="main_text" id="main_text" class="form-control" rows="3">{{ old('main_text', $loyaltyCampaign->main_text) }}</textarea>
                                <div class="invalid-feedback" id="main_text_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sub_text">{{ __('back.sub_text') }}</label>
                                <textarea name="sub_text" id="sub_text" class="form-control" rows="3">{{ old('sub_text', $loyaltyCampaign->sub_text) }}</textarea>
                                <div class="invalid-feedback" id="sub_text_error"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="after_form_text">{{ __('back.after_form_text') }}</label>
                                <textarea name="after_form_text" id="after_form_text" class="form-control" rows="3">{{ old('after_form_text', $loyaltyCampaign->after_form_text) }}</textarea>
                                <div class="invalid-feedback" id="after_form_text_error"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
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

@push('scripts')
<script>
$(document).ready(function() {
    // Show/hide fields based on sending method
    $('#sending_method').change(function() {
        var method = $(this).val();
        $('.whatsapp-fields, .email-fields').hide();
        
        if (method === 'whatsapp') {
            $('.whatsapp-fields').show();
        } else if (method === 'email') {
            $('.email-fields').show();
        }
    });
    
    // Form submission with AJAX
    $('#campaign-form').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success(response.message);
                setTimeout(function() {
                    window.location.href = '{{ route("admin.loyalty_campaigns.index") }}';
                }, 1500);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '_error').text(messages[0]);
                    });
                } else {
                    toastr.error('{{ __("back.error_occurred") }}');
                }
            }
        });
    });
    
    // Remove validation errors on input
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
        $('#' + $(this).attr('id') + '_error').text('');
    });
});
</script>
@endpush 