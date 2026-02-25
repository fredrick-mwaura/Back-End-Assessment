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
            'name'  => 'bail|required|string|max:255',
            'email' => 'bail|required|email|unique:users,email'         
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

    public function getProfile(): JsonResponse 
    {
        //get the first user(since no auth)
        $user = User::first();
        
        if (!$user) {
            return response()->json(['message' => 'No users found'], 404);
        }

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