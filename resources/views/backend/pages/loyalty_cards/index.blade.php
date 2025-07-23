@extends('backend.layouts.master')

@section('page_title')
  {{ __('back.loyalty_cards') }}
@endsection
@section('title')
  {{ __('back.loyalty_cards') }}
@endsection
@section('content')
  <div class="row mb-2" id="table-bordered">
    @can('add_loyalty_card')
      <div class="col-md-9">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_loyalty_card">
          <i class="fas fa-plus"></i>
          {{ __('back.add_loyalty_card') }}
        </button>
        @include('backend.pages.loyalty_cards.add')
      </div>
    @endcan

    @can('loyalty_cards')
      <div class="col-md-3 mb-1 ">
        <form action="{{ route('admin.loyalty_cards.index') }}" method="GET" role="search">
          <div class="input-group">
            <input type="text" class="form-control " name="query" value="{{ old('query', request()->input('query')) }}"
              placeholder="{{ trans('back.search') }}">
            <button class="btn btn-purple ml-1" type="submit" title="Search">
              <span class="fas fa-search"></span>
            </button>
            <a href="{{ route('admin.loyalty_cards.index') }}" class="btn btn-success ml-1" title="Reload">
              <span class="fas fa-sync-alt"></span>
            </a>
          </div>
        </form>
      </div>
    @endcan
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="" class="table table-bordered table-sm">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>{{ __('back.card_name') }}</th>
                  <th>{{ __('back.card_image') }}</th>
                  <th>{{ __('back.card_description') }}</th>
                  <th>{{ __('back.card_status') }}</th>
                  <th>{{ __('back.Created_at') }}</th>
                  <th>{{ __('back.actions') }}</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($loyaltyCards as $card)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $card->name }}</td>
                    <td class="text-center">
                      @if ($card->image)
                        <img src="{{ $card->image_url }}" alt="{{ $card->name }}" class="img-thumbnail"
                          style="max-width: 50px; max-height: 50px;">
                      @else
                        <span class="text-muted">{{ __('back.no_image') }}</span>
                      @endif
                    </td>
                    <td>{{ Str::limit($card->description, 50) }}</td>
                    <td>
                      <span class="badge {{ $card->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $card->status_text }}
                      </span>
                    </td>
                    <td>{{ $card->created_at->format('Y-m-d') }}</td>
                    <td>
                      @can('edit_loyalty_card')
                        <a href="" class="btn btn-success btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#edit_loyalty_card{{ $card->id }}">
                          {{ trans('back.edit') }}
                        </a>
                      @endcan

                      @can('delete_loyalty_card')
                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal"
                          data-bs-target="#delete_loyalty_card{{ $card->id }}">
                          {{ trans('back.Delete') }}
                        </a>
                      @endcan
                    </td>
                  </tr>
                  @include('backend.pages.loyalty_cards.edit')
                  @include('backend.pages.loyalty_cards.delete')
                @endforeach
              </tbody>
            </table>
            {!! $loyaltyCards->appends(Request::all())->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
