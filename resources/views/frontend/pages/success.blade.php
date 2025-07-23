@extends('frontend.layouts.master')

@section('content')
<div class="container mt-5 text-center">
    <div class="alert alert-success">
        <h2>🎉 مبروك!</h2>
        <p>تم إرسال الكوبون إلى بريدك الإلكتروني بنجاح.</p>

        <a href="{{ $campaign->redirect }}" class="btn btn-primary mt-3">العودة إلى الصفحة الرئيسية</a>
    </div>
</div>
@endsection
