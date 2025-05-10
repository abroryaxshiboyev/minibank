<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
    ];
    
    protected static function booted()
    {
        static::creating(function ($account) {
            $account->account_number = self::generateUniqueAccountNumber();
        });
    }

    protected static function generateUniqueAccountNumber()
    {
        do {
            $number = mt_rand(1000000000, 9999999999); // 10-raqamli random
        } while (self::where('account_number', $number)->exists());

        return $number;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
