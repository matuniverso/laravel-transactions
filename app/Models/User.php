<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const REGULAR_USER = 1;
    const SHOPKEEPER_USER = 2;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getTypeAttribute(): string
    {
        return match ($this->attributes['type']) {
            self::REGULAR_USER => 'Normal',
            self::SHOPKEEPER_USER => 'Shopkeeper'
        };
    }

    public function account(): HasOne
    {
        return $this->hasOne(Account::class);
    }

    public function balance(): int
    {
        return $this->account->balance;
    }

    public function setBalance(int $amount): void
    {
        $this->account->update(['balance' => $amount]);
    }
}
