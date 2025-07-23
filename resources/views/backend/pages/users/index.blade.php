@extends('backend.layouts.master')

@section('page_title')
{{trans('back.users')}}
@endsection

@section('title')
{{trans('back.users')}}
@endsection

@section('content')

    <div class="row">
        @can('create_user')
            <div class="col-md-12 mb-1">
                <a href=" {{ route('users.create') }}" class="btn btn-purple btn-sm ">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.Add_New_User')}}
                </a>
            </div>
        @endcan
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-box">

                    <div class="table-responsive">
                        <table xs class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('back.name')}}</th>
                                <th>{{trans('back.Email')}} </th>
                                <th>{{trans('back.Permissions')}} </th>
                                <th> {{trans('back.actions')}}</th>
                                <th>{{trans('back.Created_at')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $key => $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td> {{ $user->name }}</td>
                                    <td> {{ $user->email }}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge bg-secondary">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>

                                        @if($user->id == 1 || $user->id == 2)
                                            @can('show_user')
                                                <a class="btn btn-info btn-xs disabled" href="{{ route('users.show',$user->id) }}"> {{trans('back.Show')}} </a>
                                            @endcan

                                            @can('delete_user')
                                                <button type="button" class="btn btn-danger btn-xs " disabled data-toggle="modal" data-target="#delete_user{{ $user->id }}"> {{trans('back.delete')}} </button>
                                            @endcan

                                            @can('edit_user')
                                                <a class="btn btn-success btn-xs disabled"  href="{{ route('users.edit',$user->id) }}"> {{trans('back.edit')}}</a>
                                            @endcan
                                        @else
                                            @can('show_user')
                                                <a class="btn btn-info btn-xs" href="{{ route('users.show',$user->id) }}"> {{trans('back.Show')}} </a>
                                            @endcan

                                            @can('delete_user')
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_user{{ $user->id }}"> {{trans('back.delete')}} </button>
                                            @endcan

                                            @can('edit_user')
                                                <a class="btn btn-success btn-xs" href="{{ route('users.edit',$user->id) }}"> {{trans('back.edit')}}</a>
                                            @endcan

                                        @endif
                                        @include('backend.pages.users.delete')

                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="col-md-12">
                            {!! $data->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
