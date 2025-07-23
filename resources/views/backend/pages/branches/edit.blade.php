<!-- Modal -->
<div class="modal fade" id="edit_branch{{ $branch->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">
          {{ __('back.edit_branch') }} / {{ $branch->branch_name }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.branches.update', $branch->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.branch_number') }} <span class="text-danger">*</span></label>
              <input type="text" value="{{ $branch->branch_number }}" class="form-control"
                placeholder="{{ __('back.branch_number') }}" name="branch_number" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.branch_name') }} <span class="text-danger">*</span></label>
              <input type="text" value="{{ $branch->branch_name }}" class="form-control"
                placeholder="{{ __('back.branch_name') }}" name="branch_name" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.contact_number') }} <span class="text-danger">*</span></label>
              <input type="text" value="{{ $branch->contact_number }}" class="form-control"
                placeholder="{{ __('back.contact_number') }}" name="contact_number" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.city') }} <span class="text-danger">*</span></label>
              <select name="city_id" class="form-select" required>
                <option value="">{{ __('back.select_city') }}</option>
                @foreach ($cities as $city)
                  <option value="{{ $city->id }}" {{ $branch->city_id == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.area') }} <span class="text-danger">*</span></label>
              <input type="text" value="{{ $branch->area }}" class="form-control"
                placeholder="{{ __('back.area') }}" name="area" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.group') }} <span class="text-danger">*</span></label>
              <select name="group_id" class="form-select" required>
                <option value="">{{ __('back.select_group') }}</option>
                @foreach ($groups as $group)
                  <option value="{{ $group->id }}" {{ $branch->group_id == $group->id ? 'selected' : '' }}>
                    {{ $group->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">{{ __('back.google_map_link') }}</label>
              <input type="url" value="{{ $branch->google_map_link }}" class="form-control"
                placeholder="{{ __('back.google_map_link') }}" name="google_map_link">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
            <button type="submit" class="btn btn-success">{{ trans('back.save_and_update') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
