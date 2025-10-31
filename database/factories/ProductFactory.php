<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => ucfirst($this->faker->word()) . ' Medical Tool',
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 10000, 500000),
            'stock' => $this->faker->numberBetween(5, 50),
            'image' => 'default.png',
        ];
    }
}
