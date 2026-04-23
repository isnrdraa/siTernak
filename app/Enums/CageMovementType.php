<?php

namespace App\Enums;

enum CageMovementType: string
{
    case Addition = 'addition';
    case Mortality = 'mortality';
    case Sale = 'sale';
    case Adjustment = 'adjustment';

    public function label(): string
    {
        return match ($this) {
            self::Addition => 'Penambahan',
            self::Mortality => 'Kematian',
            self::Sale => 'Penjualan',
            self::Adjustment => 'Penyesuaian',
        };
    }

    public function isIncrease(): bool
    {
        return match ($this) {
            self::Addition, self::Adjustment => true,
            default => false,
        };
    }
}
