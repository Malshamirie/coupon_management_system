<!-- Modal -->
<div class="modal fade" id="add_container" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ms">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">
                    {{ __('back.add_container') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{route('admin.containers.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row  mb-4">
                        <div class="mb-12 col-md-12">
                            <label class="form-label">  {{ __('back.name') }} </label>
                            <input type="text" class="form-control" placeholder="{{ __('back.name') }}" name="name" required>
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
