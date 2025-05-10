<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransferService
{
    public function transfer(User $sender, User $receiver, float $amount, ?string $description = null): Transaction
    {
        if ($amount <= 0) {
            throw ValidationException::withMessages(['amount' => 'Miqdor 0 dan katta bo‘lishi kerak.']);
        }

        return DB::transaction(function () use ($sender, $receiver, $amount, $description) {
            $senderAccount = $sender->account;
            $receiverAccount = $receiver->account;

            if (!$senderAccount || !$receiverAccount) {
                throw ValidationException::withMessages(['account' => 'Hisoblar topilmadi.']);
            }

            if ($senderAccount->balance < $amount) {
                throw ValidationException::withMessages(['balance' => 'Yetarli mablag‘ mavjud emas.']);
            }

            // Balanslarni yangilash
            $senderAccount->decrement('balance', $amount);
            $receiverAccount->increment('balance', $amount);

            // Tranzaksiyani yozish
            return Transaction::create([
                'sender_id'   => $sender->id,
                'receiver_id' => $receiver->id,
                'amount'      => $amount,
                'type'        => 'transfer',
                'status'      => 'completed',
                'description' => $description,
            ]);
        });
    }
}
