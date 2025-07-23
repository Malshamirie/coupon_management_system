@extends('backend.layouts.master')

@section('page_title')
  {{trans('back.Show_User')}}
@endsection
@section('title')
  {{trans('back.Show_User')}}
@endsection

@section('content')

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-box">

                    <div class="box-head pb-4">
                        <label>{{trans('back.name')}} : </label>
                        {{ $user->name }}
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label> {{trans('back.Email')}}:</label>
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>{{trans('back.Permissions')}} :</label>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <label class="btn btn-success btn-sm">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>


@endsection

@section('js')


@endsection
