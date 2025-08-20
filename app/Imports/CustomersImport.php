<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\Importable;

class CustomersImport implements ToModel, WithValidation, SkipsOnError
{
  use Importable;

  protected $containerId;
  protected $hasHeaders;

  public function __construct($containerId, $hasHeaders = false)
  {
    $this->containerId = $containerId;
    $this->hasHeaders = $hasHeaders;
  }

  public function model(array $row)
  {
    // إذا كان الملف يحتوي على عناوين، استخدم WithHeadingRow
    if ($this->hasHeaders) {
      $name = trim($row['name'] ?? $row['الاسم'] ?? '');
      $phone = trim($row['phone'] ?? $row['phone_number'] ?? $row['رقم_الهاتف'] ?? '');
      $email = trim($row['email'] ?? $row['البريد_الإلكتروني'] ?? '');
      $address = trim($row['address'] ?? $row['العنوان'] ?? '');
    } else {
      // إذا لم يكن هناك عناوين، استخدم الأعمدة بالترتيب
      $name = trim($row[0] ?? '');
      $phone = trim($row[1] ?? '');
      $email = trim($row[2] ?? '');
      $address = trim($row[3] ?? '');
    }

    // تجاهل الصفوف الفارغة
    if (empty($name) && empty($phone)) {
      return null;
    }

    return new Customer([
      'name' => $name,
      'phone' => $phone,
      'email' => !empty($email) ? $email : null,
      'address' => !empty($address) ? $address : null,
      'loyalty_container_id' => $this->containerId,
    ]);
  }

  public function rules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'phone' => 'required|string|max:255',
      'email' => 'nullable|email|max:255',
    ];
  }

  public function customValidationMessages()
  {
    return [
      'name.required' => 'الاسم مطلوب',
      'name.string' => 'الاسم يجب أن يكون نص',
      'name.max' => 'الاسم يجب أن لا يتجاوز 255 حرف',
      'phone.required' => 'رقم الهاتف مطلوب',
      'phone.string' => 'رقم الهاتف يجب أن يكون نص',
      'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 255 حرف',
      'email.email' => 'البريد الإلكتروني غير صحيح',
      'email.max' => 'البريد الإلكتروني يجب أن لا يتجاوز 255 حرف',
    ];
  }

  public function onError(\Throwable $e)
  {
    \Log::error('Excel import error: ' . $e->getMessage());
  }
}
