<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->text(30),
            "category" => $this->faker->text(10),
            "picture" => $this->faker->imageUrl(),
            "price" => $this->faker->numberBetween(5, 10000),
            "quantity" => $this->faker->numberBetween(-1, 200),
            "description" => $this->faker->text()
        ];
    }
}
