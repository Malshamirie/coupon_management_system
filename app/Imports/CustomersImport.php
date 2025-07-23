<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToModel, WithHeadingRow, WithValidation
{
  protected $containerId;

  public function __construct($containerId)
  {
    $this->containerId = $containerId;
  }

  public function model(array $row)
  {
    return new Customer([
      'name' => $row['name'] ?? $row['الاسم'] ?? '',
      'phone_number' => $row['phone_number'] ?? $row['رقم_الهاتف'] ?? '',
      'email' => $row['email'] ?? $row['البريد_الإلكتروني'] ?? null,
      'address' => $row['address'] ?? $row['العنوان'] ?? null,
      'container_id' => $this->containerId,
    ]);
  }

  public function rules(): array
  {
    return [
      'name' => 'required',
      'phone_number' => 'required',
      'email' => 'nullable|email',
    ];
  }

  public function customValidationMessages()
  {
    return [
      'name.required' => 'الاسم مطلوب',
      'phone_number.required' => 'رقم الهاتف مطلوب',
      'email.email' => 'البريد الإلكتروني غير صحيح',
    ];
  }
}
