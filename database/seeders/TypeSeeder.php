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
                'name' => 'Regular Customer',
                'key' => TypeKeyEnum::CUSTOMER->value,
                'user_id' => 2,
            ],
            [
                'name' => 'VIP Customer',
                'key' => TypeKeyEnum::CUSTOMER->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Electronics',
                'key' => TypeKeyEnum::PRODUCT->value,
                'user_id' => 2,
            ],
            [
                'name' => 'Accessories',
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
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
