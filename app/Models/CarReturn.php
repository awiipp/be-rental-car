<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarReturn extends Model
{
    protected $guarded = [
        'id',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function penalty(): BelongsTo
    {
        return $this->belongsTo(Penalty::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
