<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
        ];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
