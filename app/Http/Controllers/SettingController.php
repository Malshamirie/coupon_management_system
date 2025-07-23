<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{


    public function index()
    {
        $setting = Setting::first();
        return view('backend.pages.setting.index', compact('setting'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'logo'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name'   => 'required|string|max:255',
        ]);


        $setting = Setting::find($id);

        // رفع الملفات وحفظ المسارات
        $files = ['logo'];
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $image = $request->file($file);
                $newImage = time() . $image->getClientOriginalName();
                $image->move('uploads/setting', $newImage);
                $setting->$file = 'uploads/setting/' . $newImage;
            }
        }

        $setting->company_name = $request->input('company_name');
        $setting->save();

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }




}
