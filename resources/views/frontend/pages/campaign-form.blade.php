@extends('frontend.layouts.master')
@section('page_title')
    {{ trans('back.home') }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/css/intlTelInput.css">
    <style>
        .iti {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <!-- Start Blog Area -->
    <div class="account-pages mt-5 mb-5">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        @if ($campaign->logo)
                            <img src="{{ asset($campaign->logo) }}" width="150" height="100">
                        @endif

                        <h4 class=" mt-2 mb-2">
                            {{ $campaign->main_text }}
                        </h4>
                        <p>{{ $campaign->sub_text }}</p>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">

                            @if ($campaign->search_method == 'phone')
                                @include('frontend.phone-form')
                            @elseif($campaign->search_method == 'email')
                                @include('frontend.email-form')
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <p>{{ $campaign->footer_text }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
document.getElementById('email-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;

    let emailInput = document.getElementById('email').value.trim();
    @if ($campaign->email_domain)
        emailInput = emailInput + '@' + '{{ $campaign->email_domain }}';
    @endif

    
    fetch("{{ route('campaign.email.verify', $campaign->slug) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            email: emailInput
        })
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;

        // تحقق من النجاح أولاً
        if (!data.success) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: data.message || 'حدث خطأ، حاول مرة أخرى.',
            });
            return;  // لا تتابع العملية إذا فشلت
        }

        // إذا كانت العملية ناجحة، نتأكد إذا كان يحتاج تحقق OTP
        if (data.requires_otp) {
            Swal.fire({
                icon: 'info',
                title: 'تحقق من بريدك',
                text: 'تم إرسال رمز التحقق إلى بريدك الإلكتروني، يرجى إدخاله في الصفحة التالية.',
                timer: 5000, // المدة التي يبقى فيها التنبيه
                timerProgressBar: true,
                showConfirmButton: false,
                willClose: () => {
                    window.location.href = data.otp_verify_url; // التحويل تلقائيًا
                }
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: 'تم إرسال الكوبون إلى بريدك الإلكتروني بنجاح.',
                confirmButtonText: 'حسنًا'
            }).then(() => {
                window.location.href = data.success_url; // الانتقال إلى صفحة النجاح
            });
        }
    })
    .catch(() => {
        submitBtn.disabled = false;
        Swal.fire({
            icon: 'error',
            title: 'فشل الاتصال',
            text: 'حدث خطأ في الاتصال، يرجى التأكد من اتصالك بالإنترنت.',
        });
    });
});

    </script>

    @include('frontend.visitor-form-js')
@endsection
