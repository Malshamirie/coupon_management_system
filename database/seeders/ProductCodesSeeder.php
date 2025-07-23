<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCode;

class ProductCodesSeeder extends Seeder
{
    public function run()
    {
        $generatedCodes = []; // لتخزين الأكواد التي تم توليدها مسبقًا

        for ($i = 0; $i < 1000; $i++) {
            do {
                $code = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
            } while (in_array($code, $generatedCodes)); // التأكد من أن الكود غير مكرر

            $generatedCodes[] = $code; // إضافة الكود إلى المصفوفة لمنع التكرار

            Coupon::create([
                'code'   => $code,
                'status' => 1,
                'container_id' => 1,
            ]);
        }
    }
}
