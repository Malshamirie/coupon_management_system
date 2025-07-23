@extends('backend.layouts.master')

@section('page_title')
{{ __('back.Upload coupon file (Excel or TXT)') }}
@endsection
@section('title')
{{ __('back.Upload coupon file (Excel or TXT)') }}
@endsection

@section('content')
    <div class="row">
        <div class="cart">
            <div class="cart-body">
                <form enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="row  mb-4">
                        <div class="col-md-4">
                            <label class="form-label" for="container_id">{{trans('back.select_container')}}</label>
                            <select name="container_id" class="form-select">
                                @foreach (App\Models\Container::all() as $category)
                                    <option value="{{ $category->id }}" {{ old('container_id') == $category->id ? 'selected' : null }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="file" class="form-label">{{ __('back.Upload coupon file (Excel or TXT)') }}</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary" >{{trans('back.back')}}</a>
                        <button type="submit" class="btn btn-success"> {{ __('back.save') }} </button>
                    </div>
                </form>
                <div id="uploadResult"></div>
            </div>
        </div>
    </div>
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
