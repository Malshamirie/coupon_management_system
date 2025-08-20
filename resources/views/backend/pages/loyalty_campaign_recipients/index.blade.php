@extends('backend.layouts.master')

@section('page_title', 'مستقبلي حملات الولاء')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">مستقبلي حملات الولاء</h4>
          </div>
          <div class="card-body">
            <!-- فلاتر البحث -->
            <form action="{{ route('admin.loyalty_campaign_recipients.index') }}" method="GET" role="search">
            <div class="row mb-3">
              <div class="col-md-3">
                <select class="form-control" name="campaign_id" id="campaign_filter">
                  <option value="">جميع الحملات</option>
                  @foreach ($campaigns as $campaign)
                    <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>{{ $campaign->campaign_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select class="form-control" name="status" id="status_filter">
                  <option value="">جميع الحالات</option>
                  <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>تم الإرسال</option>
                  <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                  <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>فشل الإرسال</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="phone" id="phone_filter" placeholder="رقم الهاتف" value="{{ request('phone') }}">
              </div>
              <div class="col-md-2">
                <button class="btn btn-primary">
                  <i class="fas fa-search"></i>
                </button>
              </div>
              {{-- <div class="col-md-2">
                <button class="btn btn-warning" onclick="retryFailed()">إعادة المحاولة للفاشل</button>
              </div> --}}
            </div>
            </form>

            <!-- إحصائيات سريعة -->
            {{-- <div class="row mb-3">
              <div class="col-md-3">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <h5>إجمالي المرسل لهم</h5>
                    <h3 id="total_sent">0</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card bg-success text-white">
                  <div class="card-body">
                    <h5>تم التسليم</h5>
                    <h3 id="delivered">0</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card bg-danger text-white">
                  <div class="card-body">
                    <h5>فشل الإرسال</h5>
                    <h3 id="failed">0</h3>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="card bg-info text-white">
                  <div class="card-body">
                    <h5>معدل التسليم</h5>
                    <h3 id="delivery_rate">0%</h3>
                  </div>
                </div>
              </div>
            </div> --}}

            <!-- جدول البيانات -->
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    {{-- <th><input type="checkbox" id="select_all"></th> --}}
                    <th>الحملة</th>
                    <th>العميل</th>
                    <th>رقم الهاتف</th>
                    <th>الحالة</th>
                    <th>تاريخ الإرسال</th>
                    <th>عدد المحاولات</th>
                    <th>الإجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($recipients as $key => $recipient)
                    <tr>
                      <td>{{ $key + $recipients->firstItem() }}</td>
                      {{-- <td>
                        @if ($recipient->status === 'failed')
                          <input type="checkbox" class="recipient-checkbox" value="{{ $recipient->id }}">
                        @endif
                      </td> --}}
                      <td>{{ $recipient->loyaltyCampaign->campaign_name }}</td>
                      <td>{{ $recipient->customer->name ?? 'غير محدد' }}</td>
                      <td>{{ $recipient->phone_number }}</td>
                      <td>
                        @if ($recipient->status === 'delivered')
                          <span class="badge bg-success">تم التسليم</span>
                        @elseif($recipient->status === 'failed')
                          <span class="badge bg-danger">فشل الإرسال</span>
                        @else
                          <span class="badge bg-warning">تم الإرسال</span>
                        @endif
                      </td>
                      <td>{{ $recipient->sent_at->format('Y-m-d H:i') }}</td>
                      <td>{{ $recipient->retry_count }}</td>
                      <td>
                        @if ($recipient->status === 'failed')
                          <button class="btn btn-sm btn-warning" onclick="retrySingle({{ $recipient->id }})">إعادة
                            المحاولة</button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- ترقيم الصفحات -->
            <div class="d-flex justify-content-center">
              {{ $recipients->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    function applyFilters() {
      let campaign = $('#campaign_filter').val();
      let status = $('#status_filter').val();
      let phone = $('#phone_filter').val();
      let url = new URL(window.location.href);
      if (campaign) url.searchParams.set('campaign_id', campaign);
      else url.searchParams.delete('campaign_id');
      if (status) url.searchParams.set('status', status);
      else url.searchParams.delete('status');
      if (phone) url.searchParams.set('phone', phone);
      else url.searchParams.delete('phone');
      window.location.href = url.toString();
    }

    function retryFailed() {
      let ids = [];
      $('.recipient-checkbox:checked').each(function() {
        ids.push($(this).val());
      });
      if (ids.length === 0) {
        alert('يرجى تحديد مستلمين لإعادة المحاولة');
        return;
      }
      $.post("{{ route('admin.loyalty_campaign_recipients.retry') }}", {
        recipient_ids: ids,
        _token: '{{ csrf_token() }}'
      }, function(data) {
        alert(data.message);
        location.reload();
      }).fail(function(xhr) {
        alert(xhr.responseJSON.error || 'حدث خطأ');
      });
    }

    function retrySingle(id) {
      $.post("{{ route('admin.loyalty_campaign_recipients.retry') }}", {
        recipient_ids: [id],
        _token: '{{ csrf_token() }}'
      }, function(data) {
        alert(data.message);
        location.reload();
      }).fail(function(xhr) {
        alert(xhr.responseJSON.error || 'حدث خطأ');
      });
    }

    function loadStats() {
      $.get("{{ route('admin.loyalty_campaign_recipients.statistics') }}", function(data) {
        $('#total_sent').text(data.total_sent);
        $('#delivered').text(data.delivered);
        $('#failed').text(data.failed);
        $('#delivery_rate').text(data.delivery_rate + '%');
      });
    }

    $(document).ready(function() {
      loadStats();
      $('#select_all').on('change', function() {
        $('.recipient-checkbox').prop('checked', $(this).prop('checked'));
      });
    });
  </script>
@endsection
