<!-- Modal -->
<div class="modal fade" id="add_coupon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ms">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">
                    {{ __('back.add_coupon') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.coupons.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row  mb-4">
                        <div class="mb-12 col-md-6">
                            <label class="form-label">  {{ __('back.coupon') }} </label>
                            <input type="text" class="form-control" placeholder="{{ __('back.coupon') }}" name="code" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="container_id">{{trans('back.select_container')}}</label>
                            <select name="container_id" class="form-select">
                                @foreach (App\Models\Container::all() as $container)
                                    <option value="{{ $container->id }}" {{ old('container_id') == $container->id ? 'selected' : null }}>{{$container->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="status">{{trans('back.status')}}</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ old('active') == 1 ? 'selected' : null }}>{{trans('back.active')}}</option>
                                <option value="0" {{ old('inactive') == 0 ? 'selected' : null }}>{{trans('back.inactive')}}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="value_type" class="form-label">{{ trans('back.value_type') }}</label>
                            <select class="form-select" id="value_type" name="value_type">
                                <option value="fixed">{{ trans('back.fixed') }}</option>
                                <option value="percentage">{{ trans('back.percentage') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('back.close')}}</button>
                        <button type="submit" class="btn btn-success"> {{ __('back.save') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
