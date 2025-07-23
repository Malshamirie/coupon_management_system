<!-- Modal -->
<div class="modal fade" id="add_group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">
          {{ __('back.add_group') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.groups.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">{{ __('back.group_name') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="{{ __('back.group_name') }}" name="name"
                required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
            <button type="submit" class="btn btn-success">{{ __('back.save') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
