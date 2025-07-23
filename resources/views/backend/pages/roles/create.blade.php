@extends('backend.layouts.master')

@section('page_title')
{{trans('back.Add_New_Role')}}
@endsection
@section('title')
{{trans('back.Add_New_Role')}}
@endsection

@section('content')


    <div class="col-sm-4">
        <a class="btn btn-purple btn-sm mb-1" href="{{ route('roles.index') }}">
            <i class="fas fa-chevron-circle-right"></i>
            {{trans('back.Back')}}
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">

                {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{trans('back.name')}}:</label>
                            <input type="text" name="name" class="form-control" placeholder="{{trans('back.name')}}" value="{{old('name')}}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>{{trans('back.Search')}}:</label>
                        <input type="search" id="search_roles" class="form-control"  placeholder="{{trans('back.Search')}}">
                    </div>
                    <div class="col-md-3" style="margin-top: 21px">
                        <button type="submit" class="btn btn-purple"> {{trans('back.Add')}}</button>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">

                            <div class="mb-2">
                                <input type="checkbox" name="checkAll" id="checkAll">
                                <label for="checkAll">{{trans('back.All')}} : </label>
                            </div>

                            <div class="row">
                                @foreach($permission as $value)
                                    <div class="col-md-3" id="service">
                                        <label>
                                            {{ Form::checkbox('permission[]', $value->id,  false,  array('class' => 'name', 'id' => 'checkItem')) }}
                                            {{ trans('back.'.$value->name)  }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

    <script>
        // البحث في الجدول
        $("#search_roles").on("keyup", function() {
            let value = $(this).val().toLowerCase();
            $("#service label").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    </script>

@endsection
