@extends('frontend.layouts.master')
@section('page_title')
    {{trans('back.home')}}
@endsection

@section('css')
   <style>
    .loading-spinner{
  width:30px;
  height:30px;
  border:2px solid indigo;
  border-radius:50%;
  border-top-color:#0001;
  display:inline-block;
  animation:loadingspinner .7s linear infinite;
}
@keyframes loadingspinner{
  0%{
    transform:rotate(0deg)
  }
  100%{
    transform:rotate(360deg)
  }
}
   </style>
@endsection

@section('content')
    @include('frontend._form')
@endsection

@section('js')
<!-- تضمين SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- تضمين Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<script>
    $(document).ready(function () {
        $('#submit').click(function () {
            let phone = $('#phone').val().trim();

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
                url: 'api/get-code',
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let phoneInput = document.getElementById("phone");
        let submitButton = document.getElementById("submit");
        let resultDiv = document.getElementById("result");

        // تعطيل الزر عند تحميل الصفحة
        submitButton.disabled = true;

        phoneInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 9) {
                this.value = this.value.slice(0, 9);
            }
            // التحقق من الشروط
            if (this.value.length === 9) {
                if (this.value.startsWith("5")) {
                    resultDiv.innerHTML = ""; // إزالة أي رسالة خطأ
                    submitButton.disabled = false; // تفعيل الزر
                } else {
                    resultDiv.innerHTML = "<div class='text-danger'>  يرجي ادخل رقم الجوال بشكل صحيح </div>";
                    submitButton.disabled = true;
                }
            } else {
                resultDiv.innerHTML = "<div class='text-danger'>  يرجي ادخل رقم الجوال بشكل صحيح  </div>";
                submitButton.disabled = true;
            }
        });
    });
</script>

@endsection
