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

  <!-- إحصائيات الطلبات الزمنية -->
  <div class="row mb-1">
    <div class="col-xl-3 col-md-4 mb-2">
      <div class="card border-right-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                إجمالي الطلبات
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['requests_total'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-4 mb-2">
      <div class="card border-right-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                طلبات هذا الشهر
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['requests_this_month'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-4 mb-2">
      <div class="card border-right-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                طلبات هذا الأسبوع
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['requests_this_week'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-4 mb-2">
      <div class="card border-right-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                طلبات اليوم
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['requests_today'] }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- إحصائيات الطلبات -->
    <div class="row mb-4">
     
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-right-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                  الطلبات المعلقة
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['pending_requests'] }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
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
                  الطلبات المقبولة
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['approved_requests'] }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-right-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                  الطلبات المرفوضة
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['rejected_requests'] }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <!-- Filters -->
  <div class="row mb-2">
    <div class="col-12">
        
       
          <form id="filters-form" method="GET">
            <div class="row">
              
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
                  <select class="form-select" id="" name="status">
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
              <div class="col-md-3">
                <div class="mb-3">
                  <label for="search" class="form-label">{{ __('back.search') }}</label>
                  
                    <div class="input-group">
                      <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('back.search_loyalty_card_request') }}">
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                      </button>
                      <a href="{{ route('admin.loyalty_card_requests.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i>
                      </a>
                      {{-- <a href="{{ route('admin.loyalty_card_requests.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> {{ __('back.export') }}
                      </a> --}}
                    </div>
                </div>
              </div>
            </div>
          </form>
       
    </div>
  </div>

  <!-- Requests Table -->
  <div class="row">
    <div class="col-12">
      <div class="card">
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
                    <td>{{ $request->branch->branch_name ?? '--' }}</td>
                    <td>
                      <span class="badge bg-{{ $request->status_badge }} status-badge" 
                            style="cursor: pointer;" 
                            data-bs-toggle="modal" 
                            data-bs-target="#change-status-modal"
                            data-request-id="{{ $request->id }}"
                            data-current-status="{{ $request->status }}"
                            data-current-status-text="{{ $request->status_text }}">
                        {{ $request->status_text }}
                      </span>
                    </td>
                    <td>{{ $request->requested_at->format('Y-m-d H:i') }}</td>
                    <td>
                      <div class="btn-group" role="group">
                        
                        
                       
                        
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

  <!-- Change Status Modal -->
  <div class="modal fade" id="change-status-modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">تغيير حالة الطلب</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="change-status-form">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">الحالة الحالية</label>
              <div class="form-control-plaintext" id="current-status-display"></div>
            </div>
            <div class="mb-3">
              <label for="new_status" class="form-label">الحالة الجديدة</label>
              <select class="form-control" id="new_status" name="status" required>
                <option value="">اختر الحالة الجديدة</option>
                <option value="pending">معلق</option>
                <option value="approved">مقبول</option>
                <option value="rejected">مرفوض</option>
                <option value="processing">قيد المعالجة</option>
                <option value="completed">مكتمل</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="status_notes" class="form-label">ملاحظات (اختياري)</label>
              <textarea class="form-control" id="status_notes" name="notes" rows="3"
                placeholder="أضف ملاحظات حول تغيير الحالة..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="submit" class="btn btn-primary">تحديث الحالة</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('styles')
<style>
  .status-badge {
    transition: all 0.3s ease;
  }
  
  .status-badge:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
  }
  
  .status-badge:active {
    transform: scale(0.95);
  }
  
  .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
  }
  
  .modal-header .btn-close {
    filter: invert(1);
  }
  
  .form-control-plaintext {
    padding: 0.5rem;
    background-color: #f8f9fa;
    border-radius: 0.375rem;
  }
</style>
@endpush

@section('js')
  <script>
    $(document).ready(function() {
      // Approve request
      $('.approve-btn').click(function() {
        const id = $(this).data('id');
        if (confirm('{{ __('back.are_you_sure_approve') }}')) {
          $.ajax({
            url: `/{{ app()->getLocale() }}/admin/loyalty-card-requests/${id}/approve`,
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
          url: `/{{ app()->getLocale() }}/admin/loyalty-card-requests/${id}/reject`,
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
            url: `/{{ app()->getLocale() }}/admin/loyalty-card-requests/${id}/deliver`,
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
            url: `/{{ app()->getLocale() }}/admin/loyalty-card-requests/${id}`,
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

      // Change Status Modal
      $('.status-badge').click(function() {
        const requestId = $(this).data('request-id');
        const currentStatus = $(this).data('current-status');
        const currentStatusText = $(this).data('current-status-text');
        
        // Set current status display
        $('#current-status-display').html(`<span class="badge bg-${getStatusBadgeColor(currentStatus)}">${currentStatusText}</span>`);
        
        // Set form data
        $('#change-status-form').data('request-id', requestId);
        $('#change-status-form').data('current-status', currentStatus);
        
        // Reset form
        $('#new_status').val('');
        $('#status_notes').val('');
      });

      // Submit status change form
      $('#change-status-form').submit(function(e) {
        e.preventDefault();
        const requestId = $(this).data('request-id');
        const currentStatus = $(this).data('current-status');
        const newStatus = $('#new_status').val();
        const notes = $('#status_notes').val();

        if (!newStatus) {
          toastr.error('يرجى اختيار الحالة الجديدة');
          return;
        }

        if (newStatus === currentStatus) {
          toastr.warning('الحالة الجديدة مطابقة للحالة الحالية');
          return;
        }

        $.ajax({
          url: `/{{ app()->getLocale() }}/admin/loyalty-card-requests/${requestId}/change-status`,
          method: 'POST',
          data: {
            status: newStatus,
            notes: notes,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            toastr.success(response.message);
            $('#change-status-modal').modal('hide');
            setTimeout(() => location.reload(), 1000);
          },
          error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.message) {
              toastr.error(xhr.responseJSON.message);
            } else {
              toastr.error('{{ __('back.error_occurred') }}');
            }
          }
        });
      });

      // Helper function to get badge color
      function getStatusBadgeColor(status) {
        const colors = {
          'pending': 'warning',
          'approved': 'success',
          'rejected': 'danger',
          'processing': 'info',
          'completed': 'primary'
        };
        return colors[status] || 'secondary';
      }
    });
  </script>
@endsection
