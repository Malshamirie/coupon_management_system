<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'container_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'container_id');
    }
}