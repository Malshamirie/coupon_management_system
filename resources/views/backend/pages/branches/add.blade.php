<!-- Modal -->
<div class="modal fade" id="add_branch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">
          {{ __('back.add_branch') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.branches.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.branch_number') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="{{ __('back.branch_number') }}"
                name="branch_number" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.branch_name') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="{{ __('back.branch_name') }}" name="branch_name"
                required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.contact_number') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="{{ __('back.contact_number') }}"
                name="contact_number" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.city') }} <span class="text-danger">*</span></label>
              <select name="city_id" class="form-select" required>
                <option value="">{{ __('back.select_city') }}</option>
                @foreach ($cities as $city)
                  <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.area') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="{{ __('back.area') }}" name="area" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.group') }} <span class="text-danger">*</span></label>
              <select name="group_id" class="form-select" required>
                <option value="">{{ __('back.select_group') }}</option>
                @foreach ($groups as $group)
                  <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">{{ __('back.google_map_link') }}</label>
              <input type="url" class="form-control" placeholder="{{ __('back.google_map_link') }}"
                name="google_map_link">
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
