@extends('backend.layouts.master')

@section('page_title')
{{ __('back.campaigns') }}
@endsection
@section('title')
{{ __('back.campaigns') }}
@endsection
@section('content')
    <div class="row mb-2" id="table-bordered">
        @can('add_campaign')
            <div class="col-md-9">
                <a class="btn btn-secondary" href="{{ route('admin.campaigns.create') }}">
                    <i class="fas fa-plus"></i>
                    {{ __('back.add_campaign') }}
                </a>
            </div>
        @endcan

        @can('campaigns')
            <div class="col-md-3 mb-1 ">
                <form action="{{ route('admin.campaigns.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control " name="query" value="{{ old('query', request()->input('query')) }}" placeholder="{{ trans('back.search') }}">
                        <button class="btn btn-purple ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-success ml-1" title="Reload">
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
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>{{ trans('back.logo') }}</th>
                                    <th>{{ trans('back.campaign_name') }}</th>
                                    <th>{{ trans('back.manager_name') }}</th>
                                    <th>{{ trans('back.start_date') }}</th>
                                    <th>{{ trans('back.end_date') }}</th>
                                    <th>{{ trans('back.container') }}</th>
                                    <th>{{ trans('back.beneficiary') }}</th>
                                    <th>{{ trans('back.search_method') }}</th>
                                    <th> مستخدمي الكوبونات </th>
                                    <th>{{ trans('back.created_at') }}</th>
                                    <th>{{ trans('back.actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($campaigns as $key => $campaign)
                                <tr class="text-center">
                                    <td>{{$key + $campaigns->firstItem()}}</td>
                                    <td><a href="{{ asset($campaign->logo) }}" target="_blank" rel="noopener noreferrer"> <img src="{{ asset($campaign->logo) }}" class="avatar-sm rounded"> </a> </td>
                                    <td>{{ $campaign->name }}</td>
                                    <td>{{ $campaign->manager_name }}</td>
                                    <td>{{ $campaign->start_date }}</td>
                                    <td>{{ $campaign->end_date }}</td>
                                    <td>{{ $campaign->container->name??'--' }}</td>
                                    <td>{{ $campaign->beneficiary }}</td>
                                    <td>{{ $campaign->search_method }}</td>
                                    <td>
                                        <a href="{{ route('usercodes', ['campaign_id' => $campaign->id]) }}">
                                            {{ $campaign->UserCodes->count() }}
                                        </a>
                                    </td>
                                    <td>{{ $campaign->created_at }}</td>
                                    <td>
                                        @can('edit_campaign')
                                        <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="btn btn-success btn-xs ml-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('delete_campaign')
                                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#delete_campaign{{ $campaign->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @endcan

                                        {{-- زر عرض التفاصيل --}}
                                        <a href="{{ route('admin.campaigns.show', $campaign->id) }}" class="btn btn-dark btn-xs ml-1">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- زر عرض التفاصيل --}}
                                        <a href="{{ route('campaign.form', $campaign->slug) }}" target="_blank" class="btn btn-info btn-xs ml-1">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                                @include('backend.pages.campaigns.delete')
                            @endforeach
                        </tbody>

                        </table>
                        {!! $campaigns->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->
@endsection
