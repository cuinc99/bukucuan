<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;

enum TypeKeyEnum: string implements HasLabel, HasColor, HasIcon
{
    case CUSTOMER = 'customer';
    case PRODUCT = 'product';
    case EXPENSE = 'expense';

    public function getLabel(): string
    {
        return match ($this) {
            self::CUSTOMER => 'Customer',
            self::PRODUCT => 'Product',
            self::EXPENSE => 'Expense',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::CUSTOMER => 'primary',
            self::PRODUCT => 'success',
            self::EXPENSE => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::CUSTOMER => 'heroicon-m-user-group',
            self::PRODUCT => 'heroicon-m-shopping-cart',
            self::EXPENSE => 'heroicon-m-wrench-screwdriver',
        };
    }
}
