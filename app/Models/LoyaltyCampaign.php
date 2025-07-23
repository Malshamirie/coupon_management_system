<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_card_id',
        'container_id',
        'campaign_name',
        'start_date',
        'end_date',
        'manager_name',
        'sending_method',
        'whatsapp_template_id',
        'whatsapp_image_url',
        'email_template',
        'additional_terms',
        'page_logo',
        'main_text',
        'sub_text',
        'after_form_text',
        'redirect_url',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // العلاقات
    public function loyaltyCard()
    {
        return $this->belongsTo(LoyaltyCard::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'container_id', 'container_id');
    }

    // Accessor للحصول على اسم البطاقة من العلاقة
    public function getCardNameAttribute()
    {
        return $this->loyaltyCard ? $this->loyaltyCard->name : null;
    }

    // Accessor للحصول على نص طريقة الإرسال
    public function getSendingMethodTextAttribute()
    {
        return $this->sending_method === 'whatsapp' ? 'واتساب' : 'بريد إلكتروني';
    }

    // Scopes
    public function scopeByCardType($query, $cardType)
    {
        return $query->whereHas('loyaltyCard', function ($q) use ($cardType) {
            $q->where('id', $cardType);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
