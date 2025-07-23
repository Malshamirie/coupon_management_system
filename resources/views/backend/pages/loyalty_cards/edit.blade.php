<!-- Modal -->
<div class="modal fade" id="edit_loyalty_card{{ $card->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">
          {{ __('back.edit_loyalty_card') }} / {{ $card->name }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.loyalty_cards.update', $card->id) }}" method="post"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.card_name') }} <span class="text-danger">*</span></label>
              <input type="text" value="{{ $card->name }}" class="form-control"
                placeholder="{{ __('back.card_name') }}" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.card_image') }}</label>
              <input type="file" class="form-control" name="image" accept="image/*">
              <small class="text-muted">{{ __('back.max_size_2mb') }} - {{ __('back.image_dimensions') }}</small>
              @if ($card->image)
                <div class="mt-2">
                  <img src="{{ $card->image_url }}" alt="{{ $card->name }}" class="img-thumbnail"
                    style="max-width: 100px; max-height: 100px;">
                </div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">{{ __('back.card_description') }}</label>
              <textarea class="form-control" rows="3" placeholder="{{ __('back.card_description') }}" name="description">{{ $card->description }}</textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active{{ $card->id }}"
                  {{ $card->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active{{ $card->id }}">
                  {{ __('back.activate_card') }}
                </label>
              </div>
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
