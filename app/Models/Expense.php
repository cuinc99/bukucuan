<?php

namespace App\Models;

use App\Enums\ExpenseTypeEnum;

class Expense extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'type' => ExpenseTypeEnum::class,
        ];
    }
}
