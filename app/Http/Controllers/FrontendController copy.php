<?php

namespace App\Http\Controllers;

use App\Mail\Notify;
use App\Models\About;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;


class FrontendController extends Controller
{

    public function index()
    {
        // return view('frontend.home');
    }

    public function visitorForm()
    {
        return view('frontend.visitor-form');
    }
    public function visitorForm2( Request $request)
    {
        return $request;
    }


    public function emailVerify(Request $request, $slug)
{
    $campaign = Campaign::where('slug', $slug)->firstOrFail();

    $emailDomain = $campaign->email_domain;
    $email = $emailDomain != '' ?  $request->input('email').'@' . $emailDomain : $request->input('email');

    // التحقق من صحة الإيميل وبناءً على الدومين
    if ($emailDomain) {
        // الإيميل لازم ينتهي بهذا الدومين
        // if (!str_ends_with($email, '@' . $emailDomain)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'يرجى إدخال البريد الإلكتروني بصيغة صحيحة ضمن الدومين: @' . $emailDomain,
        //     ]);
        // }
    } else {


        // تحقق من صحة الإيميل بشكل عام
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'success' => false,
                'message' => 'البريد الإلكتروني غير صالح',
            ]);
        }
    }

    // التحقق هل هذا المستخدم لديه كوبون مسبق في user_codes
    $existingCode = UserCode::where('campaign_id', $campaign->id)
        ->where('email', $email)
        ->first();

    if ($existingCode) {
        return response()->json([
            'success' => false,
            'message' => 'لديك كوبون مسبق تم استلامه بتاريخ ' . $existingCode->created_at->format('Y-m-d H:i'),
        ]);
    }

    // إذا لا يوجد كوبون سابق، نكمل حسب إعداد OTP
    if ($campaign->otp_required) {
        // إنشاء رمز تحقق جديد وإرساله عبر البريد (OTP)
        $otp = rand(100000, 999999);

        // هنا تحفظ OTP مع الإيميل والحملة مثلاً في جدول مؤقت (يجب تنفيذه)
        Cache::put('otp_'.$email, $otp, now()->addMinutes(10));

        // إرسال الإيميل برمز التحقق (تحتاج Mail setup)
        $data = [
            'title' => ' رمز التحقق',
            'message' => '     رمز التحقق :'.' '. $otp,
        ];
        Mail::to($email)->send(new Notify($data, 'otp'));

        return response()->json([
            'success' => true,
            'requires_otp' => true,
            'otp_verify_url' => route('campaign.email.otp.verify', $campaign->slug),
        ]);
    } else {
        // لا OTP، نمنح الكوبون مباشرة ونحفظ العملية (الكود البرمجي لإصدار الكوبون بعد)
        // ... هنا تكتب الكود اللي يعطي الكوبون مباشرة ويخزن البيانات

        return response()->json([
            'success' => true,
            'requires_otp' => false,
            'success_url' => route('campaign.success', $campaign->slug),
        ]);
    }
}



public function showOtpVerifyForm($slug)
{
    $campaign = Campaign::where('slug', $slug)->firstOrFail();
    return view('frontend.pages.otp-verify', compact('campaign'));
}


public function verifyOtp(Request $request, $slug)
{
    $campaign = Campaign::where('slug', $slug)->firstOrFail();

    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|string',
    ]);

    $otpCacheKey = 'otp_' . $request->email;
    $cachedOtp = Cache::get($otpCacheKey);

    if (!$cachedOtp) {
        return back()->withErrors(['otp' => 'رمز التحقق انتهت صلاحيته. الرجاء إعادة المحاولة.']);
    }

    if ($request->otp !== $cachedOtp) {
        return back()->withErrors(['otp' => 'رمز التحقق غير صحيح.']);
    }

    // هنا تكتب منطق إعطاء الكوبون وحفظ بيانات المستخدم
    Cache::forget($otpCacheKey);

    // افتراضياً، توجه لصفحة النجاح
    return redirect()->route('campaign.success', $slug);
}

}
