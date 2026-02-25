<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Enums\TransactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        $user = User::create([
            'name' => 'fredrick mwaura',
            'email' => 'fredrick@mail.com',
            'password' => bcrypt('password')
        ]);

        // Create multiple wallets for the user
        $wallet1 = Wallet::create([
            'user_id' => $user->id,
            'name' => 'Main Wallet',
            'balance' => 1500.00
        ]);

        $wallet2 = Wallet::create([
            'user_id' => $user->id,
            'name' => 'Savings Wallet',
            'balance' => 5000.00
        ]);

        $wallet3 = Wallet::create([
            'user_id' => $user->id,
            'name' => 'Emergency Fund',
            'balance' => 2000.00
        ]);

        // Create transactions for Main Wallet
        Transaction::create([
            'wallet_id' => $wallet1->id,
            'type' => TransactionType::INCOME->value,
            'amount' => 2000.00,
            'description' => 'Salary deposit'
        ]);

        Transaction::create([
            'wallet_id' => $wallet1->id,
            'type' => TransactionType::EXPENSE->value,
            'amount' => 150.00,
            'description' => 'Grocery shopping'
        ]);

        Transaction::create([
            'wallet_id' => $wallet1->id,
            'type' => TransactionType::EXPENSE->value,
            'amount' => 350.00,
            'description' => 'Rent payment'
        ]);

        // Create transactions for Savings Wallet
        Transaction::create([
            'wallet_id' => $wallet2->id,
            'type' => TransactionType::INCOME->value,
            'amount' => 3000.00,
            'description' => 'Initial deposit'
        ]);

        Transaction::create([
            'wallet_id' => $wallet2->id,
            'type' => TransactionType::INCOME->value,
            'amount' => 2000.00,
            'description' => 'Bonus deposit'
        ]);

        // Create transactions for Emergency Fund
        Transaction::create([
            'wallet_id' => $wallet3->id,
            'type' => TransactionType::INCOME->value,
            'amount' => 1500.00,
            'description' => 'Emergency fund setup'
        ]);

        Transaction::create([
            'wallet_id' => $wallet3->id,
            'type' => TransactionType::INCOME->value,
            'amount' => 500.00,
            'description' => 'Additional emergency savings'
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('User: fredrick@mail.com / password');
        $this->command->info('Created 1 user, 3 wallets, and 7 transactions');
    }
}
