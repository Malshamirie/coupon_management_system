@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.customers') }} - {{ $loyaltyCampaign->campaign_name }}
@endsection

@section('title')
  {{ __('back.customers') }} - {{ $loyaltyCampaign->campaign_name }}
@endsection

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('back.dashboard') }}</a></li>
      <li class="breadcrumb-item"><a
          href="{{ route('admin.loyalty_campaigns.index') }}">{{ __('back.loyalty_campaigns') }}</a></li>
      <li class="breadcrumb-item active">{{ __('back.customers') }} - {{ $loyaltyCampaign->campaign_name }}</li>
    </ol>
  </nav>

  <div class="row mb-2">
    <div class="col-md-9">
      <h4>{{ __('back.campaign_customers') }}: {{ $loyaltyCampaign->campaign_name }}</h4>
      <p class="text-muted">{{ __('back.total_customers') }}: {{ $customers->total() }}</p>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.loyalty_campaigns.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> {{ __('back.back') }}
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="table-light">
                <tr class="text-center">
                  <th>#</th>
                  <th>{{ trans('back.customer_name') }}</th>
                  <th>{{ trans('back.phone_number') }}</th>
                  <th>{{ trans('back.email') }}</th>
                  <th>{{ trans('back.address') }}</th>
                  <th>{{ trans('back.container') }}</th>
                  <th>{{ trans('back.created_at') }}</th>
                  <th>{{ trans('back.actions') }}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($customers as $key => $customer)
                  <tr class="text-center">
                    <td>{{ $key + $customers->firstItem() }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email ?? '--' }}</td>
                    <td>{{ $customer->address ?? '--' }}</td>
                    <td>{{ $customer->loyaltyContainer->name ?? '--' }}</td>
                    <td>{{ $customer->created_at }}</td>
                    <td>
                      @can('edit_customer')
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-success btn-xs ml-1">
                          <i class="fas fa-edit"></i>
                        </a>
                      @endcan

                      @can('delete_customer')
                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#delete_customer{{ $customer->id }}">
                          <i class="fas fa-trash-alt"></i>
                        </a>
                      @endcan

                      @can('show_customer')
                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-dark btn-xs ml-1">
                          <i class="fas fa-eye"></i>
                        </a>
                      @endcan
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center">{{ __('back.no_customers_found') }}</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
            {!! $customers->appends(Request::all())->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modals -->
  @foreach ($customers as $customer)
    @include('backend.pages.customers.delete')
  @endforeach
@endsection
