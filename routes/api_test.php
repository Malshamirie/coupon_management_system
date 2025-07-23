<?php

use App\Http\Controllers\API\ChaletController;
use App\Models\ProductCode;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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


Route::post('/get-code', function (Request $request) {
    $phone = $request->input('phone');

    // $employeeResponse = Http::get('https://mosafer.top/api/check-employee', [
    //     'phone' => $phone
    // ]);

    // if ($employeeResponse->failed()) {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'الموظف غير مسجل في النظام'
    //     ], 404);
    // }

    $existingUserCode = UserCode::where('phone', $phone)->first();
    if ($existingUserCode) {
        return response()->json([
            'status' => 'success',
            'message' => 'لديك كوبون سابق بتاريخ ' . $existingUserCode->created_at,
            'code' => $existingUserCode->code->code
        ]);
    }

    $code = Coupon::where('status', 1)->first();
    if (!$code) {
        return response()->json([
            'status' => 'error',
            'message' => 'لا يوجد أكواد متاحة حالياً'
        ], 404);
    }

    UserCode::create([
        'phone' => $phone,
        'coupon_id' => $code->id
    ]);

    $code->update(['status' => 0]);

    return response()->json([
        'status' => 'success',
        'message' => 'تم تخصيص الكود لك',
        'code' => $code->code
    ]);
});
