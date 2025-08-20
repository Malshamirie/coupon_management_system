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
        <form action="{{ route('admin.customers.import') }}" method="post" enctype="multipart/form-data" id="importForm">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.container') }} <span class="text-danger">*</span></label>
              <select name="loyalty_container_id" class="form-select" required>
                <option value="">{{ __('back.select_container') }}</option>
                @foreach ($loyaltyContainers as $loyaltyContainer)
                  <option value="{{ $loyaltyContainer->id }}">{{ $loyaltyContainer->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">{{ __('back.import_file') }} <span class="text-danger">*</span></label>
              <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.csv,.txt" required id="importFile">
              <small class="text-muted">الملفات المدعومة: Excel, CSV, TXT</small>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">نوع الملف</label>
              <select name="file_type" class="form-select" id="fileType">
                <option value="with_headers">ملف يحتوي على عناوين الأعمدة</option>
                <option value="without_headers">ملف بدون عناوين (البيانات تبدأ من الصف الأول)</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">ترتيب الأعمدة (إذا لم تكن هناك عناوين)</label>
              <select name="column_order" class="form-select" id="columnOrder" style="display: none;">
                <option value="name,phone,email,address">الاسم, الهاتف, البريد الإلكتروني, العنوان</option>
                <option value="name,phone,email">الاسم, الهاتف, البريد الإلكتروني</option>
                <option value="name,phone">الاسم, الهاتف فقط</option>
              </select>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="alert alert-info">
                <h6>تنسيق الملف المطلوب:</h6>
                <div id="formatInfo">
                  <p><strong>مع عناوين:</strong> يجب أن يحتوي الملف على الأعمدة التالية:</p>
                  <ul>
                    <li><strong>الاسم</strong> أو <strong>name</strong> (مطلوب)</li>
                    <li><strong>رقم_الهاتف</strong> أو <strong>phone</strong> أو <strong>phone_number</strong> (مطلوب)</li>
                    <li><strong>البريد_الإلكتروني</strong> أو <strong>email</strong> (اختياري)</li>
                    <li><strong>العنوان</strong> أو <strong>address</strong> (اختياري)</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          
          <!-- منطقة عرض نتائج التشخيص -->
          <div class="row" id="debugResults" style="display: none;">
            <div class="col-md-12 mb-3">
              <div class="alert alert-warning">
                <h6>نتائج فحص الملف:</h6>
                <div id="debugContent"></div>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-info" id="debugBtn" style="display: none;">
              <i class="fas fa-search"></i> فحص الملف
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('back.close') }}</button>
            <button type="submit" class="btn btn-success">{{ __('back.import_customers') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('importFile');
    const fileType = document.getElementById('fileType');
    const columnOrder = document.getElementById('columnOrder');
    const formatInfo = document.getElementById('formatInfo');
    const debugBtn = document.getElementById('debugBtn');
    const debugResults = document.getElementById('debugResults');
    const debugContent = document.getElementById('debugContent');
    
    fileType.addEventListener('change', function() {
        if (this.value === 'without_headers') {
            columnOrder.style.display = 'block';
            formatInfo.innerHTML = `
                <p><strong>بدون عناوين:</strong> البيانات تبدأ من الصف الأول بالترتيب التالي:</p>
                <ul>
                    <li><strong>العمود الأول:</strong> الاسم (مطلوب)</li>
                    <li><strong>العمود الثاني:</strong> رقم الهاتف (مطلوب)</li>
                    <li><strong>العمود الثالث:</strong> البريد الإلكتروني (اختياري)</li>
                    <li><strong>العمود الرابع:</strong> العنوان (اختياري)</li>
                </ul>
            `;
        } else {
            columnOrder.style.display = 'none';
            formatInfo.innerHTML = `
                <p><strong>مع عناوين:</strong> يجب أن يحتوي الملف على الأعمدة التالية:</p>
                <ul>
                    <li><strong>الاسم</strong> أو <strong>name</strong> (مطلوب)</li>
                    <li><strong>رقم_الهاتف</strong> أو <strong>phone</strong> أو <strong>phone_number</strong> (مطلوب)</li>
                    <li><strong>البريد_الإلكتروني</strong> أو <strong>email</strong> (اختياري)</li>
                    <li><strong>العنوان</strong> أو <strong>address</strong> (اختياري)</li>
                </ul>
            `;
        }
    });
    
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            debugBtn.style.display = 'inline-block';
        } else {
            debugBtn.style.display = 'none';
            debugResults.style.display = 'none';
        }
    });
    
    debugBtn.addEventListener('click', function() {
        const formData = new FormData();
        formData.append('file', fileInput.files[0]);
        formData.append('_token', '{{ csrf_token() }}');
        
        debugBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الفحص...';
        debugBtn.disabled = true;
        
        fetch('{{ route("admin.customers.debug-import") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                debugContent.innerHTML = `<div class="text-danger">${data.error}</div>`;
            } else {
                let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <strong>معلومات الملف:</strong><br>
                            الاسم: ${data.file_info.original_name}<br>
                            الحجم: ${data.file_info.size} bytes<br>
                            النوع: ${data.file_info.mime_type}<br>
                            عدد الصفوف: ${data.total_rows}
                        </div>
                        <div class="col-md-6">
                            <strong>العناوين المكتشفة:</strong><br>
                            ${data.headers.map((header, index) => `${index + 1}. "${header}"`).join('<br>')}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>الصف الأول:</strong><br>
                            ${data.first_row.map((cell, index) => `${index + 1}. "${cell}"`).join('<br>')}
                        </div>
                        <div class="col-md-4">
                            <strong>الصف الثاني:</strong><br>
                            ${data.second_row.map((cell, index) => `${index + 1}. "${cell}"`).join('<br>')}
                        </div>
                        <div class="col-md-4">
                            <strong>الصف الثالث:</strong><br>
                            ${data.third_row.map((cell, index) => `${index + 1}. "${cell}"`).join('<br>')}
                        </div>
                    </div>
                `;
                
                if (data.recommendations && data.recommendations.length > 0) {
                    html += `<hr><div class="alert alert-info"><strong>التوصيات:</strong><br>${data.recommendations.join('<br>')}</div>`;
                }
                
                debugContent.innerHTML = html;
            }
            debugResults.style.display = 'block';
        })
        .catch(error => {
            debugContent.innerHTML = `<div class="text-danger">خطأ في الاتصال: ${error.message}</div>`;
            debugResults.style.display = 'block';
        })
        .finally(() => {
            debugBtn.innerHTML = '<i class="fas fa-search"></i> فحص الملف';
            debugBtn.disabled = false;
        });
    });
});
</script>
