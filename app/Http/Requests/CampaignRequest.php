<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampaignRequest extends FormRequest
{
    public function authorize()
    {
        // إذا في سياسة صلاحيات، نعدل هنا، حالياً نعطي تصريح
        return true;
    }

    public function rules()
    {
        /** @var \Illuminate\Http\Request $this */
        $campaignId = $this->route('campaign') ? $this->route('campaign')->id : null;

        $rules = [
            'name' => [
                'required',
                'string',
                Rule::unique('campaigns')->ignore($campaignId),
            ],
            // 'slug' => [
            //     'required',
            //     'string',
            //     Rule::unique('campaigns')->ignore($campaignId),
            // ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'manager_name' => 'required|string',
            'coupon_type' => ['required', Rule::in(['fixed', 'percentage', 'cashback', 'second_invoice_discount'])],
            'search_method' => ['required', Rule::in(['phone', 'email'])],
            'id_template' => 'nullable|string',
            'whatsapp_image_url' => 'nullable|string',
            'otp_required' => 'sometimes|boolean',
            'email_domain' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'beneficiary' => 'nullable|string',
            'beneficiary_manager' => 'nullable|string',
            'beneficiary_contact' => 'nullable|string',
            'terms' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_text' => 'nullable|string',
            'sub_text' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'redirect' => 'nullable|url',
            'container_id' => ['required', 'exists:containers,id'],
        ];

        // دومين الايميل مطلوب فقط لو طريقة البحث ايميل
        if ($this->input('search_method') === 'email') {
            $rules['email_domain'] = ['nullable', 'string', 'regex:/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'];
        } else {
            $rules['email_domain'] = ['nullable', 'string'];
        }


        if ($this->input('search_method') === 'phone') {
            $rules['whatsapp_image_url'] = ['required', 'string'];
            $rules['id_template'] = ['required', 'string'];
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الحملة مطلوب.',
            'name.unique' => 'اسم الحملة مستخدم من قبل، الرجاء اختيار اسم آخر.',
            'slug.required' => 'الرابط المختصر مطلوب.',
            'slug.unique' => 'الرابط المختصر مستخدم من قبل.',
            'start_date.required' => 'تاريخ البداية مطلوب.',
            'start_date.date' => 'تاريخ البداية غير صالح.',
            'end_date.required' => 'تاريخ النهاية مطلوب.',
            'end_date.date' => 'تاريخ النهاية غير صالح.',
            'end_date.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو مساوي لتاريخ البداية.',
            'manager_name.required' => 'اسم المدير مطلوب.',
            'coupon_type.required' => 'نوع القسيمة مطلوب.',
            'coupon_type.in' => 'نوع القسيمة غير صالح.',
            'search_method.required' => 'طريقة البحث مطلوبة.',
            'search_method.in' => 'طريقة البحث غير صحيحة.',
            'email_domain.required' => 'حقل دومين البريد الإلكتروني مطلوب عند اختيار طريقة البحث بالإيميل.',
            'id_template.required' => 'حقل معرف قالب الواتساب مطلوب عند اختيار طريقة البحث بالهاتف.',
            'whatsapp_image_url.required' => 'حقل صورة الواتساب مطلوب عند اختيار طريقة البحث بالهاتف.',
            'email_domain.regex' => 'صيغة دومين البريد الإلكتروني غير صحيحة.',
            'container_id.required' => 'اختيار الحاوية مطلوب.',
            'container_id.exists' => 'الحاوية المختارة غير موجودة.',
            // أضف رسائل أخرى حسب الحاجة
        ];
    }
}
