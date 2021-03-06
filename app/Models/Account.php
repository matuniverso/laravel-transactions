<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [];

    public $timestamps = false;

    public function setBalanceAttribute($balance): void
    {
        $this->attributes['balance'] = $balance * 100;
    }

    public function getBalanceAttribute(): int|float
    {
        return $this->attributes['balance'] / 100;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
