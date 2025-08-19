<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyCampaign extends Model
{
    use HasFactory;
    protected $guarded = [];

    // العلاقات
    public function loyaltyCard()
    {
        return $this->belongsTo(LoyaltyCard::class);
    }

    public function loyaltyContainer()
    {
        return $this->belongsTo(LoyaltyContainer::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'loyalty_container_id', 'loyalty_container_id');
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
