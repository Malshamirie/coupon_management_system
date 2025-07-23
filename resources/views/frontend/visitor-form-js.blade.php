<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/intlTelInput.min.js"></script>
<!-- تضمين SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- تضمين Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script>
document.addEventListener("DOMContentLoaded", function () {
    let phoneInput = document.getElementById("phone");
    let submitButton = document.getElementById("phone-btn");
    let resultDiv = document.getElementById("result");
    let countryCode = '';

    submitButton.disabled = true;

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "auto",
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                var code = resp && resp.country ? resp.country : "sa";
                success(code);
            });
        },
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/utils.js"),
    });

    phoneInput.addEventListener('countrychange', function () {
        countryCode = iti.getSelectedCountryData().dialCode;
    });

    phoneInput.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, '');
        if (!countryCode) {
            resultDiv.innerHTML = "<div class='text-danger'>يرجى تحديد رمز الدولة</div>";
            submitButton.disabled = true;
        } else if (this.value.length < 5) {
            resultDiv.innerHTML = "<div class='text-danger'>يرجى إدخال رقم الجوال بشكل صحيح</div>";
            submitButton.disabled = true;
        } else {
            resultDiv.innerHTML = "";
            submitButton.disabled = false;
        }
    });

    $('#phone-btn').click(function () {
        let phone = countryCode + $('#phone').val().trim();
        if (!countryCode) {
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه',
                text: 'يرجى تحديد رمز الدولة'
            });
            return;
        }
        if (!phone) {
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه',
                text: 'يرجى إدخال رقم الهاتف'
            });
            return;
        }

        Swal.fire({
            title: 'جاري البحث...',
            html: '<div class="spinner-border text-primary" role="status"></div>',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        // هنا نرسل الـ slug ضمن الـ URL (تأكد تبدله حسب متغير الـ slug لديك في الجافاسكريبت أو Blade)
        const slug = '{{ $campaign->slug }}';

        $.ajax({
            url: `/api/get-coupon/${slug}`,
            type: 'POST',
            data: {
                phone: phone,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم بنجاح!',
                        html: `
                            <div class="card p-3 text-center" style="border: 1px solid #ddd; border-radius: 10px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">${response.message}</h5>
                                    <div class="dropdown">
                                        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ!',
                        text: response.message || 'حدث خطأ غير متوقع'
                    });
                }
            },
            error: function (xhr) {
                Swal.close();
                let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'حدث خطأ غير متوقع';
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: errorMessage
                });
            }
        });
    });

    // نسخ الكود
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

    // مشاركة الكود
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
