<!-- Modal -->
<div class="modal fade" id="import_customers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">
          {{ __('back.import_customers') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.customers.import') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.container') }} <span class="text-danger">*</span></label>
              <select name="container_id" class="form-select" required>
                <option value="">{{ __('back.select_container') }}</option>
                @foreach ($containers as $container)
                  <option value="{{ $container->id }}">{{ $container->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.import_file') }} <span class="text-danger">*</span></label>
              <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.csv,.txt" required>
              <small class="text-muted">الملفات المدعومة: Excel, CSV, TXT</small>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="alert alert-info">
                <h6>تنسيق الملف المطلوب:</h6>
                <p>يجب أن يحتوي الملف على الأعمدة التالية:</p>
                <ul>
                  <li><strong>الاسم</strong> أو <strong>name</strong> (مطلوب)</li>
                  <li><strong>رقم_الهاتف</strong> أو <strong>phone_number</strong> (مطلوب)</li>
                  <li><strong>البريد_الإلكتروني</strong> أو <strong>email</strong> (اختياري)</li>
                  <li><strong>العنوان</strong> أو <strong>address</strong> (اختياري)</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
            <button type="submit" class="btn btn-success">{{ __('back.import_customers') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
