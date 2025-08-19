<?php

namespace Database\Seeders;

use App\Models\Container;
use Illuminate\Database\Seeder;
use App\Models\LoyaltyContainer;

class LoyaltyContainerSeeder extends Seeder
{
    public function run(): void
    {

        // إنشاء حاويات حملات الولاء
        LoyaltyContainer::create([
            'name' => 'حاوية حملات الولاء الأساسية',
            'description' => 'الحاوية الرئيسية لحملات الولاء',
            'is_active' => true,
        ]);

        LoyaltyContainer::create([
            'name' => 'حاوية حملات الولاء الموسمية',
            'description' => 'حاوية للحملات الموسمية والمناسبات',
            'is_active' => true,
        ]);

        LoyaltyContainer::create([
            'name' => 'حاوية حملات الولاء المميزة',
            'description' => 'حاوية للحملات المميزة والعملاء VIP',
            'is_active' => true,
        ]);
    }
}

