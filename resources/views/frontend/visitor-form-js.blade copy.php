
<script>
   document.addEventListener("DOMContentLoaded", function () {
    let phoneInput = document.getElementById("phone");
    let submitButton = document.getElementById("submit");
    let resultDiv = document.getElementById("result");
    // تعطيل الزر عند تحميل الصفحة
    submitButton.disabled = true;

    phoneInput.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, ''); // إزالة الأحرف غير الرقمية
        if (this.value.length > 12) {
            this.value = this.value.slice(0, 12); // الحد الأقصى 12 رقم
        }
        // التحقق من الشروط
        if (this.value.length <= 5 ) {
            resultDiv.innerHTML = "";//عندما يكون فارغ يضل الزر مقفل
            submitButton.disabled = true;
            resultDiv.innerHTML = "<div class='text-danger'>يرجى إدخال رقم الجوال بشكل صحيح</div>";
        } else if (this.value.length === 0) {
            resultDiv.innerHTML = "";//عندما يكون فارغ يضل الزر مقفل
            submitButton.disabled = true;
        } else {
            resultDiv.innerHTML = "";
            submitButton.disabled = false;
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/intlTelInput.min.js"></script>
<!-- تضمين SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- تضمين Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script>
    $(document).ready(function () {
    const input = document.querySelector("#phone");
    const iti = window.intlTelInput(input, {
        initialCountry: "auto",
        excludeCountries: ["sa"],
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                var countryCode = resp && resp.country ? resp.country : "sa";
                success(countryCode);
            });
        },
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/utils.js"),
    });

    $('#submit').click(function () {
        let countryCode = iti.getSelectedCountryData().dialCode; // الحصول على رمز الدولة من intlTelInput
        let phone = countryCode + $('#phone').val().trim();

        if (!phone) {
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه',
                text: 'يرجى إدخال رقم الهاتف'
            });
            return;
        }

        // عرض نافذة التحميل
        Swal.fire({
            title: 'جاري البحث...',
            html: '<div class="spinner-border text-primary" role="status"></div>',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        $.ajax({
            url: 'api/get-coupon',
            type: 'POST',
            data: { phone: phone },
            success: function (response) {
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم بنجاح!',
                        html: `
                            <div class="card p-3 text-center" style="border: 1px solid #ddd; border-radius: 10px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">${response.message}</h5>
                                    <div class="dropdown">
                                        <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu" style="text-align: right !important;">
                                            <li><a class="dropdown-item copy-code" href="#" data-code="${response.code}"><i class="bi bi-copy"></i> نسخ</a></li>
                                            <li><a class="dropdown-item share-code" href="#" data-code="${response.code}"><i class="bi bi-share"></i> مشاركة</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <h3 class="text-success" id="code-value">${response.code}</h3>
                            </div>
                        `
                    });
                }, 1000);
            },
            error: function (xhr) {
                setTimeout(() => {
                    let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'حدث خطأ غير متوقع';
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ!',
                        text: errorMessage
                    });
                }, 1000);
            }
        });
    });

    // نسخ الكود عند الضغط على "نسخ"
    $(document).on('click', '.copy-code', function (e) {
        e.preventDefault();
        let code = $(this).data('code');
        navigator.clipboard.writeText(code).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'تم النسخ!',
                text: 'تم نسخ الكود إلى الحافظة'
            });
        });
    });

    // مشاركة الكود عند الضغط على "مشاركة"
    $(document).on('click', '.share-code', function (e) {
        e.preventDefault();
        let code = $(this).data('code');
        let shareText = `هذا هو الكود الخاص بي: ${code}`;
        let shareUrl = encodeURIComponent(shareText);

        Swal.fire({
            title: 'مشاركة الكود',
            html: `
                <a href="https://api.whatsapp.com/send?text=${shareUrl}" target="_blank" class="btn btn-outline-success"><i class="bi bi-whatsapp"></i></a>
                <a href="https://twitter.com/intent/tweet?text=${shareUrl}" target="_blank" class="btn btn-outline-dark"><i class="bi bi-twitter-x"></i> </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=${shareUrl}" target="_blank" class="btn btn-outline-primary"><i class="bi bi-facebook"></i></a>
                <a href="sms:?body=${shareUrl}" class="btn btn-outline-primary"> <i class="bi bi-chat-left-text"></i></a>
            `,
            showConfirmButton: false
        });
    });
});
</script>
