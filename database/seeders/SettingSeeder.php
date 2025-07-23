<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{

    public function run()
    {
        DB::table('settings')->insert([
            'logo' => 'logo.png',
            'company_name' => 'aldahamn',
        ]);

    }
}
