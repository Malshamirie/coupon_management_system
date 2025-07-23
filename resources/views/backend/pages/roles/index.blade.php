@extends('backend.layouts.master')

@section('page_title')
{{trans('back.Roles')}}
@endsection
@section('title')
{{trans('back.Roles')}}
@endsection

@section('content')

    <div class="row">
        @can('add_role')
            <div class="col-md-9 mb-1">
                <a href=" {{ route('roles.create') }}" class="btn btn-purple btn-sm  ">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.Add_New_Role')}}
                </a>
            </div>
        @endcan
        @can('search_role')
        <div class="col-md-3 ">
            <form action="{{ route('roles.index') }}" method="GET" role="search">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="query" placeholder="Search.."
                           id="query" value="{{old('keyword', request()->input('query'))}}">
                    <div class="input-group-prepend">
                        <button class="btn btn-purple btn-sm " type="submit" title="Search..">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-success btn-sm"
                           title="{{trans('front.Reload the page')}}">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        @endcan
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table xs class="table table-bordered  table-sm text-center  ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> {{trans('back.name')}} </th>
                                <th> {{trans('back.actions')}} </th>
                                <th>{{trans('back.Created_at')}} </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    @include('backend.pages.roles.delete')
                                    <td>
                                        @if($role->id == 1)
                                        @can('add_role')
                                            <a class="btn btn-purple btn-xs" href="{{ route('roles.show',$role->id) }}">{{trans('back.Show')}}  </a>
                                        @endcan
                                        @can('edit_role')
                                                <a class="btn btn-secondary btn-xs" href="{{ route('roles.edit',$role->id) }}"> {{trans('back.edit')}} </a>
                                            @endcan

                                        @else
                                            @can('add_role')
                                                <a class="btn btn-purple btn-xs" href="{{ route('roles.show',$role->id) }}">{{trans('back.Show')}}  </a>
                                            @endcan

                                            @can('edit_role')
                                                <a class="btn btn-secondary btn-xs" href="{{ route('roles.edit',$role->id) }}"> {{trans('back.edit')}} </a>
                                            @endcan

                                            @can('delete_role')
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_role{{ $role->id }}"> {{trans('back.delete')}}  </button>
                                            @endcan
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')


@endsection
