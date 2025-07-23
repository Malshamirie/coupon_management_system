@extends('backend.layouts.master')

@section('page_title')
   {{trans('back.Show_Role')}}
@endsection

@section('title')
   {{trans('back.Show_Role')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 mb-1">
            <a href=" {{ route('roles.index') }}" class="btn btn-primary btn-sm ">
                <i class="mdi mdi-plus"></i> {{trans('back.Back_All_Roles')}}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="box-head pb-4">
                        <strong>{{trans('back.name')}} : </strong>
                        {{ $role->name }}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{trans('back.Permissions')}}:</strong>
                            <br>
                            <br>
                            @if(!empty($rolePermissions))
                                <div class="row">
                                    @foreach($rolePermissions as $v)
                                        <div class="col-md-2">
                                            <h6> {{ trans('back.'.$v->name)  }}</h6>
                                        </div>
                                    @endforeach
                                </div>

                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')


@endsection
