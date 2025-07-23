<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoyaltyCard;

class LoyaltyCardSeeder extends Seeder
{
  public function run(): void
  {
    $cards = [
      [
        'slug' => 'gold',
        'name' => 'Gold',
        'description' => 'Gold loyalty card',
        'is_active' => true,
      ],
      [
        'slug' => 'silver',
        'name' => 'Silver',
        'description' => 'Silver loyalty card',
        'is_active' => true,
      ],
      [
        'slug' => 'diamond',
        'name' => 'Diamond',
        'description' => 'Diamond loyalty card',
        'is_active' => true,
      ],
    ];
    foreach ($cards as $card) {
      LoyaltyCard::updateOrCreate(['slug' => $card['slug']], $card);
    }
  }
}