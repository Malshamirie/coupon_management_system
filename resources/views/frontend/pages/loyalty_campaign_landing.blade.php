<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $campaign->campaign_name }} - {{ $campaign->card_name }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    body {
      font-family: 'Figtree', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }

    .landing-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .campaign-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      max-width: 500px;
      width: 100%;
    }

    .campaign-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .campaign-logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin: 0 auto 20px;
      display: block;
      object-fit: cover;
    }

    .campaign-body {
      padding: 30px;
    }

    .form-control {
      border-radius: 10px;
      border: 2px solid #e9ecef;
      padding: 12px 15px;
      font-size: 16px;
    }

    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control.is-valid {
      border-color: #28a745;
    }

    .form-control.is-invalid {
      border-color: #dc3545;
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 10px;
      padding: 12px 30px;
      font-size: 16px;
      font-weight: 600;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:disabled {
      background: #6c757d;
      transform: none;
      box-shadow: none;
    }

    .campaign-footer {
      background: #f8f9fa;
      padding: 20px 30px;
      text-align: center;
      color: #6c757d;
    }

    .alert {
      border-radius: 10px;
      border: none;
    }

    .loading {
      display: none;
    }

    .spinner-border-sm {
      width: 1rem;
      height: 1rem;
    }

    .phone-validation {
      font-size: 12px;
      margin-top: 5px;
    }

    .phone-validation.valid {
      color: #28a745;
    }

    .phone-validation.invalid {
      color: #dc3545;
    }

    .phone-validation.checking {
      color: #ffc107;
    }
  </style>
</head>

<body dir="rtl">
  <div class="landing-container" dir="rtl" style="text-align: right;">
    <div class="campaign-card">
      <!-- Header -->
      <div class="campaign-header">
        @if ($campaign->page_logo)
          <img src="{{ asset($campaign->page_logo) }}" alt="شعار الحملة" class="campaign-logo">
        @endif
        <h2>{{ $campaign->card_name }}</h2>
        <p class="mb-0">{{ $campaign->campaign_name }}</p>
      </div>

      <!-- Body -->
      <div class="campaign-body">
        @if ($campaign->main_text)
          <div class="text-center mb-4">
            <h4>{{ $campaign->main_text }}</h4>
          </div>
        @endif

        @if ($campaign->sub_text)
          <div class="text-center mb-4">
            <p class="text-muted">{{ $campaign->sub_text }}</p>
          </div>
        @endif

        <!-- Success/Error Messages -->
        <div id="message-container"></div>

        <!-- Campaign Form -->
        <form id="campaign-form">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">اسم العميل <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="customer_name" required>
          </div>
          

          <div class="mb-3">
            <label for="phone" class="form-label">رقم الجوال <span class="text-danger">*</span></label>
            <div class="input-group mb-3" dir="ltr">
              <span class="input-group-text" id="basic-addon1">+966</span>
              <input type="tel" 
                     id="phone" 
                     name="customer_phone" 
                     class="form-control" 
                     placeholder="50 000 0000" 
                     aria-label="phone" 
                     aria-describedby="basic-addon1" 
                     maxlength="9"
                     required>
            </div>
            <div id="phone-validation" class="phone-validation"></div>
          </div>


          <div class="mb-3">
            <label for="city" class="form-label">اختر المدينة <span class="text-danger">*</span></label>
            <select class="form-select" id="city" name="city" required>
              <option value="" disabled selected>-- اختر المدينة --</option>
              @foreach (App\Models\City::all() as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="branch" class="form-label">اختر الفرع <span class="text-danger">*</span></label>
            <select class="form-select" id="branch" name="branch_id" required disabled>
              <option value="" disabled selected>-- اختر المدينة أولاً --</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="customer_address" class="form-label">العنوان (اختياري) </label>
            <textarea class="form-control" id="customer_address" name="customer_address" rows="3"></textarea>
          </div>

          <button type="submit" class="btn btn-primary w-100" id="submit-btn" disabled>
            <span class="btn-text">إرسال</span>
            <span class="loading">
              <span class="spinner-border spinner-border-sm me-2" role="status"></span>
              جاري المعالجة
            </span>
          </button>
        </form>

        @if ($campaign->after_form_text)
          <div class="text-center mt-4">
            <p class="text-muted small">{{ $campaign->after_form_text }}</p>
          </div>
        @endif
      </div>

      <!-- Footer -->
      <div class="campaign-footer">
        <p class="mb-0">&copy; {{ date('Y') }} {{ $campaign->card_name }}. جميع الحقوق محفوظة.</p>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
      var phoneValidationTimer;
      var isPhoneValid = false;

      // التحقق من رقم الهاتف
      function validatePhone(phoneNumber) {
        // التحقق من أن الرقم يحتوي على 9 أرقام فقط
        if (phoneNumber.length !== 9) {
          return false;
        }
        
        // التحقق من أن الرقم يحتوي على أرقام فقط
        if (!/^\d{9}$/.test(phoneNumber)) {
          return false;
        }
        
        return true;
      }

      // التحقق من وجود العميل في حاوية الولاء
      function checkCustomerInLoyaltyContainer(phoneNumber) {
        $.ajax({
          url: '{{ route('api.check.customer.loyalty') }}',
          method: 'POST',
          data: {
            phone: phoneNumber,
            loyalty_container_id: '{{ $campaign->loyalty_container_id }}',
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            if (response.exists) {
              $('#phone').removeClass('is-invalid').addClass('is-valid');
              $('#phone-validation').removeClass('invalid checking').addClass('valid')
                .html('<i class="fas fa-check-circle"></i>  تم التحقق بنجاح   ');
              isPhoneValid = true;
              checkFormValidity();
            } else {
              $('#phone').removeClass('is-valid').addClass('is-invalid');
              $('#phone-validation').removeClass('valid checking').addClass('invalid')
                .html('<i class="fas fa-times-circle"></i> رقم العميل غير مسجل في حاوية الولاء');
              isPhoneValid = false;
              checkFormValidity();
            }
          },
          error: function() {
            $('#phone').removeClass('is-valid is-invalid');
            $('#phone-validation').removeClass('valid invalid').addClass('checking')
              .html('<i class="fas fa-exclamation-triangle"></i> خطأ في التحقق من رقم العميل');
            isPhoneValid = false;
            checkFormValidity();
          }
        });
      }

      // التحقق من صحة النموذج
      function checkFormValidity() {
        var name = $('#name').val().trim();
        var phone = $('#phone').val().trim();
        var city = $('#city').val();
        var branch = $('#branch').val();
        
        // التحقق من أن جميع الحقول مملوءة والهاتف صحيح
        if (name && isPhoneValid && city && branch) {
          $('#submit-btn').prop('disabled', false);
        } else {
          $('#submit-btn').prop('disabled', true);
        }
      }

      // مراقبة حقل الهاتف
      $('#phone').on('input', function() {
        var phoneNumber = $(this).val().replace(/\D/g, ''); // إزالة جميع الأحرف غير الرقمية
        
        // تحديث قيمة الحقل بالأرقام فقط
        $(this).val(phoneNumber);
        
        // إزالة الرسائل السابقة
        $('#phone-validation').removeClass('valid invalid checking').html('');
        $('#phone').removeClass('is-valid is-invalid');
        isPhoneValid = false;
        checkFormValidity();
        
        // إلغاء المؤقت السابق
        clearTimeout(phoneValidationTimer);
        
        // التحقق من صحة الرقم
        if (validatePhone(phoneNumber)) {
          // إظهار رسالة التحقق
          $('#phone-validation').addClass('checking')
            .html('<i class="fas fa-spinner fa-spin"></i> جاري التحقق من رقم العميل...');
          
          // تأخير التحقق لتجنب الطلبات المتكررة
          phoneValidationTimer = setTimeout(function() {
            checkCustomerInLoyaltyContainer(phoneNumber);
          }, 500);
        } else if (phoneNumber.length > 0) {
          $('#phone').addClass('is-invalid');
          $('#phone-validation').addClass('invalid')
            .html('<i class="fas fa-times-circle"></i> يجب إدخال 9 أرقام فقط');
        }
      });

      // مراقبة الحقول الأخرى
      $('#name, #city, #branch').on('input change', function() {
        checkFormValidity();
      });

      // Load branches when city is selected
      $('#city').change(function() {
        var cityId = $(this).val();
        var branchSelect = $('#branch');

        if (cityId) {
          // Enable branch select
          branchSelect.prop('disabled', false);
          branchSelect.html('<option value="" disabled selected>-- جاري التحميل --</option>');

          // Fetch branches for selected city
          $.ajax({
            url: '{{ route('api.branches.by.city') }}',
            method: 'GET',
            data: {
              city_id: cityId
            },
            success: function(response) {
              branchSelect.html('<option value="" disabled selected>-- اختر الفرع --</option>');

              if (response.length > 0) {
                response.forEach(function(branch) {
                  branchSelect.append('<option value="' + branch.id + '">' + branch.branch_name + '</option>');
                });
              } else {
                branchSelect.html('<option value="" disabled>-- لا توجد فروع في هذه المدينة --</option>');
              }
              checkFormValidity();
            },
            error: function() {
              branchSelect.html('<option value="" disabled>-- خطأ في تحميل الفروع --</option>');
              checkFormValidity();
            }
          });
        } else {
          // Disable branch select
          branchSelect.prop('disabled', true);
          branchSelect.html('<option value="" disabled selected>-- اختر المدينة أولاً --</option>');
          checkFormValidity();
        }
      });

      $('#campaign-form').submit(function(e) {
        e.preventDefault();

        // التحقق من صحة الهاتف قبل الإرسال
        if (!isPhoneValid) {
          $('#message-container').html(
            '<div class="alert alert-danger">' +
            '<i class="fas fa-exclamation-circle me-2"></i>' +
            'يرجى التأكد من صحة رقم الهاتف' +
            '</div>'
          );
          return;
        }

        // Show loading state
        $('#submit-btn').prop('disabled', true);
        $('.btn-text').hide();
        $('.loading').show();

        // Clear previous messages
        $('#message-container').empty();

        var formData = new FormData(this);

        // Add campaign ID to form data
        formData.append('loyalty_campaign_id', '{{ $campaign->id }}');

        $.ajax({
          url: '{{ route('api.loyalty_card_requests.store') }}',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            // Hide loading state
            $('#submit-btn').prop('disabled', false);
            $('.btn-text').show();
            $('.loading').hide();

            // Redirect to success page
            window.location.href = '{{ route('loyalty.campaign.success', $campaign->id) }}';
          },
          error: function(xhr) {
            // Hide loading state
            $('#submit-btn').prop('disabled', false);
            $('.btn-text').show();
            $('.loading').hide();

            var message = '{{ __('back.error_occurred') }}';

            if (xhr.status === 422) {
              var errors = xhr.responseJSON.errors;
              var errorMessages = [];
              for (var field in errors) {
                errorMessages.push(errors[field][0]);
              }
              message = errorMessages.join('<br>');
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
              message = xhr.responseJSON.message;
            }

            // Show error message
            $('#message-container').html(
              '<div class="alert alert-danger">' +
              '<i class="fas fa-exclamation-circle me-2"></i>' +
              message +
              '</div>'
            );
          }
        });
      });
    });
  </script>
</body>

</html>