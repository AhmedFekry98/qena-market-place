<?php

namespace App\Enums;

enum BillingCycle: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public function label(): string
    {
        return match($this) {
            self::DAILY => 'Daily',
            self::WEEKLY => 'Weekly',
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
        };
    }

    public function getDaysCount(): int
    {
        return match($this) {
            self::DAILY => 1,
            self::WEEKLY => 7,
            self::MONTHLY => 30,
            self::YEARLY => 365,
        };
    }
}
