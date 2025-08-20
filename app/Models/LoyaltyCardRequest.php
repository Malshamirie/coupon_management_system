<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyCardRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_campaign_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'branch_id',
        'status',
        'requested_at',
        'processed_at',
        'notes'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';

    // Relationships
    public function loyaltyCampaign()
    {
        return $this->belongsTo(LoyaltyCampaign::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeByCampaign($query, $campaignId)
    {
        return $query->where('loyalty_campaign_id', $campaignId);
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('customer_name', 'like', "%{$search}%")
                ->orWhere('customer_phone', 'like', "%{$search}%")
                ->orWhere('customer_address', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        return __('back.loyalty_card_status_' . $this->status);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_APPROVED => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_DELIVERED => 'info',
            self::STATUS_PROCESSING => 'info',
            self::STATUS_COMPLETED => 'primary'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Methods
    public function approve()
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'processed_at' => now()
        ]);
    }

    public function reject($notes = null)
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'processed_at' => now(),
            'notes' => $notes
        ]);
    }

    public function deliver()
    {
        $this->update([
            'status' => self::STATUS_DELIVERED,
            'processed_at' => now()
        ]);
    }
}
