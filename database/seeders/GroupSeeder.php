<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
  public function run(): void
  {
    $groups = [
      ['name' => 'المجموعة الذهبية'],
      ['name' => 'المجموعة الفضية'],
      ['name' => 'المجموعة الماسية'],
    ];
    foreach ($groups as $group) {
      Group::create($group);
    }
  }
}