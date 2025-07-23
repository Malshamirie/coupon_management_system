<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
  public function run(): void
  {
    $cities = [
      ['name' => 'الرياض'],
      ['name' => 'جدة'],
      ['name' => 'مكة'],
      ['name' => 'الدمام'],
    ];
    foreach ($cities as $city) {
      City::create($city);
    }
  }
}