<?php

namespace App\Http\Controllers;

use App\Models\HR\Allowance;
use App\Models\Car;
use App\Models\CarsContract;
use App\Models\Customer;
use App\Models\HR\Discount;
use App\Models\HR\Holiday;
use App\Models\HR\Message;
use App\Models\HR\Salary;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{

    public function index(Request $request)
    {
        return view('backend.dashboard');
    }



    public function show_notification_all()
    {
        return view('backend.show_notification_all');
    }





    // مسح جميع الإشعارات
    public function markAsRead_all(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        toast('تم مسح جميع الإشعارات بنجاح بنجاح','success');
        return redirect()->back();
    }


    // مسح إشعار واحد فقط
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
        toast('تم مسح الاشعار بنجاح بنجاح','success');
        return redirect()->back();
    }



}
