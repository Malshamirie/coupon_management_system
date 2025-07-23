<!-- Modal -->
<div class="modal fade" id="delete_customer{{ $customer->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">
          {{ __('back.delete_customer') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="post">
          @csrf
          @method('DELETE')
          <div class="text-center">
            <h4>
              {{ trans('back.Are_you_sure_to_delete') }} {{ $customer->name }}
            </h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
            <button type="submit" class="btn btn-danger">{{ trans('back.Delete') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
