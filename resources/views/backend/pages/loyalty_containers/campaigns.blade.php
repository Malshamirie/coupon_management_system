@extends('backend.layouts.master')

@section('page_title')
    {{ __('back.loyalty_container_campaigns') }} - {{ $container->name }}
@endsection

@section('title')
    {{ __('back.loyalty_container_campaigns') }} - {{ $container->name }}
@endsection

@section('content')
    <div class="row mb-2">
        <div class="col-md-6">
            <a href="{{ route('admin.loyalty_containers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                {{ __('back.back_to_containers') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('back.campaigns_in_container') }}: {{ $container->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>{{ __('back.campaign_name') }}</th>
                                    <th>{{ __('back.loyalty_card') }}</th>
                                    <th>{{ __('back.start_date') }}</th>
                                    <th>{{ __('back.end_date') }}</th>
                                    <th>{{ __('back.status') }}</th>
                                    <th>{{ __('back.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $campaign->campaign_name }}</td>
                                        <td>{{ $campaign->loyaltyCard->name ?? '--' }}</td>
                                        <td>{{ $campaign->start_date }}</td>
                                        <td>{{ $campaign->end_date }}</td>
                                        <td>
                                            <span class="badge bg-{{ $campaign->is_active ? 'success' : 'danger' }}">
                                                {{ $campaign->is_active ? trans('back.active') : trans('back.inactive') }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.loyalty_campaigns.show', $campaign->id) }}" 
                                               class="btn btn-info btn-xs">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.loyalty_campaigns.edit', $campaign->id) }}" 
                                               class="btn btn-success btn-xs">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('back.no_campaigns_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $campaigns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
