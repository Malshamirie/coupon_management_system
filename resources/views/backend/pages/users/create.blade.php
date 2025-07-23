@extends('backend.layouts.master')

@section('page_title')
   {{trans('back.Add_New_User')}}
@endsection

@section('title')
   {{trans('back.Add_New_User')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 mb-1">
            @can('users')
                <a class="btn btn-purple btn-sm mb-1" href="{{ route('users.index') }}">
                    <i class="fas fa-chevron-circle-right"></i>
                    {{trans('back.Back_All_users')}}
                </a>
            @endcan
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{trans('back.name')}} :</label>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('back.Email')}}:</label>
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label>{{trans('back.Password')}}</label>
                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label>{{trans('back.confirm-password')}}:</label>
                                {!! Form::password('confirm-password', array('placeholder' => 'onfirm-password','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> {{trans('back.Permissions')}}:</label>
                                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-purple"> {{trans('back.add')}} </button>
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
