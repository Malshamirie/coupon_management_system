@extends('backend.layouts.master')

@section('page_title', __('back.show_loyalty_campaign'))

@section('content')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('back.dashboard') }}</a></li>
      <li class="breadcrumb-item"><a
          href="{{ route('admin.loyalty_campaigns.index') }}">{{ __('back.loyalty_campaigns') }}</a></li>
      <li class="breadcrumb-item active">{{ __('back.show_loyalty_campaign') }} {{ $loyaltyCampaign->campaign_name }}</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <tbody>
                <tr>
                  <th width="200">{{ __('back.campaign_name') }}</th>
                  <td>{{ $loyaltyCampaign->campaign_name }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.card_name') }}</th>
                  <td>{{ $loyaltyCampaign->card_name }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.card_type') }}</th>
                  <td>{{ $loyaltyCampaign->loyaltyCard->name ?? '--' }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.container') }}</th>
                  <td>{{ $loyaltyCampaign->container->name ?? '--' }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.start_date') }}</th>
                  <td>{{ $loyaltyCampaign->start_date->format('Y-m-d') }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.end_date') }}</th>
                  <td>{{ $loyaltyCampaign->end_date->format('Y-m-d') }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.manager_name') }}</th>
                  <td>{{ $loyaltyCampaign->manager_name }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.sending_method') }}</th>
                  <td>{{ $loyaltyCampaign->sending_method_text }}</td>
                </tr>
                @if ($loyaltyCampaign->sending_method === 'whatsapp')
                  <tr>
                    <th>{{ __('back.whatsapp_template_id') }}</th>
                    <td>{{ $loyaltyCampaign->whatsapp_template_id ?? '--' }}</td>
                  </tr>
                  <tr>
                    <th>{{ __('back.whatsapp_image_url') }}</th>
                    <td>
                      @if ($loyaltyCampaign->whatsapp_image_url)
                        <a href="{{ $loyaltyCampaign->whatsapp_image_url }}"
                          target="_blank">{{ $loyaltyCampaign->whatsapp_image_url }}</a>
                      @else
                        --
                      @endif
                    </td>
                  </tr>
                @endif
                @if ($loyaltyCampaign->sending_method === 'email')
                  <tr>
                    <th>{{ __('back.email_template') }}</th>
                    <td>{!! nl2br(e($loyaltyCampaign->email_template ?? '--')) !!}</td>
                  </tr>
                @endif
                <tr>
                  <th>{{ __('back.additional_terms') }}</th>
                  <td>{!! nl2br(e($loyaltyCampaign->additional_terms ?? '--')) !!}</td>
                </tr>
                <tr>
                  <th>{{ __('back.page_logo') }}</th>
                  <td>
                    @if ($loyaltyCampaign->page_logo)
                      <img src="{{ $loyaltyCampaign->page_logo_url }}" alt="Page Logo" class="img-thumbnail"
                        style="max-width: 200px;">
                    @else
                      --
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>{{ __('back.main_text') }}</th>
                  <td>{!! nl2br(e($loyaltyCampaign->main_text ?? '--')) !!}</td>
                </tr>
                <tr>
                  <th>{{ __('back.sub_text') }}</th>
                  <td>{!! nl2br(e($loyaltyCampaign->sub_text ?? '--')) !!}</td>
                </tr>
                <tr>
                  <th>{{ __('back.after_form_text') }}</th>
                  <td>{!! nl2br(e($loyaltyCampaign->after_form_text ?? '--')) !!}</td>
                </tr>
                <tr>
                  <th>{{ __('back.redirect_url') }}</th>
                  <td>
                    @if ($loyaltyCampaign->redirect_url)
                      <a href="{{ $loyaltyCampaign->redirect_url }}"
                        target="_blank">{{ $loyaltyCampaign->redirect_url }}</a>
                    @else
                      --
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>{{ __('back.total_customers') }}</th>
                  <td>
                    <a href="{{ route('admin.loyalty_campaigns.customers', $loyaltyCampaign->id) }}"
                      class="btn btn-info btn-sm">
                      {{ $loyaltyCampaign->total_customers }}
                    </a>
                  </td>
                </tr>
                <tr>
                  <th>{{ __('back.status') }}</th>
                  <td>
                    <span class="badge bg-{{ $loyaltyCampaign->is_active ? 'success' : 'danger' }}">
                      {{ $loyaltyCampaign->status_text }}
                    </span>
                  </td>
                </tr>
                <tr>
                  <th>{{ __('back.created_at') }}</th>
                  <td>{{ $loyaltyCampaign->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                <tr>
                  <th>{{ __('back.updated_at') }}</th>
                  <td>{{ $loyaltyCampaign->updated_at->format('Y-m-d H:i:s') }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            @can('edit_loyalty_campaign')
              <a href="{{ route('admin.loyalty_campaigns.edit', $loyaltyCampaign->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> {{ __('back.edit') }}
              </a>
            @endcan

            <a href="{{ route('loyalty.campaign.landing', $loyaltyCampaign->id) }}" target="_blank" class="btn btn-info">
              <i class="fas fa-external-link-alt"></i> {{ __('back.view_landing_page') }}
            </a>

            @can('send_loyalty_campaign')
              <a href="{{ route('admin.loyalty_campaigns.send', $loyaltyCampaign->id) }}" class="btn btn-warning">
                <i class="fas fa-paper-plane"></i> {{ __('back.send_campaign') }}
              </a>
            @endcan

            <a href="{{ route('admin.loyalty_campaigns.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> {{ __('back.back') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
