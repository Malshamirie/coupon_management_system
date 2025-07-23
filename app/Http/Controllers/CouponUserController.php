<?php

namespace App\Http\Controllers;

use App\Exports\CouponUserExport;
use App\Imports\CodeImport;
use App\Models\Coupon;
use App\Models\UserCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CouponUserController extends Controller
{
public function index(Request $request)
{


    $query = UserCode::query();
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('email', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('code', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->orWhereHas('campaign', function($q2) use ($search) {
                $q2->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('manager_name', 'LIKE', "%{$search}%");
            });

    });
    // فلترة حسب التصنيفات
    if ($request->filled('campaign_id') && $request->campaign_id != 0) {
        $query->where('campaign_id', $request->campaign_id);
    }
    $usercodes = $query->orderBy('created_at', 'desc')->paginate(20);
    return view('backend.pages.usercodes.index', compact('usercodes'));
}

     public function excel(Request $request)
{

    // استعلام مع فلترة التواريخ
    $query = UserCode::query();
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('email', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('code', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->orWhereHas('campaign', function($q2) use ($search) {
                $q2->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('manager_name', 'LIKE', "%{$search}%");
            });

    });
    // فلترة حسب التصنيفات
    if ($request->filled('campaign_id') && $request->campaign_id != 0) {
        $query->where('campaign_id', $request->campaign_id);
    }

    // النتائج والصفحات
    $products = $query->orderBy('created_at', 'desc')->get();


    // return $reports_Expenses;
    return Excel::download(new CouponUserExport($products), 'coupon_user_report.xlsx');
}

    public function destroy($id)
    {
        $code = Coupon::find($id);
        $code->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }

}
