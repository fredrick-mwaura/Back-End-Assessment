<?php

namespace App\Enums;

enum TransactionType: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
