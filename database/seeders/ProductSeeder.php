<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Termometer Digital',
                'description' => 'Termometer digital akurat untuk mengukur suhu tubuh.',
                'price' => 75000,
                'stock' => 25,
                'category_id' => 1,
            ],
            [
                'name' => 'Kursi Roda Lipat',
                'description' => 'Kursi roda lipat yang nyaman dan mudah dibawa bepergian.',
                'price' => 1500000,
                'stock' => 10,
                'category_id' => 2,
            ],
            [
                'name' => 'Alat Cek Gula Darah',
                'description' => 'Alat untuk mengukur kadar gula darah dengan hasil cepat.',
                'price' => 300000,
                'stock' => 20,
                'category_id' => 1,
            ],
            [
                'name' => 'Masker Medis 3 Lapis',
                'description' => 'Masker medis sekali pakai dengan perlindungan maksimal.',
                'price' => 35000,
                'stock' => 100,
                'category_id' => 3,
            ],
            [
                'name' => 'Stetoskop Dokter',
                'description' => 'Stetoskop profesional dengan suara jernih untuk pemeriksaan.',
                'price' => 250000,
                'stock' => 15,
                'category_id' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
