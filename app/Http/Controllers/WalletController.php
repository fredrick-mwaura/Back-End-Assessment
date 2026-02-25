<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    public function createWallet(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'bail|required|exists:users,id',
            'name'    => 'bail|unique:wallets,name|required|string|max:255',
        ]);

        $wallet = Wallet::create($validated);

        return response()->json($wallet, 201)->with('success', 'Wallet created successfully');
    }

    /**
     * @param Wallet $wallet
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWallet(Request $request, $walletId): JsonResponse
    {
        $wallet = Wallet::where('id', $walletId)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$wallet) {
            return response()->json(['message' => 'Wallet not found'], 404);
        }

        $wallet->load('transactions');

        return response()->json([
            'wallet' => $wallet,
            'transactions' => $wallet->transactions
        ], 200);
    }
}