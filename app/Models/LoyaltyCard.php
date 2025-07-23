<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyCard extends Model
{
  use HasFactory;

  protected $guarded = [];

  // Relationships
  public function campaigns()
  {
    return $this->hasMany(LoyaltyCampaign::class);
  }

  public function getStatusTextAttribute()
  {
    return $this->is_active ? trans('back.active') : trans('back.inactive');
  }

  public function getImageUrlAttribute()
  {
    return $this->image ? asset('storage/' . $this->image) : asset('backend/assets/images/no-image.png');
  }
}
