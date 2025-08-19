<?php

namespace App\Exports;

use App\Models\LoyaltyCampaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LoyaltyCampaignExport implements FromCollection, WithHeadings, WithMapping
{
    protected $campaign;

    public function __construct(LoyaltyCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function collection()
    {
        return collect([$this->campaign]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'اسم البطاقة',
            'اسم الحملة',
            'اسم البطاقة',
            'تاريخ البداية',
            'تاريخ النهاية',
            'اسم المدير',
            'طريقة الإرسال',
            'معرف قالب الواتساب',
            'رابط صورة الواتساب',
            'قالب البريد الإلكتروني',
            'الشروط الإضافية',
            'شعار الصفحة',
            'النص الرئيسي',
            'النص الفرعي',
            'النص بعد النموذج',
            'رابط إعادة التوجيه',
            'الحالة',
            'تاريخ الإنشاء',
            'تاريخ التحديث',
            'إجمالي العملاء'
        ];
    }

    public function map($campaign): array
    {
        return [
            $campaign->id,
            $campaign->loyaltyCard->name ?? '',
            $campaign->campaign_name,
            $campaign->card_name,
            $campaign->start_date,
            $campaign->end_date,
            $campaign->manager_name,
            $campaign->sending_method_text,
            $campaign->whatsapp_template_id ?? '',
            $campaign->whatsapp_image_url ?? '',
            $campaign->email_template ?? '',
            $campaign->additional_terms ?? '',
            $campaign->page_logo ?? '',
            $campaign->main_text ?? '',
            $campaign->sub_text ?? '',
            $campaign->after_form_text ?? '',
            $campaign->redirect_url ?? '',
            $campaign->status_text,
            $campaign->created_at->format('Y-m-d H:i:s'),
            $campaign->updated_at->format('Y-m-d H:i:s'),
            $campaign->total_customers
        ];
    }
}
