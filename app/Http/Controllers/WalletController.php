<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class WalletController extends Controller
{
    public function createWallet(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'bail|required|exists:users,id',
            'name'    => 'bail|unique:wallets,name|required|string|max:255',
        ]);

        $wallet = Wallet::create($validated);

        return response()->json($wallet, 201);
    }

    /**
     * @param Wallet $wallet
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWallet(Request $request, $walletId)
    {
        try {

            //using first user since no auth
            $wallet = Wallet::where('id', $walletId)
                ->where('user_id', User::first()->id)
                ->with('transactions')
                ->first();

            if (!$wallet) {
                return response()->json(['message' => 'Wallet not found'], 404);
            }

            return response()->json([
                'wallet' => $wallet,
                'transactions' => $wallet->transactions
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}