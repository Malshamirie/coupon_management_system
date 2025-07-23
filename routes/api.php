<?php

use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/get-coupon/{slug}', function (Request $request, $slug) {
    $phone = $request->input('phone');

    // جلب الحملة حسب الـ slug
    $campaign = Campaign::where('slug', $slug)->firstOrFail();

    // التحقق هل لديه كوبون سابق
    $existingUserCode = UserCode::where('phone', $phone)->where('campaign_id', $campaign->id)->first();
    if ($existingUserCode) {
        return response()->json([
            'status' => 'success',
            'message' => 'لديك كوبون سابق بتاريخ ' . $existingUserCode->created_at,
            'code' => $existingUserCode->code
        ]);
    }

    // جلب كوبون جديد مرتبط بحاوية الحملة
    $code = Coupon::where('status', 1)
        ->where('container_id', $campaign->container->id)
        ->first();

    if (!$code) {
        return response()->json([
            'status' => 'error',
            'message' => 'لا يوجد أكواد متاحة حالياً'
        ], 404);
    }

    // تسجيل المستخدم مع الكوبون الجديد وتحديث حالته
    UserCode::create([
        'phone' => $phone,
        'coupon_id' => $code->id,
        'campaign_id' => $campaign->id,
        'code' => $code->code,
    ]);
    $code->update(['status' => 0]);

    // إرسال رسالة واتساب (اختياري)
    $whatsappResponse = Http::withHeaders([
        'Authorization' => 'Bearer 24143221ba80f4af6240c53710769f6288633bdaa6e14725edb563ca65fca887',
        'Content-Type' => 'application/json',
    ])->post('https://ob.bab.solutions/v1/wa/messages', [
        'templateID' => $campaign->id_template,
        'userPhoneNumber' => $phone,
        'variables' => [
            $campaign->whatsapp_image_url,
            $code->code
        ],
        'metadata' => [
            'invoiceNumber' => now()->timestamp
        ]
    ]);

    if ($whatsappResponse->failed()) {
        return response()->json([
            'status' => 'error',
            'message' => 'فشل في إرسال الكوبون إلى واتساب' . $whatsappResponse->body(),
            'error' => $whatsappResponse->body()
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'تم تخصيص الكود لك',
        'code' => $code->code
    ]);
})->name('campaign-form/api/get-coupon');