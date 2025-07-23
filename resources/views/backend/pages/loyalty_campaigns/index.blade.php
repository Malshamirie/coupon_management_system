@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.loyalty_campaigns') }}
@endsection

@section('title')
  {{ __('back.loyalty_campaigns') }}
@endsection

@section('content')
  <div class="row mb-2" id="table-bordered">
    @can('add_loyalty_campaign')
      <div class="col-md-9">
        <a class="btn btn-secondary" href="{{ route('admin.loyalty_campaigns.create') }}">
          <i class="fas fa-plus"></i>
          {{ __('back.add_loyalty_campaign') }}
        </a>
      </div>
    @endcan

    @can('loyalty_campaigns')
      <div class="col-md-3 mb-1">
        <form action="{{ route('admin.loyalty_campaigns.index') }}" method="GET" role="search">
          <div class="input-group">
            <input type="text" class="form-control" name="query" value="{{ old('query', request()->input('query')) }}"
              placeholder="{{ trans('back.search') }}">
            <button class="btn btn-purple ml-1" type="submit" title="Search">
              <span class="fas fa-search"></span>
            </button>
            <a href="{{ route('admin.loyalty_campaigns.index') }}" class="btn btn-success ml-1" title="Reload">
              <span class="fas fa-sync-alt"></span>
            </a>
          </div>
        </form>
      </div>
    @endcan
  </div>

  <!-- Filters -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.loyalty_campaigns.index') }}" method="GET" id="filters-form">
            <div class="row">
              <div class="col-md-3">
                <label for="card_type">{{ __('back.filter_by_card_type') }}</label>
                <select name="card_type" id="card_type" class="form-control">
                  <option value="">{{ __('back.select_card_type') }}</option>
                  @foreach ($loyaltyCards as $card)
                    <option value="{{ $card->id }}" {{ request('card_type') == $card->id ? 'selected' : '' }}>
                      {{ $card->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label for="created_at_sort">{{ __('back.filter_by_creation_date') }}</label>
                <select name="created_at_sort" id="created_at_sort" class="form-control">
                  <option value="">{{ __('back.select') }}</option>
                  <option value="desc" {{ request('created_at_sort') == 'desc' ? 'selected' : '' }}>
                    {{ __('back.latest') }}</option>
                  <option value="asc" {{ request('created_at_sort') == 'asc' ? 'selected' : '' }}>
                    {{ __('back.oldest') }}</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for="start_date_sort">{{ __('back.filter_by_start_date') }}</label>
                <select name="start_date_sort" id="start_date_sort" class="form-control">
                  <option value="">{{ __('back.select') }}</option>
                  <option value="desc" {{ request('start_date_sort') == 'desc' ? 'selected' : '' }}>
                    {{ __('back.latest') }}</option>
                  <option value="asc" {{ request('start_date_sort') == 'asc' ? 'selected' : '' }}>
                    {{ __('back.oldest') }}</option>
                </select>
              </div>
              <div class="col-md-3">
                <label>&nbsp;</label>
                <div>
                  <button type="submit" class="btn btn-primary">{{ __('back.apply_filters') }}</button>
                  <a href="{{ route('admin.loyalty_campaigns.index') }}"
                    class="btn btn-secondary">{{ __('back.clear_filters') }}</a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="" class="table table-bordered table-sm">
              <thead class="table-light">
                <tr class="text-center">
                  <th width="50">
                    <input type="checkbox" id="select-all">
                  </th>
                  <th>#</th>
                  <th>{{ trans('back.campaign_name') }}</th>
                  <th>{{ trans('back.card_type') }}</th>
                  <th>{{ trans('back.start_date') }}</th>
                  <th>{{ trans('back.end_date') }}</th>
                  <th>{{ trans('back.total_customers') }}</th>
                  <th>{{ trans('back.created_at') }}</th>
                  <th>{{ trans('back.actions') }}</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($campaigns as $key => $campaign)
                  <tr class="text-center">
                    <td>
                      <input type="checkbox" name="campaign_ids[]" value="{{ $campaign->id }}" class="campaign-checkbox">
                    </td>
                    <td>{{ $key + $campaigns->firstItem() }}</td>
                    <td>{{ $campaign->campaign_name }}</td>
                    <td>{{ $campaign->loyaltyCard->name ?? '--' }}</td>
                    <td>{{ $campaign->start_date->format('Y-m-d') }}</td>
                    <td>{{ $campaign->end_date->format('Y-m-d') }}</td>
                    <td>
                      <a href="{{ route('admin.loyalty_campaigns.customers', $campaign->id) }}"
                        class="btn btn-info btn-xs">
                        {{ $campaign->total_customers }}
                      </a>
                    </td>
                    <td>{{ $campaign->created_at->format('Y-m-d') }}</td>
                    <td>
                      @can('edit_loyalty_campaign')
                        <a href="{{ route('admin.loyalty_campaigns.edit', $campaign->id) }}"
                          class="btn btn-success btn-xs ml-1">
                          <i class="fas fa-edit"></i>
                        </a>
                      @endcan

                      @can('delete_loyalty_campaign')
                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#delete_campaign{{ $campaign->id }}">
                          <i class="fas fa-trash-alt"></i>
                        </a>
                      @endcan

                      @can('show_loyalty_campaign')
                        <a href="{{ route('admin.loyalty_campaigns.show', $campaign->id) }}"
                          class="btn btn-dark btn-xs ml-1">
                          <i class="fas fa-eye"></i>
                        </a>
                      @endcan

                      <a href="{{ route('loyalty.campaign.landing', $campaign->id) }}" target="_blank"
                        class="btn btn-info btn-xs ml-1">
                        <i class="fas fa-external-link-alt"></i>
                      </a>

                      @can('send_loyalty_campaign')
                        <a href="{{ route('admin.loyalty_campaigns.send', $campaign->id) }}"
                          class="btn btn-warning btn-xs ml-1">
                          <i class="fas fa-paper-plane"></i>
                        </a>
                      @endcan

                      @can('send_loyalty_campaign')
                        <a href="{{ route('loyalty_campaigns.test-whatsapp', $campaign->id) }}"
                          class="btn btn-warning btn-xs ml-1">
                          <i class="fas fa-paper-plane"></i>oooooooo
                        </a>
                      @endcan

                      <a href="{{ route('admin.loyalty_campaign_recipients.index', ['campaign_id' => $campaign->id]) }}" 
                        class="btn btn-info">
                        <i class="fas fa-users"></i> عرض المستقبلين
                     </a>
                    </td>
                  </tr>
                  @include('backend.pages.loyalty_campaigns.delete')
                @endforeach
              </tbody>
            </table>
            {!! $campaigns->appends(Request::all())->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Export Button -->
  <div class="row mt-3">
    <div class="col-12">
      <button id="export-selected" class="btn btn-primary" disabled>
        <i class="fas fa-download"></i> {{ __('back.export_campaigns') }}
      </button>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      // Select all functionality
      $('#select-all').change(function() {
        $('.campaign-checkbox').prop('checked', $(this).is(':checked'));
        updateExportButton();
      });

      // Individual checkbox change
      $('.campaign-checkbox').change(function() {
        updateExportButton();

        // Update select all checkbox
        var totalCheckboxes = $('.campaign-checkbox').length;
        var checkedCheckboxes = $('.campaign-checkbox:checked').length;

        if (checkedCheckboxes === 0) {
          $('#select-all').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
          $('#select-all').prop('indeterminate', false).prop('checked', true);
        } else {
          $('#select-all').prop('indeterminate', true);
        }
      });

      function updateExportButton() {
        var checkedCount = $('.campaign-checkbox:checked').length;
        $('#export-selected').prop('disabled', checkedCount === 0);
      }

      // Export functionality
      $('#export-selected').click(function() {
        var selectedIds = [];
        $('.campaign-checkbox:checked').each(function() {
          selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
          alert('{{ __('back.please_select_campaigns') }}');
          return;
        }

        $.ajax({
          url: '{{ route('admin.loyalty_campaigns.export') }}',
          method: 'POST',
          data: {
            campaign_ids: selectedIds,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            alert(response.message);
            // Reset checkboxes
            $('.campaign-checkbox').prop('checked', false);
            $('#select-all').prop('checked', false);
            updateExportButton();
          },
          error: function(xhr) {
            alert(xhr.responseJSON.error || '{{ __('back.error_occurred') }}');
          }
        });
      });
    });
  </script>
@endpush
