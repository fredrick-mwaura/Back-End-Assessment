<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;

class UserController extends Controller
{
    /**
     * create user and wallet for user
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email'         
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // create wallet for user on success
        $wallet = Wallet::create([
            'user_id' => $user->id,
            'name' => 'Default Wallet'
        ]);

        return response()->json([$user, $wallet], 201)->with('success', 'User created successfully');
    }

    /**
     * @string User $user
     * @return JsonResponse
     */

    public function getProfile(User $user): JsonResponse 
    {
        //eager load wallet
        $user->load('wallets');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'wallets' => $user->wallets->map(function ($wallet) {
                return [
                    'id' => $wallet->id,
                    'name' => $wallet->name,
                    'balance' => $wallet->balance
                ];
            }),
            'total_balance' => $user->total_balance
        ]);
    }
}