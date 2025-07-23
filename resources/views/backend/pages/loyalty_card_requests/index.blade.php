@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.loyalty_card_requests') }}
@endsection

@section('title')
  {{ __('back.loyalty_card_requests') }}
@endsection

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('back.dashboard') }}</a></li>
      <li class="breadcrumb-item active">{{ __('back.loyalty_card_requests') }}</li>
    </ol>
  </nav>

  <!-- Filters -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5>{{ __('back.filters') }}</h5>
        </div>
        <div class="card-body">
          <form id="filters-form" method="GET">
            <div class="row">
              <div class="col-md-3">
                <div class="mb-3">
                  <label for="search" class="form-label">{{ __('back.search') }}</label>
                  <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('back.search_loyalty_card_request') }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label for="campaign_id" class="form-label">{{ __('back.filter_by_campaign') }}</label>
                  <select class="form-select" id="campaign_id" name="campaign_id">
                    <option value="">{{ __('back.all_campaigns') }}</option>
                    @foreach ($campaigns as $campaign)
                      <option value="{{ $campaign->id }}"
                        {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
                        {{ $campaign->campaign_name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label for="branch_id" class="form-label">{{ __('back.filter_by_branch') }}</label>
                  <select class="form-select" id="branch_id" name="branch_id">
                    <option value="">{{ __('back.all_branches') }}</option>
                    @foreach ($branches as $branch)
                      <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label for="status" class="form-label">{{ __('back.filter_by_status') }}</label>
                  <select class="form-select" id="status" name="status">
                    <option value="">{{ __('back.all_statuses') }}</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                      {{ __('back.loyalty_card_status_pending') }}
                    </option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                      {{ __('back.loyalty_card_status_approved') }}
                    </option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                      {{ __('back.loyalty_card_status_rejected') }}
                    </option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                      {{ __('back.loyalty_card_status_delivered') }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-search"></i> {{ __('back.search') }}
                </button>
                <a href="{{ route('admin.loyalty_card_requests.index') }}" class="btn btn-secondary">
                  <i class="fas fa-times"></i> {{ __('back.clear') }}
                </a>
                <a href="{{ route('admin.loyalty_card_requests.export') }}" class="btn btn-success">
                  <i class="fas fa-download"></i> {{ __('back.export') }}
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Requests Table -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5>{{ __('back.loyalty_card_requests') }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>{{ __('back.customer_name') }}</th>
                  <th>{{ __('back.customer_phone') }}</th>
                  <th>{{ __('back.loyalty_campaign') }}</th>
                  <th>{{ __('back.branch') }}</th>
                  <th>{{ __('back.status') }}</th>
                  <th>{{ __('back.requested_at') }}</th>
                  <th>{{ __('back.actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($requests as $request)
                  <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->customer_name }}</td>
                    <td>{{ $request->customer_phone }}</td>
                    <td>{{ $request->loyaltyCampaign->campaign_name ?? '--' }}</td>
                    <td>{{ $request->branch->name ?? '--' }}</td>
                    <td>
                      <span class="badge bg-{{ $request->status_badge }}">
                        {{ $request->status_text }}
                      </span>
                    </td>
                    <td>{{ $request->requested_at->format('Y-m-d H:i') }}</td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.loyalty_card_requests.show', $request->id) }}"
                          class="btn btn-sm btn-info" title="{{ __('back.show') }}">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.loyalty_card_requests.edit', $request->id) }}"
                          class="btn btn-sm btn-warning" title="{{ __('back.edit') }}">
                          <i class="fas fa-edit"></i>
                        </a>

                        @if ($request->status == 'pending')
                          <button type="button" class="btn btn-sm btn-success approve-btn" data-id="{{ $request->id }}"
                            title="{{ __('back.approve_request') }}">
                            <i class="fas fa-check"></i>
                          </button>
                          <button type="button" class="btn btn-sm btn-danger reject-btn" data-id="{{ $request->id }}"
                            title="{{ __('back.reject_request') }}">
                            <i class="fas fa-times"></i>
                          </button>
                        @endif

                        @if ($request->status == 'approved')
                          <button type="button" class="btn btn-sm btn-info deliver-btn" data-id="{{ $request->id }}"
                            title="{{ __('back.deliver_card') }}">
                            <i class="fas fa-gift"></i>
                          </button>
                        @endif

                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $request->id }}"
                          title="{{ __('back.delete') }}">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center">{{ __('back.no_loyalty_card_requests_found') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-center">
            {{ $requests->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Reject Modal -->
  <div class="modal fade" id="reject-modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('back.reject_request') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="reject-form">
          <div class="modal-body">
            <div class="mb-3">
              <label for="reject_notes" class="form-label">{{ __('back.notes') }}</label>
              <textarea class="form-control" id="reject_notes" name="notes" rows="3"
                placeholder="{{ __('back.reject_reason') }}"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('back.cancel') }}</button>
            <button type="submit" class="btn btn-danger">{{ __('back.reject') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      // Approve request
      $('.approve-btn').click(function() {
        const id = $(this).data('id');
        if (confirm('{{ __('back.are_you_sure_approve') }}')) {
          $.ajax({
            url: `/{{ app()->getLocale() }}/loyalty-card-requests/${id}/approve`,
            method: 'POST',
            data: {
              _token: '{{ csrf_token() }}'
            },
            success: function(response) {
              toastr.success(response.message);
              setTimeout(() => location.reload(), 1000);
            },
            error: function() {
              toastr.error('{{ __('back.error_occurred') }}');
            }
          });
        }
      });

      // Reject request
      $('.reject-btn').click(function() {
        const id = $(this).data('id');
        $('#reject-modal').modal('show');
        $('#reject-form').data('id', id);
      });

      $('#reject-form').submit(function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const notes = $('#reject_notes').val();

        $.ajax({
          url: `/{{ app()->getLocale() }}/loyalty-card-requests/${id}/reject`,
          method: 'POST',
          data: {
            notes: notes,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            toastr.success(response.message);
            $('#reject-modal').modal('hide');
            setTimeout(() => location.reload(), 1000);
          },
          error: function() {
            toastr.error('{{ __('back.error_occurred') }}');
          }
        });
      });

      // Deliver card
      $('.deliver-btn').click(function() {
        const id = $(this).data('id');
        if (confirm('{{ __('back.are_you_sure_deliver') }}')) {
          $.ajax({
            url: `/{{ app()->getLocale() }}/loyalty-card-requests/${id}/deliver`,
            method: 'POST',
            data: {
              _token: '{{ csrf_token() }}'
            },
            success: function(response) {
              toastr.success(response.message);
              setTimeout(() => location.reload(), 1000);
            },
            error: function() {
              toastr.error('{{ __('back.error_occurred') }}');
            }
          });
        }
      });

      // Delete request
      $('.delete-btn').click(function() {
        const id = $(this).data('id');
        if (confirm('{{ __('back.are_you_sure_delete') }}')) {
          $.ajax({
            url: `/{{ app()->getLocale() }}/loyalty-card-requests/${id}`,
            method: 'DELETE',
            data: {
              _token: '{{ csrf_token() }}'
            },
            success: function(response) {
              toastr.success(response.message);
              setTimeout(() => location.reload(), 1000);
            },
            error: function() {
              toastr.error('{{ __('back.error_occurred') }}');
            }
          });
        }
      });
    });
  </script>
@endsection
