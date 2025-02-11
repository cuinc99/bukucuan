<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Nasi Goreng Special',
                'description' => 'Nasi goreng dengan tambahan telur dan ayam',
                'purchase_price' => 15000,
                'selling_price' => 25000,
                'type_id' => 3, // Makanan
                'user_id' => 2
            ],
            [
                'name' => 'Mie Goreng Spesial',
                'description' => 'Mie goreng dengan tambahan bakso dan sayuran',
                'purchase_price' => 12000,
                'selling_price' => 20000,
                'type_id' => 3, // Makanan
                'user_id' => 2
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin segar',
                'purchase_price' => 3000,
                'selling_price' => 7000,
                'type_id' => 4, // Minuman
                'user_id' => 2
            ],
            [
                'name' => 'Es Jeruk',
                'description' => 'Jeruk peras segar dengan es',
                'purchase_price' => 4000,
                'selling_price' => 8000,
                'type_id' => 4, // Minuman
                'user_id' => 2
            ],
            [
                'name' => 'Tissue',
                'description' => 'Tissue makan',
                'purchase_price' => 10000,
                'selling_price' => 15000,
                'type_id' => 5, // Lainnya
                'user_id' => 2
            ],
            [
                'name' => 'Kotak Makanan',
                'description' => 'Kotak makanan untuk takeaway',
                'purchase_price' => 2000,
                'selling_price' => 3500,
                'type_id' => 5, // Lainnya
                'user_id' => 2
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
