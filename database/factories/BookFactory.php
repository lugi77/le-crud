<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
   /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'genre' => $this->faker->word,
            'status' => $this->faker->randomElement(['To Read', 'Reading', 'Read']),
            'rating' => $this->faker->randomFloat(1, 0, 5),
        ];
    }
}
