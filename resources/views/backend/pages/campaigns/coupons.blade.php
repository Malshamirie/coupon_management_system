@extends('backend.layouts.master')

@section('page_title')
{{ __('back.coupons') }}  ( {{ $container->name }} )
@endsection
@section('title')
{{ __('back.coupons') }} ( {{ $container->name }} )
@endsection

@section('content')

    <div class="row" id="table-bordered">

        @can('add_coupon')
            <div class="col-md-6">

                @include('backend.pages.coupons.add')
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-plus"></i>
                        {{ __('back.add_coupon') }}
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#add_coupon">{{ __('back.add_coupon') }}</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.coupons.create') }}">  رفع ملف   </a></li>
                    </ul>
                  </div>
            </div>

        @endcan

        @can('coupons')
            <div class="col-md-6 mb-1 ">
                <form action="{{ route('admin.container.coupons',$container->id) }}" method="GET" role="search">
                    <div class="input-group">
                        <select name="status" class="form-select">
                            <option value="">{{ trans('back.fillter_status') }}</option>
                            <option value="1" {{ request()->input('status') === '1' ? 'selected' : '' }}>
                                {{ trans('back.active') }}
                            </option>
                            <option value="0" {{ request()->input('status') === '0' ? 'selected' : '' }}>
                                {{ trans('back.inactive') }}
                            </option>
                        </select>
                        &numsp;
                        <input type="text" class="form-control form-control-sm" name="query" value="{{ old('query', request()->input('query')) }}" placeholder="{{ trans('back.search_coupon') }}">
                        <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('admin.container.coupons',$container->id) }}" class="btn btn-success btn-sm ml-1" title="Reload">
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
                        <table id="" class="table table-bordered table-sm">
                            <thead>
                            <tr class="text-center">
                                <th>  # </th>
                                <th>  {{trans('back.Coupon coupon')}}  </th>
                                <th>  {{trans('back.value_type')}}  </th>
                                <th> {{trans('back.status')}}   </th>
                                <th>{{trans('back.Created_at')}}</th>
                                <th>{{trans('back.actions')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($coupons as $key=> $coupon)
                                <tr class="text-center">
                                    <td>{{$key+ $coupons->firstItem()}}</td>
                                    <td> {{$coupon->code}}</td>
                                    <td> {{__('back.'.$coupon->value_type)}}</td>
                                    <td> {!! $coupon->status() !!} </td>
                                    <td>{{$coupon->created_at}}</td>
                                    <td>
                                        @can('edit_coupon')
                                        <a href="" class="btn btn-success btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#edit_coupons{{$coupon->id}}">
                                            {{trans('back.edit')}}
                                        </a>
                                        @endcan

                                        @can('delete_coupon')
                                        <a href="" class="btn btn-danger btn-xs ml-1" data-bs-toggle="modal" data-bs-target="#delete_coupons{{$coupon->id}}">
                                            {{trans('back.Delete')}}
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.pages.coupons.edit')
                                @include('backend.pages.coupons.delete')
                            @endforeach
                            </tbody>
                        </table>
                        {!! $coupons->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

@endsection


@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#uploadForm').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('coupons.import') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    Swal.fire({
                        title: 'جارٍ المعالجة...',
                        html: '<div class="spinner-border text-primary"></div>',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تمت العملية!',
                        text: response.message
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'حدث خطأ!',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'حدث خطأ غير متوقع'
                    });
                }
            });
        });
    });
</script>
@endsection
