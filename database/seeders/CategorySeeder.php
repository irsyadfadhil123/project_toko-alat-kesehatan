<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Alat Diagnostik', 'description' => 'Alat untuk pemeriksaan dan diagnosis.'],
            ['name' => 'Alat Bedah', 'description' => 'Peralatan medis untuk tindakan operasi.'],
            ['name' => 'Alat Laboratorium', 'description' => 'Peralatan untuk uji klinis dan laboratorium.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
