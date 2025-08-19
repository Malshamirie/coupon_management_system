<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Customer::with('loyaltyContainer')->get();
    }

    public function headings(): array
    {
        return [
            'الاسم',
            'رقم الهاتف',
            'البريد الإلكتروني',
            'العنوان',
            'الكنتينر'
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->name,
            $customer->phone_number,
            $customer->email,
            $customer->address,
            $customer->loyaltyContainer->name ?? ''
        ];
    }
} 