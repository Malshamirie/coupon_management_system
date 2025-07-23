<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function code()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }

      public function campaign()
{
    return $this->belongsTo(Campaign::class);
}
}
