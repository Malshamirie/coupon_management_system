<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            ContainerSeeder::class,
            LoyaltyContainerSeeder::class, // إضافة seeder الحاويات الجديدة
            // ProductCodesSeeder::class,
            LoyaltyCardSeeder::class,
            CustomerSeeder::class,
            CitySeeder::class,
            GroupSeeder::class,
            BranchSeeder::class,
        ]);
    }
}
