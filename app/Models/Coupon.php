<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function status()
    {
        return $this->status == 1 ? trans('back.active') : trans('back.inactive');
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }
}
