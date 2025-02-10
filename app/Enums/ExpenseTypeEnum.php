<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ExpenseTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case PENGADAAN = 'Pengadaan';
    case PENGEMBANGAN = 'Pengembangan';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENGADAAN => 'Pengadaan',
            self::PENGEMBANGAN => 'Pengembangan',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENGADAAN => 'success',
            self::PENGEMBANGAN => 'info',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENGADAAN => 'heroicon-m-shopping-cart',
            self::PENGEMBANGAN => 'heroicon-m-wrench-screwdriver',
        };
    }
}
