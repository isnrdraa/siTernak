<?php

namespace App\Enums;

enum ExpenseCategory: string
{
    case Pakan = 'pakan';
    case Obat = 'obat';
    case Vaksin = 'vaksin';
    case Listrik = 'listrik';
    case TenagaKerja = 'tenaga_kerja';
    case Peralatan = 'peralatan';
    case Lainnya = 'lainnya';

    public function label(): string
    {
        return match ($this) {
            self::Pakan => 'Pakan',
            self::Obat => 'Obat & Vitamin',
            self::Vaksin => 'Vaksin',
            self::Listrik => 'Listrik & Air',
            self::TenagaKerja => 'Tenaga Kerja',
            self::Peralatan => 'Peralatan',
            self::Lainnya => 'Lainnya',
        };
    }
}
