@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.send_campaign') }} - {{ $loyaltyCampaign->campaign_name }}
@endsection

@section('title')
  {{ __('back.send_campaign') }} - {{ $loyaltyCampaign->campaign_name }}
@endsection

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('back.dashboard') }}</a></li>
      <li class="breadcrumb-item"><a
          href="{{ route('admin.loyalty_campaigns.index') }}">{{ __('back.loyalty_campaigns') }}</a></li>
      <li class="breadcrumb-item active">{{ __('back.send_campaign') }} - {{ $loyaltyCampaign->campaign_name }}</li>
    </ol>
  </nav>

  <div class="row mb-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5>{{ __('back.campaign_details') }}</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>{{ __('back.campaign_name') }}:</strong> {{ $loyaltyCampaign->campaign_name }}</p>
              <p><strong>{{ __('back.sending_method') }}:</strong> {{ $loyaltyCampaign->sending_method_text }}</p>
              <p><strong>{{ __('back.total_customers') }}:</strong> {{ $customers->count() }}</p>
            </div>
            <div class="col-md-6">
              <p><strong>{{ __('back.start_date') }}:</strong> {{ $loyaltyCampaign->start_date->format('Y-m-d') }}</p>
              <p><strong>{{ __('back.end_date') }}:</strong> {{ $loyaltyCampaign->end_date->format('Y-m-d') }}</p>
              <p><strong>{{ __('back.manager_name') }}:</strong> {{ $loyaltyCampaign->manager_name }}</p>
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
          <h5>{{ __('back.select_customers_to_send') }}</h5>
          <div class="mt-2">
            <button type="button" id="select-all-customers"
              class="btn btn-sm btn-primary">{{ __('back.select_all') }}</button>
            <button type="button" id="deselect-all-customers"
              class="btn btn-sm btn-secondary">{{ __('back.deselect_all') }}</button>
          </div>
        </div>
        <div class="card-body">
          <form id="send-campaign-form">
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead class="table-light">
                  <tr class="text-center">
                    <th width="50">
                      <input type="checkbox" id="select-all-checkbox">
                    </th>
                    <th>#</th>
                    <th>{{ trans('back.customer_name') }}</th>
                    <th>{{ trans('back.phone_number') }}</th>
                    <th>{{ trans('back.email') }}</th>
                    <th>{{ trans('back.container') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($customers as $key => $customer)
                    <tr class="text-center">
                      <td>
                        <input type="checkbox" name="customer_ids[]" value="{{ $customer->id }}"
                          class="customer-checkbox" checked>
                      </td>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $customer->name }}</td>
                      <td>{{ $customer->phone }}</td>
                      <td>{{ $customer->email ?? '--' }}</td>
                      <td>{{ $customer->container->name ?? '--' }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center">{{ __('back.no_customers_found') }}</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            @if ($customers->count() > 0)
              <div class="mt-3">
                <button type="button" class="btn btn-primary" id="send-campaign-btn">
                  <i class="fas fa-paper-plane"></i> {{ __('back.send_campaign_to_selected') }}
                </button>
                <a href="{{ route('admin.loyalty_campaigns.index') }}" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> {{ __('back.back') }}
                </a>
              </div>
            @endif
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Preview Modal -->
  <div class="modal fade" id="preview-modal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="previewModalLabel">{{ __('back.campaign_preview') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="preview-content">
            <!-- Preview content will be loaded here -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('back.close') }}</button>
          <button type="button" class="btn btn-primary" id="confirm-send">{{ __('back.confirm_send') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      // Select all functionality
      $('#select-all-checkbox').change(function() {
        $('.customer-checkbox').prop('checked', $(this).is(':checked'));
        updateSendButton();
      });

      // Individual checkbox change
      $('.customer-checkbox').change(function() {
        updateSendButton();

        // Update select all checkbox
        var totalCheckboxes = $('.customer-checkbox').length;
        var checkedCheckboxes = $('.customer-checkbox:checked').length;

        if (checkedCheckboxes === 0) {
          $('#select-all-checkbox').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
          $('#select-all-checkbox').prop('indeterminate', false).prop('checked', true);
        } else {
          $('#select-all-checkbox').prop('indeterminate', true);
        }
      });

      // Select all button
      $('#select-all-customers').click(function() {
        $('.customer-checkbox').prop('checked', true);
        $('#select-all-checkbox').prop('checked', true);
        updateSendButton();
      });

      // Deselect all button
      $('#deselect-all-customers').click(function() {
        $('.customer-checkbox').prop('checked', false);
        $('#select-all-checkbox').prop('checked', false);
        updateSendButton();
      });

      function updateSendButton() {
        var checkedCount = $('.customer-checkbox:checked').length;
        $('#send-campaign-btn').prop('disabled', checkedCount === 0);
      }

      // Form submission
      $('#send-campaign-form').submit(function(e) {
        e.preventDefault();

        var selectedIds = [];
        $('.customer-checkbox:checked').each(function() {
          selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
          alert('{{ __('back.please_select_customers') }}');
          return;
        }

        // Show preview modal
        showPreview(selectedIds);
      });

      function showPreview(customerIds) {
        // Load preview content
        $.ajax({
          url: '{{ route('admin.loyalty_campaigns.send', $loyaltyCampaign->id) }}',
          method: 'GET',
          data: {
            preview: true,
            customer_ids: customerIds
          },
          success: function(response) {
            $('#preview-content').html(response);
            $('#preview-modal').modal('show');
          },
          error: function() {
            alert('{{ __('back.error_loading_preview') }}');
          }
        });
      }

      // Confirm send
      $('#confirm-send').click(function() {
        var selectedIds = [];
        $('.customer-checkbox:checked').each(function() {
          selectedIds.push($(this).val());
        });

        $.ajax({
          url: '{{ route('admin.loyalty_campaigns.send-customers', $loyaltyCampaign->id) }}',
          method: 'POST',
          data: {
            customer_ids: selectedIds,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $('#preview-modal').modal('hide');
            toastr.success(response.message);
            setTimeout(function() {
              window.location.href = '{{ route('admin.loyalty_campaigns.index') }}';
            }, 1500);
          },
          error: function(xhr) {
            alert(xhr.responseJSON.error || '{{ __('back.error_occurred') }}');
          }
        });
      });

      // Initialize
      updateSendButton();
    });
  </script>
@endsection
