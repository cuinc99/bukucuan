<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Enums\TypeKeyEnum;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Pembeli',
                'key' => TypeKeyEnum::CUSTOMER->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Reseller',
                'key' => TypeKeyEnum::CUSTOMER->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Makanan',
                'key' => TypeKeyEnum::PRODUCT->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Minuman',
                'key' => TypeKeyEnum::PRODUCT->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Lainnya',
                'key' => TypeKeyEnum::PRODUCT->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Pengadaan',
                'key' => TypeKeyEnum::EXPENSE->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Pengembangan',
                'key' => TypeKeyEnum::EXPENSE->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Lainnya',
                'key' => TypeKeyEnum::EXPENSE->value,
                'user_id' => 2,
            ],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
