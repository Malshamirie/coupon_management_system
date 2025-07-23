@extends('frontend.layouts.master')
@section('page_title')
OTP
@endsection


@section('content')
<!-- Start Blog Area -->
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <h4 class=" mt-2 mb-2">
                    تحقق من رمز التحقق (OTP)
                </h4>

                <div class="card">
                    <div class="card-body p-4">
                        <form id="otp-verify" method="POST" action="{{ route('campaign.email.otp.verify.post', $campaign->slug) }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ request('email') }}">

                            <div class="mb-3">
                                <label for="otp" class="form-label">أدخل رمز التحقق المرسل إلى بريدك الإلكتروني</label>
                                <input type="text" name="otp" id="otp" class="form-control" required>
                                @error('otp')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" id="submit-btn" class="btn btn-primary w-100">تحقق</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.getElementById('otp-verify').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = true;
});
</script>
@endsection