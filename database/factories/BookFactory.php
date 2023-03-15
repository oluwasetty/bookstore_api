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
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => $this->faker->dateTimeThisDecade(),
        ];
    }
}
