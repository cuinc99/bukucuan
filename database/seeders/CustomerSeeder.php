<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Budi Santoso',
                'type_id' => 1,
                'user_id' => 2
            ],
            [
                'name' => 'Siti Rahma',
                'type_id' => 2,
                'user_id' => 2
            ],
            [
                'name' => 'Ahmad Wijaya',
                'type_id' => 1,
                'user_id' => 2
            ],
            [
                'name' => 'Dewi Kartika',
                'type_id' => 2,
                'user_id' => 2
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
