<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setAmountAttribute($amount): void
    {
        $this->attributes['amount'] = $amount * 100;
    }

    public function getAmountAttribute(): int|float
    {
        return $this->attributes['amount'] / 100;
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payer_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'receiver_id');
    }
}
