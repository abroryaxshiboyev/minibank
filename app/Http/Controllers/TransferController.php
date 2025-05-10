<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TransferService;

class TransferController extends Controller
{
    protected $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        $sender = auth()->user();
        $receiver = User::findOrFail($data['receiver_id']);

        $transaction = $this->transferService->transfer(
            $sender,
            $receiver,
            $data['amount'],
            $data['description'] ?? null
        );

        return redirect('/dashboard')->with('success', 'Pul muvaffaqiyatli yuborildi!');
    }
}
