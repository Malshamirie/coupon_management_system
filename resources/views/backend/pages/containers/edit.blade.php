<!-- Modal -->
<div class="modal fade" id="edit_container{{$container->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">
                    {{ __('back.edit_container') }} / {{ $container->container }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{route('admin.containers.update', $container->id)}}" method="post" enctype="multipart/form-data" class="text-left">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label class="form-label"> {{ __('back.name') }} </label>
                            <input type="text" value="{{ $container->name}}" class="form-control" placeholder="{{ __('back.name') }}" name="name"  required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('back.close')}}</button>
                        <button type="submit" class="btn btn-success">{{trans('back.save_and_update')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
