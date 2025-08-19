<!-- Modal -->
<div class="modal fade" id="add_customer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">
          {{ __('back.add_customer') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.customers.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.name') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="{{ __('back.name') }}" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.phone_number') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="{{ __('back.phone_number') }}" name="phone"
                required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.email') }}</label>
              <input type="email" class="form-control" placeholder="{{ __('back.email') }}" name="email">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.container') }} <span class="text-danger">*</span></label>
              <select name="loyalty_container_id" class="form-select" required>
                <option value="">{{ __('back.select_container') }}</option>
                @foreach ($loyaltyContainers as $loyaltyContainer)
                  <option value="{{ $loyaltyContainer->id }}">{{ $loyaltyContainer->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">{{ __('back.address') }}</label>
              <textarea class="form-control" rows="3" placeholder="{{ __('back.address') }}" name="address"></textarea>
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
