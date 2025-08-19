<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
  public function run(): void
  {
    $customers = [
      [
        'name' => 'عميل 1',
        'phone' => '0500000001',
        'email' => 'customer1@example.com',
        'address' => 'الرياض',
        'loyalty_container_id' => 1,
      ],
      [
        'name' => 'عميل 2',
        'phone' => '0500000002',
        'email' => 'customer2@example.com',
        'address' => 'جدة',
        'loyalty_container_id' => 1,
      ],
    ];
    foreach ($customers as $customer) {
      Customer::create($customer);
    }
  }
}