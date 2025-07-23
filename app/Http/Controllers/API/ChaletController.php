<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chalet;
use Illuminate\Http\Request;

class ChaletController extends Controller
{
    public function index()
    {
        // الحصول على جميع الشاليهات
        $chalets = Chalet::all();

        // إعادة النتائج كـ JSON
        return response()->json($chalets);
    }





    public function show($id)
    {
        // البحث عن شاليه بواسطة المعرف
        $chalet = Chalet::find($id);

        if (!$chalet) {
            return response()->json(['message' => 'Chalet not found'], 404);
        }

        // إعادة النتيجة كـ JSON
        return response()->json($chalet);
    }


}
