@extends('backend.layouts.master')

@section('page_title')
{{ __('back.containers') }}
@endsection
@section('title')
{{ __('back.containers') }}
@endsection
@section('content')
    <div class="row mb-2" id="table-bordered">
        @can('add_container')
            <div class="col-md-9">
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_container">
                    <i class="fas fa-plus"></i>
                    {{ __('back.add_container') }}
                </button>
                @include('backend.pages.containers.add')
            </div>
        @endcan

        @can('containers')
            <div class="col-md-3 mb-1 ">
                <form action="{{ route('admin.containers.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control " name="query" value="{{ old('query', request()->input('query')) }}" placeholder="{{ trans('back.search') }}">
                        <button class="btn btn-purple ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('admin.containers.index') }}" class="btn btn-success ml-1" title="Reload">
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
                                <th>  # </th>
                                <th>  {{trans('back.name')}}  </th>
                                <th>  {{trans('back.coupon_count')}}  </th>
                                <th>{{trans('back.Created_at')}}</th>
                                <th>{{trans('back.actions')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($containers as $container)
                                <tr class="text-center">
                                    <td> {{$loop->iteration}}</td>
                                    <td> {{$container->name}}</td>
                                    <td><a href="{{ route('admin.container.coupons',$container->id) }}" target="_blank" rel="noopener noreferrer"> {{ $container->coupons->count()??0 }} </a></td>
                                    <td>{{$container->created_at}}</td>
                                    <td>
                                        @can('edit_container')
                                        <a href="" class="btn btn-success btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#edit_container{{$container->id}}">
                                            {{trans('back.edit')}}
                                        </a>
                                        @endcan

                                        @can('delete_container')
                                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#delete_container{{$container->id}}">
                                            {{trans('back.Delete')}}
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.pages.containers.edit')
                                @include('backend.pages.containers.delete')
                            @endforeach
                            </tbody>
                        </table>
                        {!! $containers->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->
@endsection
