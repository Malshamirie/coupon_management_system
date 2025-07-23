@extends('backend.layouts.master')

@section('page_title')
{{ __('back.customers') }}
@endsection
@section('title')
{{ __('back.customers') }}
@endsection
@section('content')
    <div class="row mb-2" id="table-bordered">
        @can('add_customer')
            <div class="col-md-6">
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_customer">
                    <i class="fas fa-plus"></i>
                    {{ __('back.add_customer') }}
                </button>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#import_customers">
                    <i class="fas fa-upload"></i>
                    {{ __('back.import_customers') }}
                </button>
                <a href="{{ route('admin.customers.export') }}" class="btn btn-success">
                    <i class="fas fa-download"></i>
                    {{ __('back.export_customers') }}
                </a>
                @include('backend.pages.customers.add')
                @include('backend.pages.customers.import')
            </div>
        @endcan

        @can('customers')
            <div class="col-md-6 mb-1 ">
                <form action="{{ route('admin.customers.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control " name="query" value="{{ old('query', request()->input('query')) }}" placeholder="{{ trans('back.search') }}">
                        <button class="btn btn-purple ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-success ml-1" title="Reload">
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
                                <th>{{ __('back.name') }}</th>
                                <th>{{ __('back.phone') }}</th>
                                <th>{{ __('back.email') }}</th>
                                <th>{{ __('back.address') }}</th>
                                <th>{{ __('back.container') }}</th>
                                <th>{{ __('back.Created_at') }}</th>
                                <th>{{ __('back.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->email ?? '-' }}</td>
                                    <td>{{ $customer->address ?? '-' }}</td>
                                    <td>{{ $customer->container->name ?? '' }}</td>
                                    <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @can('edit_customer')
                                        <a href="" class="btn btn-success btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#edit_customer{{$customer->id}}">
                                            {{trans('back.edit')}}
                                        </a>
                                        @endcan

                                        @can('delete_customer')
                                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#delete_customer{{$customer->id}}">
                                            {{trans('back.Delete')}}
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.pages.customers.edit')
                                @include('backend.pages.customers.delete')
                            @endforeach
                            </tbody>
                        </table>
                        {!! $customers->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
