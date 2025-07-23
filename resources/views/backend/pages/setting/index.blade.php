@extends('backend.layouts.master')

@section('title_page')
    {{trans('back.setting')}}
@endsection

@section('title')
    {{trans('back.setting')}}
@endsection

@section('content')

    @can('setting')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <form action=" {{ route('setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label for="exampleFormControlFile1">{{trans('back.logo')}} </label>
                                <input type="file" class="form-control-file" name="logo" id="logo">
                                <img src="{{ asset($setting->logo) }}"  alt="image" width="100px">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="company_name"> {{trans('back.company_name')}}   </label>
                                <input type="text" class="form-control"  name="company_name" value="{{ $setting->company_name }}">
                            </div>

                            <div class="form-group col-md-12 text-center mt-5">
                                <button type="submit" class="btn btn-success"> {{trans('back.save')}}  </button>
                            </div>

                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

@endsection


