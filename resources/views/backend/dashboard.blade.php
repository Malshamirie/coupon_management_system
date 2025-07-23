@extends('backend.layouts.master')

@section('title_page')
{{trans('back.dashboard')}}
@endsection

@section('content')
    {{-- <div class="row justify-content-center p-3">
        <img src="{{asset(App\Models\Setting::first()->logo)}}" alt="" class="avatar-lg">
    </div> --}}
    <div class="row text-center">
        @foreach(App\Models\Container::all() as $container)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        {{ $container->name }}
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.container.coupons',$container->id) }}" target="_blank" rel="noopener noreferrer">{{ $container->coupons->count() }} {{ trans('back.coupon') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
