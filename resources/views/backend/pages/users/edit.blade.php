@extends('backend.layouts.master')

@section('page_title')
   {{trans('back.Edit_User')}}
@endsection
@section('title')
   {{trans('back.Edit_User')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 mb-2">
            @can('create_user')
                <a href=" {{ route('users.create') }}" class="btn btn-purple btn-sm ">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.Add_New_User')}}
                </a>
            @endcan
            @can('users')
                <a href=" {{ route('users.index') }}" class="btn btn-success btn-sm ">
                    <i class="mdi mdi-plus"></i>
                    {{trans('back.Back_All_users')}}
                </a>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-box">

                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{trans('back.name')}} :</label>
                                <input type="text" class="form-control" name="name" value="{{$user->name}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{trans('back.Email')}} :</label>
                                <input type="email" class="form-control" name="email" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{trans('back.Password')}} </label>
                                <input type="password" class="form-control" name="password" value="{{$user->password}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{trans('back.confirm-password')}} :</label>
                                <input type="password" class="form-control" name="confirm-password" value="{{$user->password}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>{{trans('back.Permissions')}}:</label>
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary"> {{trans('back.edit')}}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')


@endsection
