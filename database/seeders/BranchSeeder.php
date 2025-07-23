<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
  public function run(): void
  {
          $branches = [
      [
        'branch_number' => 'B001',
        'branch_name' => 'فرع الرياض الرئيسي',
        'contact_number' => '0111111111',
        'city_id' => 1,
        'area' => 'حي العليا',
        'google_map_link' => null,
        'group_id' => 1,
      ],
      [
        'branch_number' => 'B002',
        'branch_name' => 'فرع جدة',
        'contact_number' => '0122222222',
        'city_id' => 2,
        'area' => 'حي الشاطئ',
        'google_map_link' => null,
        'group_id' => 2,
      ],
    ];
    foreach ($branches as $branch) {
      Branch::create($branch);
    }
  }
}