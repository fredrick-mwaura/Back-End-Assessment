<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;


// Routes (auth skipped for now)
Route::post('/users', [UserController::class, 'store']);

// User routes
Route::get('/users/profile', [UserController::class, 'getProfile']);

// Wallet routes
Route::post('/wallets', [WalletController::class, 'createWallet']);
Route::get('/wallets/{walletId}', [WalletController::class, 'getWallet']);

// Transaction routes
Route::post('/transactions', [TransactionController::class, 'store']);

// Health check
Route::get('/health', function () {
    return response()->json(['status' => 'running', 'timestamp' => now()]);
});
