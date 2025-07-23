@extends('backend.layouts.master')

@section('page_title', __('back.campaign_details'))

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> الرئيسية </a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.campaigns.index') }}"> الحملات </a></li>
        <li class="breadcrumb-item active"> {{ __('back.campaign_details') }} {{ $campaign->name }} </li>
    </ol>
</nav>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <tbody>
                 <tr>
                    <th>{{ __('back.name') }}</th>
                    <td>{{ $campaign->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.slug') }}</th>
                    <td><a href="{{ route('campaign.form', $campaign->slug) }}" target="_blank" rel="noopener noreferrer">{{ $campaign->slug }}</a> </td>
                </tr>
                <tr>
                    <th>{{ __('back.start_date') }}</th>
                    <td>{{ $campaign->start_date }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.end_date') }}</th>
                    <td>{{ $campaign->end_date }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.manager_name') }}</th>
                    <td>{{ $campaign->manager_name }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.beneficiary') }}</th>
                    <td>{{ $campaign->beneficiary ?? '-' }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.beneficiary_manager') }}</th>
                    <td>{{ $campaign->beneficiary_manager ?? '-' }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.beneficiary_contact') }}</th>
                    <td>{{ $campaign->beneficiary_contact ?? '-' }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.additional_terms') }}</th>
                    <td>{!! nl2br(e($campaign->terms ?? '-')) !!}</td>
                </tr>
                <tr>
                    <th>{{ __('back.coupon_type') }}</th>
                    <td>{{ ucfirst($campaign->coupon_type) }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.search_method') }}</th>
                    <td>{{ ucfirst($campaign->search_method) }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.otp_required') }}</th>
                    <td>{{ $campaign->otp_required ? __('back.yes') : __('back.no') }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.email_domain') }}</th>
                    <td>{{ $campaign->email_domain ?? '-' }}</td>
                </tr>
                <tr>
                    <th>{{ __('back.logo') }}</th>
                    <td>
                        @if($campaign->logo)
                            <img src="{{ asset($campaign->logo) }}" class="avatar-sm rounded">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ __('back.main_text') }}</th>
                    <td>{!! nl2br(e($campaign->main_text ?? '-')) !!}</td>
                </tr>
                <tr>
                    <th>{{ __('back.sub_text') }}</th>
                    <td>{!! nl2br(e($campaign->sub_text ?? '-')) !!}</td>
                </tr>
                <tr>
                    <th>{{ __('back.footer_text') }}</th>
                    <td>{!! nl2br(e($campaign->footer_text ?? '-')) !!}</td>
                </tr>
                <tr>
                    <th>{{ __('back.redirect_url') }}</th>
                    <td>
                        @if($campaign->redirect)
                            <a href="{{ $campaign->redirect }}" target="_blank">{{ $campaign->redirect }}</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
