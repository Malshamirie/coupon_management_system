<div class="preview-content">
  <div class="row">
    <div class="col-12">
      <div class="alert alert-info">
        <h6><i class="fas fa-info-circle"></i> {{ __('back.campaign_preview_info') }}</h6>
        <p>{{ __('back.you_are_about_to_send_campaign_to') }} <strong>{{ $customers->count() }}</strong>
          {{ __('back.customers') }}</p>
      </div>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h6>{{ __('back.campaign_details') }}</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>{{ __('back.campaign_name') }}:</strong> {{ $loyaltyCampaign->campaign_name }}</p>
              <p><strong>{{ __('back.sending_method') }}:</strong> {{ $loyaltyCampaign->sending_method_text }}</p>
              <p><strong>{{ __('back.manager_name') }}:</strong> {{ $loyaltyCampaign->manager_name }}</p>
            </div>
            <div class="col-md-6">
              <p><strong>{{ __('back.start_date') }}:</strong> {{ $loyaltyCampaign->start_date }}</p>
              <p><strong>{{ __('back.end_date') }}:</strong> {{ $loyaltyCampaign->end_date }}</p>
              <p><strong>{{ __('back.loyalty_card') }}:</strong> {{ $loyaltyCampaign->loyaltyCard->name ?? '--' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h6>{{ __('back.selected_customers') }} ({{ $customers->count() }})</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="table-light">
                <tr class="text-center">
                  <th>#</th>
                  <th>{{ trans('back.customer') }}</th>
                  <th>{{ trans('back.phone_number') }}</th>
                  <th>{{ trans('back.email') }}</th>
                  <th>{{ trans('back.container') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($customers as $key => $customer)
                  <tr class="text-center">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email ?? '--' }}</td>
                    <td>{{ $customer->loyaltyContainer->name ?? '--' }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">{{ __('back.no_customers_selected') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if ($loyaltyCampaign->sending_method === 'whatsapp')
    <div class="row mt-3">
      <div class="col-12">
        <div class="alert alert-warning">
          <h6><i class="fas fa-exclamation-triangle"></i> {{ __('back.whatsapp_notice') }}</h6>
          <p>{{ __('back.whatsapp_messages_will_be_sent_via_queue') }}</p>
        </div>
      </div>
    </div>
  @endif

  @if ($loyaltyCampaign->sending_method === 'email')
    <div class="row mt-3">
      <div class="col-12">
        <div class="alert alert-warning">
          <h6><i class="fas fa-exclamation-triangle"></i> {{ __('back.email_notice') }}</h6>
          <p>{{ __('back.email_messages_will_be_sent_immediately') }}</p>
        </div>
      </div>
    </div>
  @endif
</div>
