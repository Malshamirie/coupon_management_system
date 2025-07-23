@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.test_whatsapp') }} - {{ $loyaltyCampaign->campaign_name }}
@endsection

@section('title')
  {{ __('back.test_whatsapp') }} - {{ $loyaltyCampaign->campaign_name }}
@endsection

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('back.dashboard') }}</a></li>
      <li class="breadcrumb-item"><a
          href="{{ route('admin.loyalty_campaigns.index') }}">{{ __('back.loyalty_campaigns') }}</a></li>
      <li class="breadcrumb-item active">{{ __('back.test_whatsapp') }} - {{ $loyaltyCampaign->campaign_name }}</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5>{{ __('back.test_whatsapp_message') }}</h5>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <h6>{{ __('back.campaign_details') }}</h6>
              <p><strong>{{ __('back.campaign_name') }}:</strong> {{ $loyaltyCampaign->campaign_name }}</p>
              <p><strong>{{ __('back.whatsapp_template_id') }}:</strong>
                {{ $loyaltyCampaign->whatsapp_template_id ?? 'غير محدد' }}</p>
              <p><strong>{{ __('back.whatsapp_image_url') }}:</strong>
                {{ $loyaltyCampaign->whatsapp_image_url ?? 'غير محدد' }}</p>
              <p><strong>{{ __('back.landing_page_link') }}:</strong>
                <a href="{{ app()->environment('production') ? 'https://aldaham.com/loyalty-campaign/' . $loyaltyCampaign->id : 'https://aldaham.com/loyalty-campaign/' . $loyaltyCampaign->id }}"
                  target="_blank">
                  {{ app()->environment('production') ? 'https://aldaham.com/loyalty-campaign/' . $loyaltyCampaign->id : 'https://aldaham.com/loyalty-campaign/' . $loyaltyCampaign->id }}
                </a>
              </p>
            </div>
          </div>

          <form id="test-whatsapp-form">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="phone" class="form-label">{{ __('back.phone_number') }}</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="966501234567"
                    required>
                  <div class="form-text">{{ __('back.phone_format_help') }}</div>
                </div>
              </div>
              <!-- لا يوجد حقل كود أو كوبون -->
            </div>

            <div class="mt-3">
              <button type="submit" class="btn btn-primary" id="test-btn">
                <i class="fas fa-paper-plane"></i> {{ __('back.send_test_message') }}
              </button>
              <a href="{{ route('admin.loyalty_campaigns.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ __('back.back') }}
              </a>
            </div>
          </form>

          <div id="test-results" class="mt-4" style="display: none;">
            <h6>{{ __('back.test_results') }}</h6>
            <div id="results-content"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#test-whatsapp-form').submit(function(e) {
        e.preventDefault();

        var phone = $('#phone').val();
        if (!phone) {
          alert('{{ __('back.please_enter_phone') }}');
          return;
        }

        // تعطيل الزر
        $('#test-btn').prop('disabled', true).html(
          '<i class="fas fa-spinner fa-spin"></i> {{ __('back.sending') }}');

        // نرسل فقط رقم الجوال، والمتغير الثاني هو رابط صفحة الهبوط
        $.ajax({
          url: '{{ route('admin.loyalty_campaigns.test-whatsapp-send', $loyaltyCampaign->id) }}',
          method: 'POST',
          data: {
            phone: phone,
            landing_page: '{{ app()->environment('production') ? 'https://aldaham.com/loyalty-campaign/' . $loyaltyCampaign->id : 'https://aldaham.com/loyalty-campaign/' . $loyaltyCampaign->id }}',
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $('#test-results').show();
            var html = '<div class="alert alert-' + (response.success ? 'success' : 'danger') + '">';
            html += '<h6>' + (response.success ? '{{ __('back.success') }}' : '{{ __('back.error') }}') +
              '</h6>';
            html += '<p><strong>{{ __('back.status') }}:</strong> ' + response.status + '</p>';
            html += '<p><strong>{{ __('back.response') }}:</strong> ' + response.body + '</p>';
            if (response.request_data) {
              html += '<details><summary>{{ __('back.request_data') }}</summary>';
              html += '<pre>' + JSON.stringify(response.request_data, null, 2) + '</pre>';
              html += '</details>';
            }
            html += '</div>';
            $('#results-content').html(html);
          },
          error: function(xhr) {
            $('#test-results').show();
            var html = '<div class="alert alert-danger">';
            html += '<h6>{{ __('back.error') }}</h6>';
            html += '<p>' + (xhr.responseJSON?.message || '{{ __('back.unknown_error') }}') + '</p>';
            if (xhr.responseJSON?.request_data) {
              html += '<details><summary>{{ __('back.request_data') }}</summary>';
              html += '<pre>' + JSON.stringify(xhr.responseJSON.request_data, null, 2) + '</pre>';
              html += '</details>';
            }
            html += '</div>';
            $('#results-content').html(html);
          },
          complete: function() {
            // إعادة تفعيل الزر
            $('#test-btn').prop('disabled', false).html(
              '<i class="fas fa-paper-plane"></i> {{ __('back.send_test_message') }}');
          }
        });
      });
    });
  </script>
@endsection
