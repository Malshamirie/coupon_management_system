<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function container()
{
    return $this->belongsTo(Container::class, 'container_id');
}

public function clients()
{
    return $this->hasMany(UserCode::class);
}

public function UserCodes()
{
    return $this->hasMany(UserCode::class);
}


}
