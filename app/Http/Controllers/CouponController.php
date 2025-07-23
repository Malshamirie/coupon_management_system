<?php

namespace App\Http\Controllers;

use App\Imports\CodeImport;
use App\Models\Coupon;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CouponController extends Controller
{

    public function index(Request $request)
{
    $queryBuilder = Coupon::query();

    // فلترة حسب النص في حقل الكود إذا وُجد
    if ($request->filled('query')) {
        $search = $request->input('query');
        $queryBuilder->where('code', 'LIKE', "%{$search}%");
    }

    // فلترة حسب الحالة إذا تم اختيارها
    if ($request->has('status') && $request->input('status') != '') {
        $queryBuilder->where('status', $request->input('status'));
    }

    $coupons = $queryBuilder->orderBy('id', 'desc')->paginate(10);

    return view('backend.pages.coupons.index', compact('coupons'));
}




   public function create(){
    return view('backend.pages.coupons.upload-form');
   }

    public function store(Request $request)
    {
        $request->validate([

            'code'       => 'required|unique:coupons',
            'container_id'       => 'required',
            'status'         => 'nullable',
            'value_type'         => 'nullable',
        ]);

        $code=Coupon::create([
            'code'=>$request->code,
            'status'=>$request->status,
            'value_type'=>$request->value_type,
            'container_id'=> $request->container_id,

        ]);
        $code->save();
        toast('تم الإضافة بنجاح','success');
        return redirect()->back();
    }


    public function update(Request $request,$id){
        $request->validate([
            'code'       => 'required|unique:coupons,code,'.$id,
            'status'         => 'nullable',
            'value_type'         => 'nullable',
            'container_id'       => 'required',
        ]);
        $code = Coupon::find($id);
        $code->code = $request->code;
        $code->status = $request->status;
        $code->value_type = $request->value_type;
        $code->container_id = $request->container_id;
        $code->save();
        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }


    public function import(Request $request)
{
    // التحقق من وجود الملف
    $validator = Validator::make($request->all(), [
        'file' => 'required|mimes:xlsx,csv,txt|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'يرجى رفع ملف صحيح (Excel أو TXT)'], 422);
    }
    $container_id = $request->container_id;
    if (!isset($container_id)) {
        return response()->json(['message' => 'لم يتم تحديد القسم'], 422);
    }
    $file = $request->file('file');
    $extension = $file->getClientOriginalExtension();

    if ($extension == 'xlsx' || $extension == 'csv') {
        // استخدام Laravel Excel لاستيراد الملفات
        Excel::import(new CodeImport, $file);
    } elseif ($extension == 'txt') {
        // معالجة الملفات النصية
        $contents = file($file->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // تجميع الأكواد الجديدة لتحديثها أو إدخالها دفعة واحدة
        $codesToInsert = [];
        foreach ($contents as $line) {
            $code = trim($line);
            // إضافة الأكواد إلى مصفوفة
            $codesToInsert[] = ['code' => $code, 'container_id' => $container_id];
        }

        $container_id=$request->container_id;
        // معالجة الأكواد دفعة واحدة باستخدام upsert
        DB::table('coupons')->upsert(
            $codesToInsert,
            ['code'], // المفتاح الأساسي للكود
            ['updated_at'], // تحديث تاريخ التعديل
            ['container_id']
        );
    }

    return response()->json(['message' => 'تم استيراد الأكواد بنجاح!']);
}




public function usercode(Request $request)
{
    $queryBuilder = UserCode::query();

    // فلترة حسب النص في حقل الكود إذا وُجد
    if ($request->filled('query')) {
        $search = $request->input('query');
        $queryBuilder->where('phone', 'LIKE', "%{$search}%");
        $queryBuilder->orwhere('code', 'LIKE', "%{$search}%");
    }
    $usercodes = $queryBuilder->orderBy('created_at', 'desc')->paginate(20);
    return view('backend.pages.usercodes.index', compact('usercodes'));
}

    public function destroy($id)
    {
        $code = Coupon::find($id);
        $code->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }

}
