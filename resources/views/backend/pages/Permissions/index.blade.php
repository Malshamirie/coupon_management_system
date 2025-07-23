@extends('backend.layouts.master')

@section('title_page')
{{trans('back.permissions')}}
@endsection

@section('title')
{{trans('back.permissions')}}
@endsection

@section('content')

    <div class="row">
        @can('permission_add')
            <div class="col-md-9 mb-1">
                <a class="btn btn-purple btn-sm" href="" data-toggle="modal" data-target="#add_car_expense_categories">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.permission_add')}}
                </a>
                @include('backend.pages.Permissions.add')
            </div>
        @endcan
        @can('permission_searsh')
        <div class="col-md-3 mb-1">
            <form action="{{ route('permissions.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="search..." id="query" >
                    <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                        <span class="fas fa-search"></span>
                    </button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
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
                        <table  class="table text-center  table-bordered table-sm ">
                            <thead>
                            <tr style="background-color: rgb(232,245,252)">
                                <th>{{trans('back.name_ar')}}</th>
                                <th>{{trans('back.name_en')}}</th>
                                <th>{{trans('back.Created_at')}}</th>
                                <th>{{trans('back.Action')}}</th>
                             </tr>
                            </thead>


                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ trans('back.'.$permission->name)  }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->created_at }}</td>
                                    <td>
                                        @can('permission_edit')
                                            <a class="btn btn-success btn-xs " href="" data-toggle="modal" data-target="#edit_car_expense_categories{{$permission->id}}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @include('backend.pages.Permissions.edit')
                                        @endcan

                                        @can('permission_delete')
                                            <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#permissions{{$permission->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            @include('backend.pages.Permissions.delete')
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $permissions->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
