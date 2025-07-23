<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Container;
use Illuminate\Database\Seeder;


class ContainerSeeder extends Seeder
{


    public function run(): void
    {
        Container::create([
            'name' => '  كوبونات الموظفين  ',
        ]);

        Container::create([
            'name' => '  كوبونات العملاء  ',
        ]);
    }
}
