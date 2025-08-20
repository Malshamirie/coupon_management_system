<?php

namespace App\Http\Controllers;

use App\Mail\Notify;
use App\Models\About;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Coupon;
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
    public function visitorForm2(Request $request)
    {
        return $request;
    }


    public function emailVerify(Request $request, $slug)
    {

        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        $emailDomain = $campaign->email_domain;
        // $email = $emailDomain != '' ?  $request->input('email').'@' . $emailDomain : $request->input('email');
        $email = $request->input('email');

        // return $email;
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

            // حفظ الإيميل في الجلسة لاستخدامه لاحقًا في التحقق
            session(['otp_email' => $email]);

            // حفظ OTP في الكاش لمدة 10 دقائق مرتبطًا بالإيميل
            Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

            // إرسال الإيميل برمز التحقق (تحتاج Mail setup)
            $data = [
                'title' => 'رمز التحقق',
                'message' => 'رمز التحقق الخاص بك هو: ' . $otp,
            ];
            // return response()->json($data);
            Mail::to($email)->send(new Notify($data, 'otp'));

            return response()->json([
                'success' => true,
                'requires_otp' => true,
                'otp_verify_url' => route('campaign.email.otp.verify', $campaign->slug),
            ]);
        } else {

            // 2️⃣ جلب كود جديد بحالة "active"
            $coupon = Coupon::where('status', 1)->where('container_id', $campaign->container->id)->first();
            // return $coupon;
            if (!$coupon) {
                // بدل return back() ترجع JSON واضحة للواجهة
                return response()->json([
                    'success' => false,
                    'message' => 'لا يوجد كوبونات متاحة حالياً',
                ]);
            }

            $data = [
                'title' => '🎉 مبروك',
                'message' => ' تم استلام كوبونك : ' . $coupon->code,
            ];
            Mail::to($email)->send(new Notify($data, '🎉 مبروك!'));

            // 3️⃣ تسجيل المستخدم مع الكوبون الجديد وتحديث حالة الكود
            UserCode::create([
                'email' => $email,
                'coupon_id' => $coupon->id,
                'campaign_id' => $campaign->id,
                'code' => $coupon->code,
            ]);
            $coupon->update(['status' => 0]); // تحديث حالة الكود إلى "used"

            return response()->json([
                'success' => true,
                'requires_otp' => false,
                'success_url' => route('campaign.success', $campaign->slug),
            ]);
        }
    }

    public function verifyOtp(Request $request, $slug)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        // جلب الإيميل من الجلسة ولا نعتمد على حقل مخفي من الفورم
        $email = session('otp_email');
        if (!$email) {
            return back()->withErrors(['otp' => 'حدث خطأ: بيانات الجلسة مفقودة.']);
        }

        $otpCacheKey = 'otp_' . $email;
        $cachedOtp = Cache::get($otpCacheKey);

        if (!$cachedOtp) {
            return back()->withErrors(['otp' => 'رمز التحقق انتهت صلاحيته.']);
        }

        if ($request->otp != $cachedOtp) {
            return back()->withErrors(['otp' => 'رمز التحقق غير صحيح.']);
        }



        // 2️⃣ جلب كود جديد بحالة "active"
        $coupon = Coupon::where('status', 1)->where('container_id', $campaign->container->id)->first();
        if (!$coupon) {
            return back()->withErrors(['otp' => 'لا يوجد كوبونات متاحة حالياً']);
        }
        // 3️⃣ تسجيل المستخدم مع الكوبون الجديد وتحديث حالة الكود
        UserCode::create([
            'email' => $email,
            'coupon_id' => $coupon->id,
            'campaign_id' => $campaign->id,
            'code' => $coupon->code,
        ]);
        $coupon->update(['status' => 0]); // تحديث حالة الكود إلى "used"

        $data = [
            'title' => '🎉 مبروك',
            'message' => ' تم استلام كوبونك : ' . $coupon->code,
        ];
        Mail::to($email)->send(new Notify($data, '🎉 مبروك!'));

        // رمز التحقق صحيح
        Cache::forget($otpCacheKey);
        session()->forget('otp_email');
        return redirect()->route('campaign.success', $slug);
    }




    public function showOtpVerifyForm($slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.otp-verify', compact('campaign'));
    }


    public function success($slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.success', compact('campaign'));
    }

    public function loyaltyCampaignLanding($id)
    {
        $campaign = \App\Models\LoyaltyCampaign::findOrFail($id);
        return view('frontend.pages.loyalty_campaign_landing', compact('campaign'));
    }

    public function loyaltyCampaignSuccess($id)
    {
        $campaign = \App\Models\LoyaltyCampaign::findOrFail($id);
        return view('frontend.pages.loyalty_campaign_success', compact('campaign'));
    }

    public function verifyOtpء(Request $request, $slug)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        $email = session('otp_email');
        if (!$email) {
            return back()->withErrors(['otp' => 'حدث خطأ: بيانات الجلسة مفقودة.']);
        }

        $otpCacheKey = 'otp_' . $email;
        $cachedOtp = Cache::get($otpCacheKey);

        if (!$cachedOtp) {
            return back()->withErrors(['otp' => 'رمز التحقق انتهت صلاحيته.']);
        }

        if ($request->otp !== $cachedOtp) {
            return back()->withErrors(['otp' => 'رمز التحقق غير صحيح.']);
        }

        Cache::forget($otpCacheKey);
        session()->forget('otp_email');

        // من هنا تكتب منطق إصدار الكوبون

        return redirect()->route('campaign.success', $slug);
    }
}
