<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use App\Enums\TransactionType;

class TransactionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'wallet_id'   => 'required|exists:wallets,id',
            'type'        => 'required|in:' . implode(',', TransactionType::values()),
            'amount'      => 'required|numeric|min:0.01',
            'description' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($validated) {
            $wallet = Wallet::lockForUpdate()->findOrFail($validated['wallet_id']);

            $transaction = $wallet->transactions()->create($validated);

            if ($validated['type'] === TransactionType::INCOME->value) {
                $wallet->increment('balance', $validated['amount']);
            } else {
                $wallet->decrement('balance', $validated['amount']);
            }

            return response()->json($transaction, 201);
        });
    }
}
