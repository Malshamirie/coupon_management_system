<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyContainer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function customers()
    {
        return $this->hasMany(Customer::class, 'loyalty_container_id');
    }

    public function loyaltyCampaigns()
    {
        return $this->hasMany(LoyaltyCampaign::class, 'loyalty_container_id');
    }



    public function getCampaignsCountAttribute()
    {
        return $this->loyaltyCampaigns()->count();
    }

    public function getCustomersCountAttribute()
    {
        return $this->customers()->count();
    }




    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}