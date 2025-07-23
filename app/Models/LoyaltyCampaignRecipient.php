<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyCampaignRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_campaign_id',
        'customer_id',
        'phone_number',
        'status',
        'message_id',
        'error_message',
        'retry_count',
        'sent_at',
        'delivered_at',
        'failed_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    // العلاقات
    public function loyaltyCampaign()
    {
        return $this->belongsTo(LoyaltyCampaign::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Scopes للفلترة
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByCampaign($query, $campaignId)
    {
        return $query->where('loyalty_campaign_id', $campaignId);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }
} 
