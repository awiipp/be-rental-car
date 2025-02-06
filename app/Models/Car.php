<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $guarded = [
        'id'
    ];

    public function carReturns(): HasMany
    {
        return $this->hasMany(CarReturn::class);
    }

    public function penalties(): HasMany
    {
        return $this->hasMany(Penalty::class);
    }

    public function rents(): HasMany
    {
        return $this->hasMany(Rent::class);
    }
}
