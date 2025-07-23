<div class="modal fade" id="delete_campaign{{ $campaign->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('back.delete_loyalty_campaign') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.loyalty_campaigns.destroy', $campaign->id) }}" method="post">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          <p>{{ __('back.are_you_sure_delete_campaign') }} <strong>{{ $campaign->campaign_name }}</strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('back.cancel') }}</button>
          <button type="submit" class="btn btn-danger">{{ __('back.delete') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>
