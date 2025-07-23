<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function city()
  {
    return $this->belongsTo(City::class);
  }

  public function group()
  {
    return $this->belongsTo(Group::class);
  }
}
