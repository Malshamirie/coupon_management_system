@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.loyalty_campaigns') }}
@endsection

@section('title')
  {{ __('back.loyalty_campaigns') }}
@endsection

@section('content')
  <!-- إحصائيات حملات الولاء -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-right-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                إجمالي الحملات
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_campaigns'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-right-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                الحملات النشطة
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['active_campaigns'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-play-circle fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-right-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                الحملات القادمة
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['upcoming_campaigns'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clock fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>





  

  <div class="row mb-2" id="table-bordered">
    @can('add_loyalty_campaign')
      <div class="col-md-9">
        <a class="btn btn-secondary" href="{{ route('admin.loyalty_campaigns.create') }}">
          <i class="fas fa-plus"></i>
          {{ __('back.add_loyalty_campaign') }}
        </a>
      </div>
    @endcan

    {{-- @can('loyalty_campaigns')
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
    @endcan --}}
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
                <label for="loyalty_container_id">{{ __('back.filter_by_loyalty_container') }}</label>
                <select name="loyalty_container_id" id="loyalty_container_id" class="form-control">
                  <option value="">{{ __('back.select_loyalty_container') }}</option>
                  @foreach ($loyaltyContainers as $loyaltyContainer)
                    <option value="{{ $loyaltyContainer->id }}" {{ request('loyalty_container_id') == $loyaltyContainer->id ? 'selected' : '' }}>
                      {{ $loyaltyContainer->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label for="search_campaign">{{ __('back.search_campaign') }}</label>
                <input type="text" name="search_campaign" id="search_campaign" class="form-control" 
                       value="{{ request('search_campaign') }}" 
                       placeholder="{{ __('back.search_campaign_placeholder') }}">
              </div>
              <div class="col-md-3">
                <label>&nbsp;</label>
                <div>
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                  <a href="{{ route('admin.loyalty_campaigns.index') }}"
                    class="btn btn-secondary"><i class="fas fa-sync-alt"></i></a>
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
                  <th>{{ trans('back.container') }}</th>
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
                    <td>{{ $campaign->start_date }}</td>
                    <td>{{ $campaign->end_date }}</td>
                    <td>
                      {{ $campaign->loyaltyContainer->name??'-' }}
                      <br>

                      <a href="{{ route('admin.customers.index', ['loyalty_container_id' => $campaign->loyalty_container_id]) }}">
                       {{ __('back.customers') }}  ({{ $campaign->loyaltyContainer->customers_count }})
                      </a>
                    </td>
                    <td>{{ $campaign->created_at }}</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="actionsDropdown{{ $campaign->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fas fa-cogs"></i> {{ __('back.actions') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="actionsDropdown{{ $campaign->id }}">
                          @can('edit_loyalty_campaign')
                            <li>
                              <a class="dropdown-item" href="{{ route('admin.loyalty_campaigns.edit', $campaign->id) }}">
                                <i class="fas fa-edit text-success"></i> {{ __('back.edit') }}
                              </a>
                            </li>
                          @endcan

                          @can('delete_loyalty_campaign')
                            <li>
                              <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#delete_campaign{{ $campaign->id }}">
                                <i class="fas fa-trash-alt"></i> {{ __('back.delete') }}
                              </a>
                            </li>
                          @endcan

                          @can('show_loyalty_campaign')
                            <li>
                              <a class="dropdown-item" href="{{ route('admin.loyalty_campaigns.show', $campaign->id) }}">
                                <i class="fas fa-eye text-dark"></i> {{ __('back.show') }}
                              </a>
                            </li>
                          @endcan

                          <li>
                            <a class="dropdown-item" href="{{ route('loyalty.campaign.landing', $campaign->slug) }}" target="_blank">
                              <i class="fas fa-external-link-alt text-info"></i> {{ __('back.landing_page') }}
                            </a>
                          </li>

                          @can('send_loyalty_campaign')
                            <li>
                              <a class="dropdown-item" href="{{ route('admin.loyalty_campaigns.send', $campaign->id) }}">
                                <i class="fas fa-paper-plane text-warning"></i> {{ __('back.send_campaign') }}
                              </a>
                            </li>
                            {{-- <li>
                              <a class="dropdown-item" href="{{ route('loyalty_campaigns.test-whatsapp', $campaign->id) }}">
                                <i class="fas fa-paper-plane text-warning"></i> {{ __('back.send_test_whatsapp') }}
                              </a>
                            </li> --}}
                          @endcan

                          <li>
                            <a class="dropdown-item" href="{{ route('admin.loyalty_campaign_recipients.index', ['campaign_id' => $campaign->id]) }}">
                              <i class="fas fa-users text-info"></i> عرض المستقبلين
                            </a>
                          </li>
                        </ul>
                      </div>
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
  {{-- <div class="row mt-3">
    <div class="col-12">
      <button id="export-selected" class="btn btn-primary" disabled>
        <i class="fas fa-download"></i> {{ __('back.export_campaigns') }}
      </button>
    </div>
  </div> --}}
@endsection

@push('styles')
<style>
  .border-right-primary {
    border-right: 0.25rem solid #4e73df !important;
  }
  .border-right-success {
    border-right: 0.25rem solid #1cc88a !important;
  }
  .border-right-info {
    border-right: 0.25rem solid #36b9cc !important;
  }
  .border-right-warning {
    border-right: 0.25rem solid #f6c23e !important;
  }
  .border-right-danger {
    border-right: 0.25rem solid #e74a3b !important;
  }
  .text-gray-300 {
    color: #dddfeb !important;
  }
  .text-gray-800 {
    color: #5a5c69 !important;
  }
  .card {
    transition: transform 0.2s ease-in-out;
  }
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  }
  .text-xs {
    font-size: 0.7rem;
  }
  .font-weight-bold {
    font-weight: 700 !important;
  }
  .text-uppercase {
    text-transform: uppercase !important;
  }
</style>
@endpush

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
